<?php

require_once('../../DataProvider.php');

/**
 * Init variables & constants
 * ---------------------------------------------------------------------------------------------------------------------
 */

/**
 * You can pick the guess modifier as follows:
 * GUESS_AVERAGE - average of days the lenses were "over" their expire in history
 * GUESS_MIN - lowest number of days over expiry in history
 * GUESS_LAST - days between last orders over expiry
 */
const GUESS_AVERAGE = 1;
const GUESS_MIN = 2;
const GUESS_LAST = 3;

$goods = array(
	1 => 180,    // Biofinity (6 lenses)
	2 => 90,    // Biofinity (3 lenses)
	3 => 30    // Focus Dailies (30 lenses)
);

$customers = DataProvider::getCustomersOrders();

/**
 * Prepare methods
 * ---------------------------------------------------------------------------------------------------------------------
 */

/**
 * From the Task description it looks like that every order placed is just for one lenses type and assumes that customer
 * will not buy multiple types/powers. I will ignore the fact that the order can consist of multiple types and different
 * powers for whatever reasons (like: friend lost one so I will also buy additional pack of Focus Dailies.
 * @param array $goods
 * @param array $order
 * @return int
 */
function getExpiryDays(array $goods, array $order): int {
	// This is cheap cheat. Viz. description of this method.
	$lensDays = $goods[$order[0][0]];

	return $lensDays * $order[0][1];
}

/**
 * @param array $goods
 * @param array $orders
 * @param int $guessModifier
 * @return DateTime
 * @throws Exception
 */
function getNextOrderGuess(array $goods, array $orders, int $guessModifier = GUESS_AVERAGE): DateTime {
	$daysOverTotal = $timesOver = $calcDaysOver = $expiryDays = 0;
	$minDaysOver = NULL;

	foreach ($orders as $date => $order) {
		$expiryDays = getExpiryDays($goods, $order);

		if (isset($lastOrderDate)) {
			/** @var DateTime $thisOrderDate */
			$thisOrderDate = new DateTime($date);
			/** @var $lastOrderDate DateTime */
			$customerDaysPreference = $lastOrderDate->diff($thisOrderDate)->days;

			if ($customerDaysPreference > $expiryDays) {
				$daysOver = $customerDaysPreference - $expiryDays;
				$minDaysOver = $minDaysOver === NULL ? $daysOver :
					($minDaysOver > $daysOver ? $daysOver : $minDaysOver);
				$daysOverTotal += $daysOver;
				$timesOver++;
			}
		}
		/** @var DateTime $lastOrderDate */
		$lastOrderDate = new DateTime($date);
	}

	if ($timesOver) {
		if ($guessModifier == GUESS_AVERAGE) {
			$calcDaysOver = $daysOverTotal / $timesOver;
		}elseif($guessModifier == GUESS_MIN){
			$calcDaysOver = $minDaysOver;
		}elseif($guessModifier == GUESS_LAST){
			$calcDaysOver = $daysOver;
		}
	}

	return getNextOrderDate($lastOrderDate, $expiryDays + $calcDaysOver);
}

/**
 * @param DateTime $lastOrderDate
 * @param int $daysToNext
 * @return DateTime
 * @throws Exception
 */
function getNextOrderDate(DateTime $lastOrderDate, int $daysToNext = 0): DateTime {
	return $lastOrderDate->add(new DateInterval('P' . $daysToNext . 'D'));
}

/**
 * Main
 * ---------------------------------------------------------------------------------------------------------------------
 */
try {
	$customerId = 0;
	foreach ($customers as $customer) {
		$guessDays = getNextOrderGuess($goods, $customer, GUESS_AVERAGE);
		echo('Customer ' . $customerId . ' should make new order on ' . $guessDays->format('Y-m-d') . '<br />');
		$customerId++;
	}
} catch (Exception $ex) {
	echo('Something went wrong: ' . $ex->getCode() . ' - ' . $ex->getMessage());
}
