<?php

declare(strict_types=1);

namespace PrestaShop\Module\Ifthenpay\Utility;


class CountryCodes
{
	const JSON_FILE_PATH = __DIR__ . '/CountryCodes.json';


	private static function getCountryCodesFileContent(): string
	{
		// Read JSON file contents
		$jsonData = file_get_contents(self::JSON_FILE_PATH);

		return $jsonData;
	}



	/**
	 * get an array of arrays (value, name) to be used to render the country code select box
	 * will return an empty array if an error occurs, this makes it possible to fallback to a simple input if something goes wrong with this function
	 * there fore keeping the functionality (most likely only used for mbway)
	 */
	public static function getCountryCodesAsValueNameArray(string $lang): array
	{
		try {
			if ($lang == '') {
				$lang = 'pt';
			}

			// Read JSON file contents
			$jsonData = self::getCountryCodesFileContent();

			// Parse JSON data into an associative array
			$countryCodes = json_decode($jsonData, true);

			// get correct language key
			$lang = strtoupper($lang);
			$lang = (isset($countryCodes['mobile_prefixes']) && isset($countryCodes['mobile_prefixes'][0]) && isset($countryCodes['mobile_prefixes'][0][$lang])) ? $lang : 'EN';

			$countryCodeOptions = [];
			foreach ($countryCodes['mobile_prefixes'] as $country) {

				if ($country['Ativo'] != 1) {
					continue; // skip this one
				}

				$countryCodeOptions[] = [
					'value' => $country['Indicativo'],
					'name' => $country[$lang] . ' (+' . $country['Indicativo'] . ')'
				];
			}


			return $countryCodeOptions;
		} catch (\Throwable $th) {
			return [];
		}
	}
}
