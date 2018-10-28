<?php

/**
 * Class DataProvider
 */
class DataProvider {

	/**
	 * @return array
	 */
	public static function getCustomersOrders(): array {
		return array(
			array(
				'2015-04-01' => array(
					array(1, 2, '-2.00'),
					array(1, 2, '-3.00'),
				)
			),
			array(
				'2014-10-01' => array(
					array(3, 2, '-1.50'),
					array(3, 2, '-3.50'),
				),
				'2015-01-01' => array(
					array(3, 2, '-1.50'),
					array(3, 2, '-3.50'),
				),
				'2015-04-15' => array(
					array(3, 1, '-1.50'),
					array(3, 1, '-3.50'),
				),
			),
			array(
				'2014-08-01' => array(
					array(2, 2, '+0.50'),
				)
			)
		);
	}
}