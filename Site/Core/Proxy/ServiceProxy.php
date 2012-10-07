<?php
namespace Core\Proxy;

class ServiceProxy extends Proxy
{
	protected function _getClassName()
	{
		return 'App\\Service\\' . $this->proxyName;
	}
}