<?php

//inclut automatiquement tous les packages de Composer
require_once __DIR__.'/vendor/autoload.php';

use Whatsma\ZodiacSign;

$calculator = new ZodiacSign\Calculator();

$zodiacFr = array(
	"aries"=>"Belier",
	"taurus"=>"Taureau",
	"gemini"=>"Gemeaux",
	"cancer"=>"Cancer",
	"leo"=>"Lion",
	"virgo"=>"Vierge",
	"libra"=>"Balance",
	"scorpio"=>"Scorpion",
	"sagittarius"=>"Sagitaire",
	"capricorn"=>"Capricorne",
	"aquarius"=>"Verseau",
	"pisces"=>"Poisson",
	);

try {
  $zodiacSign = $calculator->calculate(8,12);
  echo $zodiacFr[$zodiacSign] . "\n";
} catch (ZodiacSign\InvalidDayException $e) {
  echo "ERROR: Invalid Day";
} catch (ZodiacSign\InvalidMonthException $e) {
  echo "ERROR: Invalid Month";
}

?>