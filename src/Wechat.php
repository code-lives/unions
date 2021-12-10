<?php
namespace unions;

use unions\wechat\Publics;
use unions\wechat\publics\GraphicMaterial;
use unions\wechat\publics\GroupSend;
use unions\wechat\publics\Media;
use unions\wechat\publics\Menu;
use unions\wechat\publics\TemplateMessage;

class Wechat
{
    private static $instance;

    private $services = [
        'public' => Publics::class, // 公众号
        'menu' => Menu::class, // 菜单管理
        'template' => TemplateMessage::class, // 模版消息
        'material' => GraphicMaterial::class, // 图文素材管理
        'media' => Media::class, // 多媒体文件上传
        'groupSend' => GroupSend::class, // 群发消息管理
    ];

    private $serviceInstances = [];
    /**
     * @var array
     */
    protected $config;

    private function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param array $config
     * @return Wechat
     */
    public static function getInstance(array $config = []): Wechat
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    /**
     * @param string $service
     * @return bool
     */
    private function serviceExists(string $service): bool
    {
        return array_key_exists($service, $this->services);
    }

    /**
     * @param string $service
     * @param array $config
     * @param boolean $forceNew
     * @return void|Publics|Menu
     */
    public function get(string $service, array $config = [], bool $forceNew = true)
    {
        $config = empty($config) ? $this->config : $config;
        if (!$this->serviceExists($service)) {
            return;
        }

        if (!isset($this->serviceInstances[$service]) || $forceNew === true) {
            $this->serviceInstances[$service] = $this->makeServiceInstance($this->services[$service], $config);
        }

        return $this->serviceInstances[$service];
    }

    private function makeServiceInstance($service, $config)
    {
        return new $service($config);
    }

    public function __call(string $name, $args)
    {
        return $this->get($name, reset($args));
    }

    private function __clone()
    {}
}
