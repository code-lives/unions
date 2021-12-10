<?php
namespace unions\library;

class Code
{
    const SUCCESS = 200;

    const WECHAT_CURL_RESULT_PARSE = 1000000; // 微信接口响应格式不是json-array，解析错误
    const WECHAT_RESPONSE_ERROR = 1000001; // 微信响应errcode不为0或不应该返回errcode的接口返回了errcode[access_token]
}
