<?php

namespace Gcalc\Controller;

/**
 * Interface IController
 * @package Raitocz\Gcalc\Controller
 */
interface IController {

	/**
	 * Each controller in this app is forced to tell how to render outputs
	 * @param $output
	 * @return void
	 */
	public function render($output);
}