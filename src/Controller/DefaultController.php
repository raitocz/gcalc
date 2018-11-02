<?php

namespace Gcalc\Controller;

use Gcalc\Controller\Render\HtmlRenderTrait;
use Gcalc\Controller\Render\JsonRenderTrait;
use Gcalc\Service\DataProviderService;
use Gcalc\Service\GuessCalculatorService;

/**
 * Class DefaultController
 * @package Raitocz\Gcalc\Controller
 */
class DefaultController extends Controller {

	use HtmlRenderTrait;
	use JsonRenderTrait;

	/**
	 * @throws \Gcalc\Exception\Service\FileNotFoundException
	 * @throws \Gcalc\Exception\Service\IncorrectFormatException
	 * @throws \Gcalc\Exception\Service\MissingPathToFileException
	 * @throws \Gcalc\Exception\Service\ServiceNameRequiredException
	 * @throws \Gcalc\Exception\Service\ServiceNotFoundException
	 * @throws \Gcalc\Exception\Service\UnableToReadFileException
	 * @throws \Exception
	 */
	public function runCalcAction(): void {
		/** @var DataProviderService $dataProviderService */
		$dataProviderService = $this->serviceContainer->getService(DataProviderService::class);
		/** @var GuessCalculatorService $guessCalculatorService */
		$guessCalculatorService = $this->serviceContainer->getService(GuessCalculatorService::class);

		$customersOrders = $dataProviderService->loadFromJsonFile('customersOrders.json');
		$lensExpiry = $dataProviderService->loadFromJsonFile('lensExpiry.json');

		/**
		 * Not perfect but I think that this is now enough. Preloading this in serviceContainer when creating the
		 * service itself in constructor would be nicer, but that would require more work&time to put the
		 * serviceContainer together. In this case I would say: Symfony/Nette/Laravel/others handle this nicely.
		 */
		$guessCalculatorService->setLensExpiry($lensExpiry);

		$guesses = array();
		foreach ($customersOrders as $id => $customer) {
			$guesses["customer-" . $id] = $guessCalculatorService->getGuess($customer, $id)->format("Y-m-d");
		}

		$this->render($guesses);
	}

	/**
	 * I will just pick the renderJson from the JsonRenderTrait. The traits are here as an example of how they could be
	 * handy, but I don't want to implement another structures for switching the output type based on request.
	 * @param $output
	 * @return void
	 */
	public function render($output): void {
		$this->renderJson($output);
	}
}