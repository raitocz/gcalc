<?php

/**
 * Class GuessCalculator
 */
class GuessCalculator {

	const GUESS_AVERAGE = 1;
	const GUESS_MIN = 2;
	const GUESS_LAST = 3;

	/** @var Customer */
	protected static $customer;

	/** @var int */
	protected static $modifier;

	/**
	 * @param $customer
	 * @param int $modifier
	 * @return string
	 * @throws Exception
	 */
	public static function getGuess($customer, $modifier = self::GUESS_AVERAGE): string {
		self::$customer = new Customer($customer);
		self::$modifier = $modifier;

		return 'Customer ' . self::$customer->getId() . ' should make new order on ' .
			self::calcGuess()->format('Y-m-d') . '<br />';
	}

	/**
	 * @return DateTime
	 * @throws Exception
	 */
	protected static function calcGuess(): DateTime {
		$daysOverTotal = $timesOver = $calcDaysOver = $expiryDays = 0;
		$minDaysOver = NULL;

		/** @var Order $order */
		foreach (self::$customer->getOrders() as $order) {
			$expiryDays = $order->getTotalExpiryDays();

			if (isset($lastOrderDate)) {
				/** @var $lastOrderDate DateTime */
				$customerDaysPreference = $lastOrderDate->diff($order->getCreatedAt())->days;

				if ($customerDaysPreference > $expiryDays) {
					$daysOver = $customerDaysPreference - $expiryDays;
					$minDaysOver = $minDaysOver === NULL ? $daysOver :
						($minDaysOver > $daysOver ? $daysOver : $minDaysOver);
					$daysOverTotal += $daysOver;
					$timesOver++;
				}
			}
			/** @var DateTime $lastOrderDate */
			$lastOrderDate = $order->getCreatedAt();
		}

		if ($timesOver) {
			if (self::$modifier == self::GUESS_AVERAGE) {
				$calcDaysOver = $daysOverTotal / $timesOver;
			}
			elseif (self::$modifier == self::GUESS_MIN) {
				$calcDaysOver = $minDaysOver;
			}
			elseif (self::$modifier == self::GUESS_LAST) {
				$calcDaysOver = $daysOver;
			}
		}

		return self::getNextOrderDate($lastOrderDate, $expiryDays + $calcDaysOver);
	}

	/**
	 * @param DateTime $lastOrderDate
	 * @param int $daysToNext
	 * @return DateTime
	 * @throws Exception
	 */
	protected static function getNextOrderDate(DateTime $lastOrderDate, int $daysToNext = 0): DateTime {
		return $lastOrderDate->add(new DateInterval('P' . $daysToNext . 'D'));
	}
}