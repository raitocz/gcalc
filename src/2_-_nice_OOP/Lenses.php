<?php

/**
 * Class Lenses
 */
class Lenses {

	const TYPE_BIOFINITY_6 = 1;
	const TYPE_BIOFINITY_3 = 2;
	const TYPE_FOCUS_DAILIES = 3;

	/** @var int */
	protected $type;

	/** @var int */
	protected $quantity;

	/** @var string */
	protected $power;

	/** @var int */
	protected $expiryDays;

	/**
	 * Lenses constructor.
	 * @param $type
	 * @param $quantity
	 * @param $power
	 * @throws Exception
	 */
	public function __construct(int $type, int $quantity, string $power) {
		$this->setType($type);
		$this->setQuantity($quantity);
		$this->setPower($power);

		/**
		 * This is basically mocking the DB...
		 */
		switch ($type) {
			case self::TYPE_BIOFINITY_6:
				$this->setExpiryDays(180);
				break;
			case self::TYPE_BIOFINITY_3:
				$this->setExpiryDays(90);
				break;
			case self::TYPE_FOCUS_DAILIES:
				$this->setExpiryDays(30);
				break;
			default:
				throw new Exception('Unknown lens type.');
		}
	}

	/**
	 * @return int
	 */
	public function getType(): int {
		return $this->type;
	}

	/**
	 * @param int $type
	 */
	protected function setType(int $type): void {
		$this->type = $type;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int {
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 */
	protected function setQuantity(int $quantity): void {
		$this->quantity = $quantity;
	}

	/**
	 * @return string
	 */
	public function getPower(): string {
		return $this->power;
	}

	/**
	 * @param string $power
	 */
	protected function setPower(string $power): void {
		$this->power = $power;
	}

	/**
	 * @return int
	 */
	public function getExpiryDays(): int {
		return $this->expiryDays;
	}

	/**
	 * @param int $expiryDays
	 */
	protected function setExpiryDays(int $expiryDays): void {
		$this->expiryDays = $expiryDays;
	}


}