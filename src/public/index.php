<?php
// I will use this index file as bootstrap point, init containers, DI, routing etc.

/** We will use Composer autoloader */
require '../../vendor/autoload.php';

try{
	/** @var \Gcalc\Service\ServiceContainer $serviceContainer */
	$serviceContainer = new \Gcalc\Service\ServiceContainer();

	// Yep, some very basic DI here, just as an example, not perfect but will do the trick for us now.
	$controller = new \Gcalc\Controller\DefaultController($serviceContainer);

	// Manual routing, we will call  the one and only route on our one and only controller.
	// I could get the services from the container here and pass them to the action but I will leave it to controller.
	$controller->runCalcAction();

}catch(Exception $ex){
	echo('Something went wrong: '. get_class($ex) .' - '. $ex->getMessage() . ' ('. $ex->getCode() .')');
}
