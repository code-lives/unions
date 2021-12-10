<?php
namespace unions\library;

class Curl
{
    private $options = [
        CURLOPT_HEADER => 0,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ];

    private $id;

    private $data = null;

    private $header = [];

    private $curl;

    private $ssl = false;

    private $timeout = 30;

    private $mulTimeOut = 0;

    private $request = [
        'info' => [],
        'options' => [],
        'response' => '',
        'error' => [],
    ];

    private function __construct()
    {
        $this->id = uniqueID();
        $this->curl = curl_init();
    }

    /**
     * @return Curl
     */
    public static function instance(): Curl
    {
        return new self;
    }

    /**
     * @param int $key
     * @param $value
     * @return $this
     */
    public function option(int $key, $value): Curl
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function addOptions(array $options): Curl
    {
        foreach ($options as $option => $value) {
            $this->option($option, $value);
        }

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function data($data): Curl
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $header
     * @return $this
     */
    public function header(string $header): Curl
    {
        $this->header[] = $header;

        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function addHeaders(array $headers): Curl
    {
        $this->header = array_merge($this->header, $headers);

        return $this;
    }

    /**
     * @param int $timeout
     * @return $this
     */
    public function timeout(int $timeout = 30): Curl
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param int $timeout
     * @return $this
     */
    public function mulTimeOut(int $timeout = 0): Curl
    {
        $this->mulTimeOut = $timeout;

        return $this;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function ssl(string $host): Curl
    {
        if ($host === 'false' || empty($host)) {
            $this->ssl = false;
        } else {
            $this->ssl = $host;
        }

        return $this;
    }

    /**
     * @param string $url
     * @param bool $query
     * @return $this
     */
    public function get(string $url, bool $query = true): Curl
    {
        if ($query === true && !empty($this->data)) {
            if (strpos($url, '?') !== false) {
                if (substr($url, -1) === '?') {
                    $url .= http_build_query($this->data);
                } else {
                    $url .= '&' . http_build_query($this->data);
                }

            } else {
                $url .= '?' . http_build_query($this->data);
            }
        }

        $options = [CURLOPT_URL => $url];

        return $this->send($options + $this->options);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function post(string $url): Curl
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $this->data,
        ];

        return $this->send($options + $this->options);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function put(string $url): Curl
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $this->data,
        ];

        return $this->send($options + $this->options);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function delete(string $url): Curl
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => $this->data,
        ];

        return $this->send($options + $this->options);
    }

    /**
     * @param $name
     * @param $args
     * @return $this|Curl|void
     */
    public function __call($name, $args)
    {
        if (count($args) > 0) {
            $options = [
                CURLOPT_URL => $args[0],
                CURLOPT_CUSTOMREQUEST => strtoupper($name),
                CURLOPT_POSTFIELDS => $this->data,
            ];

            return $this->send($options + $this->options);
        }
    }

    /**
     * @param array $options
     * @return $this
     */
    protected function send(array $options): Curl
    {
        if ($this->ssl !== false) {
            $options[CURLOPT_SSL_VERIFYPEER] = true;
            $options[CURLOPT_SSL_VERIFYHOST] = $this->ssl;
        }
        $options += [
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_TIMEOUT_MS => $this->mulTimeOut,
            CURLOPT_HTTPHEADER => $this->header,
        ];

        curl_setopt_array($this->curl, $options);
        $response = curl_exec($this->curl);
        $this->request = [
            'id' => $this->id,
            'info' => curl_getinfo($this->curl),
            'options' => $options,
            'response' => $response,
            'error' => [
                'error' => curl_error($this->curl),
                'errno' => curl_errno($this->curl),
            ],
        ];
        curl_close($this->curl);

        $this->printToLog($this->request);

        return $this;
    }

    public function result($callback = null)
    {
        return is_callable($callback) ? $callback($this->request) : $this->request['response'];
    }

    /**
     * @return array
     */
    public function request(): array
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    private function __clone()
    {}

    private static function printToLog($request)
    {
        union_logto(date('H_') . 'CURL', $request);
    }
}
