<?php

/**
 * Class Customer
 */
class Customer {

	/** @var Order[] */
	protected $orders;

	/** @var int */
	protected static $id;

	/**
	 * Customer constructor.
	 * @param array $orders
	 * @throws Exception
	 */
	public function __construct(array $orders) {
		$this->setId();
		$this->parseOrders($orders);
	}

	/**
	 *
	 */
	protected function setId(): void {
		if (self::$id) {
			self::$id++;
		}
		else {
			self::$id = 1;
		}
	}

	/**
	 * @return int
	 */
	public static function getId(): int {
		return self::$id;
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
	 * @param Order $order
	 */
	public function addOrder(Order $order): void {
		$this->orders[] = $order;
	}

	/**
	 * @return Order[]
	 */
	public function getOrders(): array {
		return $this->orders;
	}


}