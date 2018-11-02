<?php

namespace Gcalc\Service;

use Gcalc\Exception\Service\FileNotFoundException;
use Gcalc\Exception\Service\IncorrectFormatException;
use Gcalc\Exception\Service\MissingPathToFileException;
use Gcalc\Exception\Service\UnableToReadFileException;

/**
 * Class DataProvider
 */
class DataProviderService implements IService {

	/**
	 * @param string $pathToFile
	 * @return array
	 * @throws FileNotFoundException
	 * @throws IncorrectFormatException
	 * @throws MissingPathToFileException
	 * @throws UnableToReadFileException
	 */
	public function loadFromJsonFile(string $pathToFile): array {
		if (!trim($pathToFile)) {
			throw new MissingPathToFileException();
		}

		if (!file_exists($pathToFile)) {
			throw new FileNotFoundException();
		}

		$jsonData = file_get_contents($pathToFile);

		if ($jsonData === false) {
			throw new UnableToReadFileException();
		}

		$decodedData = json_decode($jsonData, true);

		if (!$decodedData) {
			// We will just call all "bad" scenarios caught here simply as Incorrect
			throw new IncorrectFormatException();
		}

		return $decodedData;
	}
}