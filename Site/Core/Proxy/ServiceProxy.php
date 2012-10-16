<?php
namespace Core\Proxy;

class ServiceProxy extends Proxy
{
    protected function getClassName()
    {
        return 'App\\Service\\' . $this->proxyName;
    }
}
