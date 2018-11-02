<?php

namespace Gcalc\Service;
use Gcalc\Exception\Service\ServiceNameRequiredException;
use Gcalc\Exception\Service\ServiceNotFoundException;

/**
 * Class ServiceContainer
 * This class does manual loading of services. I'm not going to invent whole framework with routing and autowiring just
 * to show how "nicely" things can be done :)
 *
 * @package Gcalc\Service
 */
class ServiceContainer {

	/** @var IService[] */
	protected $services;

	/**
	 * ServiceContainer constructor does the manual something-like-wiring.
	 */
	public function __construct() {
		$this->services = array(
			DataProviderService::class => new DataProviderService(),
			GuessCalculatorService::class => new GuessCalculatorService()
		);
	}

	/**
	 * This is not the greatest example of passing the references but I hope that this solutions is ok for the purpose
	 * of this app/exercise.
	 *
	 * @param $name
	 * @return mixed
	 * @throws ServiceNameRequiredException
	 * @throws ServiceNotFoundException
	 */
	public function getService($name){
		if(!trim($name)){
			throw new ServiceNameRequiredException();
		}

		if(isset($this->services[$name])){
			return $this->services[$name];
		}else{
			throw new ServiceNotFoundException();
		}
	}
}