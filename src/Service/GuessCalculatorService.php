<?php

namespace Gcalc\Service;

use Gcalc\Entity\Customer;
use Gcalc\Entity\Order;
use Exception;
use DateTime;
use DateInterval;
use Gcalc\Exception\Service\LensExpiryDataMissing;

/**
 * Class GuessCalculator
 */
class GuessCalculatorService implements IService {

	const GUESS_AVERAGE = 1;
	const GUESS_MIN = 2;
	const GUESS_LAST = 3;

	/** @var Customer */
	protected $customer;

	/** @var int */
	protected $modifier;

	/** @var array */
	protected $lensExpiry;

	/**
	 * @param array $customer
	 * @param int $id
	 * @param int $modifier
	 * @return DateTime
	 * @throws Exception
	 */
	public function getGuess(array $customer, int $id, $modifier = self::GUESS_AVERAGE): DateTime {
		return self::calcGuess(new Customer($customer, $id), $modifier);
	}

	/**
	 * @param Customer $customer
	 * @param $modifier
	 * @return DateTime
	 * @throws Exception
	 */
	protected function calcGuess(Customer $customer, $modifier): DateTime {
		$daysOverTotal = $timesOver = $calcDaysOver = $expiryDays = 0;
		$minDaysOver = NULL;

		/** @var Order $order */
		foreach ($customer->getOrders() as $order) {
			$expiryDays = $order->getTotalExpiryDays($this->getLensExpiry());

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
			if ($modifier == self::GUESS_AVERAGE) {
				$calcDaysOver = $daysOverTotal / $timesOver;
			}
			elseif ($modifier == self::GUESS_MIN) {
				$calcDaysOver = $minDaysOver;
			}
			elseif ($modifier == self::GUESS_LAST) {
				$calcDaysOver = $daysOver;
			}
		}

		return $this->getNextOrderDate($lastOrderDate, $expiryDays + $calcDaysOver);
	}

	/**
	 * @param DateTime $lastOrderDate
	 * @param int $daysToNext
	 * @return DateTime
	 * @throws Exception
	 */
	protected function getNextOrderDate(DateTime $lastOrderDate, int $daysToNext = 0): DateTime {
		return $lastOrderDate->add(new DateInterval('P' . $daysToNext . 'D'));
	}

	/**
	 * @return array
	 * @throws LensExpiryDataMissing
	 */
	public function getLensExpiry(): array {
		if(isset($this->lensExpiry) && count($this->lensExpiry)){
			return $this->lensExpiry;
		}

		throw new LensExpiryDataMissing();

	}

	/**
	 * @param array $lensExpiry
	 */
	public function setLensExpiry(array $lensExpiry): void {
		$this->lensExpiry = $lensExpiry;
	}
}