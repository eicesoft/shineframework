<?php
namespace Core\Event;

/**
 * 事件管理器
 */
class EventManager
{
    /**
     * @var EventManager
     */
    private static $instance = null;

    /**
     * @static
     * @return EventManager
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new EventManager();
        }

        return self::$instance;
    }


    private $events;

    private function __construct()
    {
        $this->events = array();
    }

    /**
     * 注册事件
     * @param string $eventName
     */
    public function registry($eventName)
    {
        if (isset($this->events[$eventName])) {
            $this->events[$eventName] = new $eventName();
        }
    }

    public function trgger($eventName, $params)
    {
        if (isset($this->events[$eventName])) {
            $this->events[$eventName]->execute($params);
        }
    }
}
