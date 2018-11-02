<?php

namespace Gcalc\Controller\Render;

/**
 * Trait JsonRenderTrait
 * @package Raitocz\Gcalc\Controller\Render
 */
trait JsonRenderTrait {

	/**
	 * Converts data to JSON and outputs
	 * @param $output
	 */
	public function renderJson($output) {
		header('Content-Type: application/json');
		echo(json_encode($output));
	}
}