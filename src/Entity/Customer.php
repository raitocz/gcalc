<?php

namespace Gcalc\Entity;

use DateTime;
use Exception;

/**
 * Class Customer
 * @package Raitocz\Gcalc\Entity
 */
class Customer implements IEntity {

	/** @var Order[] */
	protected $orders;

	/** @var int */
	protected $id;

	/**
	 * Customer constructor.
	 * @param array $orders
	 * @param int $id
	 * @throws Exception
	 */
	public function __construct(array $orders, int $id) {
		/* I removed the ID logic from here as it is not needed, the JSON will fill us with indexes which will be used
		as ID. If I should implement ID logic here, I would probably choose the Iterator interface in this scenario */
		$this->setId($id);
		$this->parseOrders($orders);
	}

	/**
	 * @param array $orders
	 * @throws Exception
	 */
	protected function parseOrders(array $orders): void {
		foreach ($orders as $orderDate => $order) {
			$this->addOrder(new Order(new DateTime($orderDate), $order));
		}
	}

	/**
	 * @return Order[]
	 */
	public function getOrders(): array {
		return $this->orders;
	}

	/**
	 * @param Order $order
	 */
	public function addOrder(Order $order): void {
		$this->orders[] = $order;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId(int $id): void {
		$this->id = $id;
	}


}