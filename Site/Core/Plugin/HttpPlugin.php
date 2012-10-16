<?php
namespace Core\Plugin;

/**
 * 设置HTTP头信息等
 */
class HttpPlugin implements IPlugin
{
    /**
     * 插件注册
     * @return mixed
     */
    public function registry()
    {

    }

    /**
     * 插件执行
     * @return mixed
     */
    public function execute()
    {

    }

    public function endDispatcher()
    {

    }

    public function endRouter()
    {

    }

    public function endView($view)
    {
        return $view;
    }

    public function startDispatcher()
    {

    }

    public function startRouter()
    {

    }

    public function startView($viewData)
    {

    }
}
