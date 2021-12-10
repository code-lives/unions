<?php

use unions\library\Code;
use unions\library\Log;
use unions\library\Result;

if (!function_exists('dd')) {
    /**
     *
     */
    function dd(...$args)
    {
        echo '<pre>';
        print_r($args);
        echo '<pre>';
        exit;
    }
}

if (!function_exists('union_error')) {
    function union_error(...$messages)
    {
        return call_user_func_array([Log::instance(), 'error'], $messages);
    }
}

if (!function_exists('union_debug')) {
    function union_debug(...$messages)
    {
        return call_user_func_array([Log::instance(), 'debug'], $messages);
    }
}

if (!function_exists('union_logto')) {
    function union_logto(string $file, ...$messages)
    {
        array_unshift($messages, $file);

        return call_user_func_array([Log::instance(), 'logTo'], $messages);
    }
}

if (!function_exists('result')) {
    function result($code = Code::SUCCESS, $data = null)
    {
        return new Result($code, $data);
    }
}

if (!function_exists('data_get')) {
    function data_get(array $target, $key, $default = null)
    {
        if (empty($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        foreach ($key as $i => $segment) {
            unset($key[$i]);

            if (is_null($segment)) {
                return $target;
            }

            if ($segment === '*') {
                $result = [];

                foreach ($target as $item) {
                    $result[] = data_get($item, $key);
                }

                return in_array('*', $key) ? Arr::collapse($result) : $result;
            }

            if (array_key_exists($segment, $target)) {
                $target = $target[$segment];
            } else {
                return $default;
            }

        }

        return $target;
    }
}

if (!function_exists('is_json')) {
    function is_json($data): bool
    {
        if (!is_string($data)) {
            return false;
        }

        $decode = json_decode($data, true);

        return !(!is_array($decode) || json_last_error());
    }
}

if (!function_exists('uniqueID')) {
    function uniqueID()
    {
        $md5 = md5(microtime(true) . rand(0, 999999));
        $unid = [substr($md5, 0, 8), substr($md5, 8, 4), substr($md5, 12, 4), substr($md5, 16, 4), substr($md5, 20)];

        return join('-', $unid);
    }
}
