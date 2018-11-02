<?php

namespace Gcalc\Entity;

use DateTime;
use Exception;
use Gcalc\Exception\Entity\IncorrectInputData;

/**
 * Class Order
 */
class Order {

	/** @var DateTime */
	protected $createdAt;

	/** @var Lenses[] */
	protected $lenses;

	/**
	 * Order constructor.
	 * @param DateTime $createdAt
	 * @param array $lenses
	 * @throws Exception
	 */
	public function __construct(DateTime $createdAt, array $lenses) {
		$this->setCreatedAt($createdAt);
		$this->parseLenses($lenses);
	}

	/**
	 * @param $lenses
	 * @throws IncorrectInputData
	 */
	public function parseLenses($lenses) {
		foreach ($lenses as $lens) {
			if(!isset($lens[0]) || !isset($lens[1]) || !isset($lens[2])){
				throw new IncorrectInputData();
			}

			$this->addLenses(new Lenses($lens[0], $lens[1], $lens[2]));
		}
	}

	/**
	 * @param array $lensExpiry
	 * @return int
	 * @throws IncorrectInputData
	 */
	public function getTotalExpiryDays(array $lensExpiry): int {
		$days = 0;

		/** @var Lenses $lens */
		foreach ($this->getLenses() as $lens) {
			if(!isset($lensExpiry[$lens->getType()])){
				throw new IncorrectInputData();
			}
			$days = $lensExpiry[$lens->getType()] * $lens->getQuantity();
		}

		return $days;
	}


	/**
	 * @return array
	 */
	public function getLenses(): array {
		return $this->lenses;
	}

	/**
	 * @param Lenses $lenses
	 */
	public function addLenses(Lenses $lenses) {
		$this->lenses[] = $lenses;
	}

	/**
	 * @return DateTime
	 */
	public function getCreatedAt(): DateTime {
		return $this->createdAt;
	}

	/**
	 * @param DateTime $createdAt
	 */
	protected function setCreatedAt(DateTime $createdAt): void {
		$this->createdAt = $createdAt;
	}


}