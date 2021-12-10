<?php
namespace unions\wechat\publics;

use unions\library\Code;
use unions\library\Curl;
use unions\wechat\Publics;

class ApiManager extends Publics
{
    public function clearQuota(string $accessToken, string $cgiPath)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=%s&cgi_path=%s';
        $url = sprintf($url, $accessToken, $cgiPath);

        return Curl::instance()->data(json_encode(['app_id' => $this->config['app_id']]))->post($url)->result($this->responseParse());
    }

    public function quota(string $accessToken, string $cgiPath)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/openapi/quota/get?access_token=%s';
        $url = sprintf($url, $accessToken);

        return Curl::instance()->data(json_encode(['cgi_path' => $cgiPath]))->post($url)->result($this->responseParse());
    }

    public function queryRid(string $accessToken, string $rid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/openapi/rid/get?access_token=%s';
        $url = sprintf($url, $accessToken);

        return Curl::instance()->data(json_encode(['rid' => $rid]))->post($url)->result($this->responseParse());
    }

    protected function responseParse($customCallback = null)
    {
        return null === $customCallback ? function ($curlResponse) {
            $response = json_decode($curlResponse['response'], true);
            if (json_last_error() || !is_array($response) || empty($response)) {
                return result(Code::WECHAT_CURL_RESULT_PARSE, $curlResponse['id']);
            }

            if ($response['errcode'] !== 0) {
                return result(Code::WECHAT_RESPONSE_ERROR, $response['errmsg']);
            }

            return result();
        } : $customCallback;
    }
}
