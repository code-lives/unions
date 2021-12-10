<?php
namespace unions\wechat\publics;

use unions\library\Curl;
use unions\library\Result;
use unions\wechat\Publics;

/**
 * 自定义菜单管理
 * https://developers.weixin.qq.com/doc/offiaccount/Custom_Menus/Creating_Custom-Defined_Menu.html
 */
class Menu extends Publics
{
    // 创建自定义菜单
    /**
     * @param string $accessToken
     * @param array $menus
     * @return mixed|Result
     */
    public function create(string $accessToken, array $menus)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($menus, JSON_UNESCAPED_UNICODE))->post($url)->result($this->responseParse());
    }

    // 删除所有自定义菜单（包括默认菜单和全部个性化菜单）
    public function delete(string $acccessToken)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=%s', $acccessToken);

        return Curl::instance()->post($url)->result($this->responseParse());
    }

    // 获取默认菜单和全部个性化菜单信息
    public function query(string $accessToken)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=%s', $accessToken);

        return Curl::instance()->post($url)->result($this->responseParse());
    }

    // 创建个性化菜单
    public function specialCreate(string $accessToken, array $menus)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($menus, JSON_UNESCAPED_UNICODE))->post($url)->result($this->responseParse());
    }

    // 删除个性化菜单
    public function specialDelete(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data, JSON_UNESCAPED_UNICODE))->post($url)->result($this->responseParse());
    }

    // 测试个性化菜单匹配结果
    public function specialTestMatch(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/menu/trymatch?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data, JSON_UNESCAPED_UNICODE))->post($url)->result($this->responseParse());
    }

    // 获取自定义菜单配置[查询自定义菜单的结构、获取默认菜单和全部个性化菜单信息]
    public function specials(string $accessToken)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/menu/get?access_token=%s', $accessToken);

        return Curl::instance()->get($url)->result($this->responseParse());
    }
}
