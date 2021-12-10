<?php
namespace unions\library;

class Log
{
    private static $instance;

    const ERROR = 'error';
    const DEBUG = 'debug';

    private function __construct()
    {}

    public static function instance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function path(): string
    {
        $path = __DIR__ . '/../logs/' . date('Y-m-d/');

        !is_dir($path) && mkdir($path, 0777, true);

        return $path;
    }

    private function file(string $path, string $type): string
    {
        return $path . date('H_') . $type . '.log';
    }

    private function formatMessage(array $messages): string
    {
        $content = [];
        foreach ($messages as $key => $value) {
            if (is_json($value)) {
                $value = json_decode($value, true);
            }

            $content[] = $value;
        }

        return json_encode([
            'time' => date('Y-m-d H:i:s.u'),
            'content' => $content,
        ], JSON_UNESCAPED_UNICODE);
    }

    public function logTo($file, ...$messages)
    {
        $file = $this->path() . $file;
        $content = $this->formatMessage($messages);
        $this->write($content, self::DEBUG, $file);
    }

    public function error(...$messages)
    {
        $content = $this->formatMessage($messages);
        $this->write($content, self::ERROR);
    }

    public function debug(...$messages)
    {
        $content = $this->formatMessage($messages);
        $this->write($content, self::DEBUG);
    }

    private function write(string $content, string $type, string $file = '')
    {
        if (empty($content)) {
            return;
        }

        $file = empty($file) ? $this->file($this->path(), $type) : $file;

        error_log($content . PHP_EOL, 3, $file);
    }

    private function __clone()
    {}
}
