<?php

declare(strict_types=1);

namespace EScooters\Importers;

use DOMElement;
use EScooters\Exceptions\CityNotAssignedToAnyCountryException;
use EScooters\Importers\DataSources\HtmlDataSource;
use EScooters\Utils\HardcodedCitiesToCountriesAssigner;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class LinkDataImporter extends DataImporter implements HtmlDataSource
{
    protected Crawler $sections;

    public function getBackground(): string
    {
        return "#DEF700";
    }

    public function extract(): static
    {
        $client = new Client();
        $html = $client->get("https://superpedestrian.com/locations")->getBody()->getContents();

        $crawler = new Crawler($html);
        $this->sections = $crawler->filter("div.row.sqs-row div.col div div p");

        return $this;
    }

    public function transform(): static
    {
            /** @var DOMElement $section */
        foreach ($this->sections as $section) {
            $country = null;
            $cityName = trim($section->nodeValue);
            $exception = ["California", "Connecticut", "Illinois", "Kansas", "Maryland", "Michigan", "New Jersey", "Ohio", "Tennessee", "Texas", "Virginia", "Washington","Austria","France","Germany","Italy","Portugal","Spain","United Kingdom"];
            
            if ($cityName) {
                if ($cityName === "Ride with us in cities around the world!") {
                    continue; 
                }

                    if (in_array($cityName, $exception, true)) {
                        continue;
                    }

                    if($cityName==="Nottingham"){
                        $hardcoded = HardcodedCitiesToCountriesAssigner::assign($cityName);
                        if ($hardcoded) {
                            $country = $this->countries->retrieve($hardcoded);
                        }
                        $city = $this->cities->retrieve($cityName, $country);
                        $this->provider->addCity($city);
                        break;
                    }

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
               // echo ( strlen($cityName).". ");
            }
            return $this;
            } 
        }