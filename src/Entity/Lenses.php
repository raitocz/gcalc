<?php

namespace Gcalc\Entity;

/**
 * Class Lenses
 */
class Lenses {

	/** @var int */
	protected $type;

	/** @var int */
	protected $quantity;

	/** @var string */
	protected $power;

	/**
	 * Lenses constructor.
	 * @param int $type
	 * @param int $quantity
	 * @param string $power
	 */
	public function __construct(int $type, int $quantity, string $power) {
		$this->setType($type);
		$this->setQuantity($quantity);
		$this->setPower($power);
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


}