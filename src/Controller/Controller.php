<?php

namespace Gcalc\Controller;

use Gcalc\Service\ServiceContainer;

/**
 * Class Controller
 * @package Gcalc\Controller
 */
abstract class Controller implements IController {

	/** @var ServiceContainer */
	protected $serviceContainer;

	/**
	 * Controller constructor.
	 * @param ServiceContainer $serviceContainer
	 */
	public function __construct(ServiceContainer $serviceContainer) {
		$this->serviceContainer = $serviceContainer;
	}
}