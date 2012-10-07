<?php
namespace Core\Proxy;

/**
 * 模型代理类
 */
class ModelProxy extends Proxy
{
	protected function _getClassName()
	{
		return 'App\\Model\\' . $this->proxyName;
	}
}