<?php

declare(strict_types=1);

namespace EScooters\Utils;

class HardcodedCitiesToCountriesAssigner
{
    public static function assign(string $name): ?string
    {
        return match ($name) {
            "Aalst" => "Belgium",
            "Antwerp" => "Belgium",
            "Aprilia" => "Italy",
            "Bretigny-sur-Orge" => "France",
            "Canterbury" => "United Kingdom",
            "Charleroi" => "Belgium",
            "Erfurt" => "Germany",
            "Ferrara" => "Italy",
            "Firenze" => "Italy",
            "Liege" => "Belgium",
            "Neckarsulm" => "Germany",
            "Neu-Ulm" => "Germany",
            "Orange" => "France",
            "Pesaro" => "Italy",
            "Pforzheim" => "Germany",
            "Porto" => "Portugal",
            "Cascais" => "Portugal",
            "Espinho" => "Portugal",
            "Évora" => "Portugal",
            "Faro" => "Portugal",
            "Maia" => "Portugal",
            "Tomar" => "Portugal",
            "Vila Franca de Xira" => "Portugal",
            "Vila Nova de Gaia" => "Portugal",
            "Redditch" => "United Kingdom",
            "Regensburg" => "Germany",
            "Tarragona" => "Spain",
            "Ulm" => "Germany",
            "Viareggio" => "Italy",
            "Rimini" => "Italy",
            "Verona" => "Italy",
            "Villemomble" => "France",
            "Viry-Chatillon" => "France",
            "Würzburg" => "Germany",
            "Zaragoza" => "Spain",
            "Givatayim" => "Israel",
            "Ramat Gan" => "Israel",
            "Tel Aviv" => "Israel",
            "Chemnitz" => "Germany",
            "Heilbronn" => "Germany",
            "Kassel" => "Germany",
            "Palermo" => "Italy",
            "Rostock" => "Germany",
            "Troisdorf" => "Germany",
            "Varese" => "Italy",
            "Catania" => "Italy",
            "Monza" => "Italy",
            "Padua" => "Italy",
            default => null,
        };
    }
}
