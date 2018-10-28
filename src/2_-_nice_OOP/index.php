<?php

require_once('../../DataProvider.php');
require_once('Customer.php');
require_once('Order.php');
require_once('Lenses.php');
require_once('GuessCalculator.php');

/**
 * Main
 * ---------------------------------------------------------------------------------------------------------------------
 */
try {
	$customers = DataProvider::getCustomersOrders();

	foreach($customers as $customer){
		echo(GuessCalculator::getGuess($customer));
	}
} catch (Exception $ex) {
	echo('Something went wrong: ' . $ex->getCode() . ' - ' . $ex->getMessage());
}
