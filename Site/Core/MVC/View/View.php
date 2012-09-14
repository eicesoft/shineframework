<?php
namespace Core\MVC\View;

interface View {
	public function setView($view);
	public function assigns($vars);
	public function assign($key, $var);
	public function display();
}