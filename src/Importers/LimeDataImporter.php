<?php

declare(strict_types=1);

namespace EScooters\Importers;

use DOMElement;
use EScooters\Exceptions\CityNotAssignedToAnyCountryException;
use EScooters\Importers\DataSources\HtmlDataSource;
use EScooters\Utils\HardcodedCitiesToCountriesAssigner;
use Symfony\Component\DomCrawler\Crawler;

class LimeDataImporter extends DataImporter implements HtmlDataSource
{
    protected Crawler $sections;

    public function getBackground(): string
    {
        return "#00DE00";
    }

    public function extract(): static
    {
        $html = file_get_contents("https://www.li.me/locations");

        $crawler = new Crawler($html);
        $this->sections = $crawler->filter(".pb-4 > .box-content .inline-block");

        return $this;
    }

    public function transform(): static
    {
        /** @var DOMElement $section */
        foreach ($this->sections as $section) {
            $country = null;
            $cityName = trim($section->nodeValue);
            if ($cityName) {

                    try {
                        $hardcoded = HardcodedCitiesToCountriesAssigner::assign($cityName);
                        if ($hardcoded) {
                            $country = $this->countries->retrieve($hardcoded);
                        }
                        
                    } catch (CityNotAssignedToAnyCountryException $exception) {
                        echo $exception->getMessage() . PHP_EOL;
                        continue;
                    }
                }
                $city = $this->cities->retrieve($cityName, $country);
                $this->provider->addCity($city);
            }

        return $this;
    }
}
 