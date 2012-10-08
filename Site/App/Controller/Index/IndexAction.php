<?php
namespace App\Controller\Index;

use Core\MVC\Controller\Action;

/**
 * Demo index
 */
class IndexAction extends Action
{
	/**
	 * @var \App\Service\TestService
	 */
	protected $TestService;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $param
	 * @return array
	 */
	public function execute($param)
	{
		var_dump($this->TestService->test());

		var_dump($this->TestService->test2());

//		var_dump($this);
		return array(
			'title' => 'MVC',
			'a' => 'test mvc',
		);
	}
}