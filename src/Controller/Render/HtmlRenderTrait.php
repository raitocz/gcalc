<?php

namespace Gcalc\Controller\Render;

/**
 * Trait HtmlRenderTrait
 * @package Raitocz\Gcalc\Controller\Render
 */
trait HtmlRenderTrait {

	/**
	 * @param $output
	 */
	public function renderHtml($output) {
		header('Content-Type: application/html');
		echo($output);
	}
}