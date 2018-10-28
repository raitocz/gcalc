<?php

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
	 * @throws Exception
	 */
	public function parseLenses($lenses) {
		foreach ($lenses as $lens) {
			$this->addLenses(new Lenses($lens[0], $lens[1], $lens[2]));
		}
	}

	/**
	 * @param Lenses $lenses
	 */
	public function addLenses(Lenses $lenses) {
		$this->lenses[] = $lenses;
	}

	/**
	 * @return array
	 */
	public function getLenses(): array {
		return $this->lenses;
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

	/**
	 * Again, not playing around with scenarios that have different lenses in orders. If so, I would:
	 * - get all diferent lenses
	 * - sum their expiry dates
	 * - check if "every eye" is covered by the order
	 * - and so on...
	 * @return float|int
	 */
	public function getTotalExpiryDays(): int {
		$days = 0;

		/** @var Lenses $lens */
		foreach ($this->getLenses() as $lens) {
			$days = $lens->getExpiryDays() * $lens->getQuantity();
		}

		return $days;
	}


}