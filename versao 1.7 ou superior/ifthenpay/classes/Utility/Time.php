<?php

declare(strict_types=1);

namespace PrestaShop\Module\Ifthenpay\Utility;


class Time
{
	public static function dateAfterDays(string $numberOfDays): string
	{
		if ($numberOfDays === '') {
			return '';
		}

		$timezone = new \DateTimeZone('Europe/Lisbon');
		$dateTime = new \DateTime('now', $timezone);
		$dateTime->modify("+$numberOfDays days");

		return $dateTime->format('Ymd');
	}
}
