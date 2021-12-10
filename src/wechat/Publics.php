<?php
namespace unions\wechat;

use unions\library\Code;
use unions\library\Curl;
use unions\library\Result;

class Publics
{
    protected $config = [
        'app_id' => '',
        'secret' => '',
        'token' => '',
    ];

    /**
     * @param array $wechatConfig
     */
    public function __construct(array $wechatConfig)
    {
        if (!isset($wechatConfig['public'])) {
            $wechatConfig['public'] = $wechatConfig;
        }

        if ($this->authConfig($wechatConfig['public'])) {
            $this->setConfig($wechatConfig['public']);
        }
    }

    /**
     * @param array $config
     * @return bool
     */
    private function authConfig(array $config): bool
    {
        if (!array_key_exists('appid', $config)) {
            return false;
        }

        if (!array_key_exists('secret', $config)) {
            return false;
        }

        return !(empty($config['appid']) || empty($config['secret']));
    }

    private function setConfig(array $config)
    {
        $this->config = [
            'app_id' => $config['appid'],
            'secret' => $config['secret'],
        ] + $this->config;
    }

    /**
     * 从微信获取公众号AccessToken
     * @return Result|mixed
     */
    public function accessToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
        $url = sprintf($url, $this->config['app_id'], $this->config['secret']);
        return Curl::instance()->get($url)->result($this->responseParse());
    }

    public function ips(string $accessToken)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/get_api_domain_ip?access_token=%s';
        $url = sprintf($url, $accessToken);

        return Curl::instance()->get($url)->result($this->responseParse());
    }

    /**
     * @param string $accessToken
     * @return mixed|Result
     */
    public function callbackIps(string $accessToken)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=%s';
        $url = sprintf($url, $accessToken);

        return Curl::instance()->get($url)->result($this->responseParse());
    }

    protected function responseParse($customCallback = null)
    {
        return null === $customCallback ? function (array $curlRequest) {
            $response = json_decode($curlRequest['response'], true);

            if (json_last_error() || !is_array($response) || empty($response)) {
                return result(Code::WECHAT_CURL_RESULT_PARSE, $curlRequest['id']);
            }

            if (array_key_exists('errcode', $response) && $response['errcode'] !== 0) {
                return result(Code::WECHAT_RESPONSE_ERROR, sprintf('%s [%s]', $response['errmsg'], $curlRequest['id']));
            }

            return result(Code::SUCCESS, $response);
        } : $customCallback;
    }
}
