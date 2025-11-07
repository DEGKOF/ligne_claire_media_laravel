<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class BRVMService
{
    private $baseUrl = 'https://www.brvm.org';

    /**
     * Récupère les données principales de la BRVM
     */
    // public function getMarketData()
    // {
    //     // Cache pendant 15 minutes (comme l'app mobile officielle)
    //     return Cache::remember('brvm_market_data', 900, function () {
    //         return [
    //             'brvm_composite' => $this->getBRVMComposite(),
    //             'brvm_10' => $this->getBRVM10(),
    //             // Vous pouvez ajouter des actions individuelles
    //             'top_gainers' => $this->getTopGainers(3),
    //         ];
    //     });
    // }

    /**
 * Récupère les données principales de la BRVM
 */
public function getMarketData()
{
    // Cache pendant 15 minutes (comme l'app mobile officielle)
    return Cache::remember('brvm_market_data', 900, function () {
        return [
            'brvm_composite' => $this->getIndex('BRVM-C', 'BRVM Composite'),
            'brvm_30' => $this->getIndex('BRVM-30', 'BRVM 30'),
            'brvm_prestige' => $this->getIndex('BRVM-PRES', 'BRVM Prestige'),
        ];
    });
}

/**
 * Méthode générique pour récupérer un indice
 */
private function getIndex($symbol, $name)
{
    try {
        $response = Http::timeout(10)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])
            ->get($this->baseUrl . '/fr/cotations');

        if ($response->successful()) {
            $html = $response->body();
            $crawler = new Crawler($html);

            // Chercher l'indice spécifique par son symbole
            // À adapter selon la structure HTML réelle du site
            $indexRow = $crawler->filter("tr:contains('$symbol')")->first();

            if ($indexRow->count() > 0) {
                $price = $indexRow->filter('td')->eq(1)->text();
                $change = $indexRow->filter('td')->eq(2)->text();
                $changePercent = $indexRow->filter('td')->eq(3)->text();

                $cleanChange = $this->cleanNumber($change);

                return [
                    'price' => $this->cleanNumber($price),
                    'change' => abs($cleanChange),
                    'change_percent' => $this->cleanNumber($changePercent),
                    'is_positive' => strpos($change, '-') === false,
                    'timestamp' => now()->toIso8601String(),
                    'name' => $name,
                    'symbol' => $symbol,
                ];
            }
        }
    } catch (\Exception $e) {
        Log::error("BRVM $symbol Error: " . $e->getMessage());
    }

    return $this->getFallbackData($symbol);
}

/**
 * Données de secours mises à jour
 */
private function getFallbackData($symbol)
{
    $fallback = [
        'BRVM-C' => [
            'price' => '236.25',
            'change' => '0.32',
            'change_percent' => '0.32',
            'is_positive' => false,
            'name' => 'BRVM Composite',
        ],
        'BRVM-30' => [
            'price' => '163.92',
            'change' => '0.48',
            'change_percent' => '0.48',
            'is_positive' => false,
            'name' => 'BRVM 30',
        ],
        'BRVM-PRES' => [
            'price' => '140.16',
            'change' => '0.39',
            'change_percent' => '0.39',
            'is_positive' => false,
            'name' => 'BRVM Prestige',
        ],
    ];

    return array_merge($fallback[$symbol] ?? [], [
        'timestamp' => now()->toIso8601String(),
        'symbol' => $symbol,
    ]);
}


    /**
     * Récupère l'indice BRVM Composite
     */
    private function getBRVMComposite()
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->get($this->baseUrl . '/fr/cotations');

            if ($response->successful()) {
                $html = $response->body();
                $crawler = new Crawler($html);

                // Scraping des données (à adapter selon la structure HTML réelle)
                // Vous devrez inspecter le site pour trouver les bons sélecteurs CSS
                $price = $crawler->filter('.indice-composite .price')->text();
                $change = $crawler->filter('.indice-composite .change')->text();
                $changePercent = $crawler->filter('.indice-composite .change-percent')->text();

                return [
                    'price' => $this->cleanNumber($price),
                    'change' => $this->cleanNumber($change),
                    'change_percent' => $this->cleanNumber($changePercent),
                    'is_positive' => strpos($change, '-') === false,
                    'timestamp' => now()->toIso8601String(),
                    'name' => 'BRVM Composite',
                ];
            }
        } catch (\Exception $e) {
            Log::error('BRVM Composite Error: ' . $e->getMessage());
        }

        return $this->getFallbackData('composite');
    }

    /**
     * Récupère l'indice BRVM 10
     */
    private function getBRVM10()
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->get($this->baseUrl . '/fr/cotations');

            if ($response->successful()) {
                $html = $response->body();
                $crawler = new Crawler($html);

                // À adapter selon la structure HTML
                $price = $crawler->filter('.indice-10 .price')->text();
                $change = $crawler->filter('.indice-10 .change')->text();

                return [
                    'price' => $this->cleanNumber($price),
                    'change' => $this->cleanNumber($change),
                    'change_percent' => number_format(abs(($change / $price) * 100), 2),
                    'is_positive' => $change >= 0,
                    'timestamp' => now()->toIso8601String(),
                    'name' => 'BRVM 10',
                ];
            }
        } catch (\Exception $e) {
            Log::error('BRVM 10 Error: ' . $e->getMessage());
        }

        return $this->getFallbackData('brvm10');
    }

    /**
     * Récupère les plus fortes hausses
     */
    private function getTopGainers($limit = 3)
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->get($this->baseUrl . '/fr/cotations');

            if ($response->successful()) {
                $html = $response->body();
                $crawler = new Crawler($html);

                $gainers = [];
                $crawler->filter('.top-gainers tr')->slice(0, $limit)->each(function (Crawler $node) use (&$gainers) {
                    $gainers[] = [
                        'symbol' => $node->filter('td:nth-child(1)')->text(),
                        'price' => $this->cleanNumber($node->filter('td:nth-child(2)')->text()),
                        'change_percent' => $this->cleanNumber($node->filter('td:nth-child(3)')->text()),
                    ];
                });

                return $gainers;
            }
        } catch (\Exception $e) {
            Log::error('BRVM Top Gainers Error: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Nettoie les nombres (enlève espaces, symboles, etc.)
     */
    private function cleanNumber($value)
    {
        return trim(str_replace([' ', 'FCFA', '%', '+'], '', $value));
    }

    /**
     * Données de secours
     */
    // private function getFallbackData($type)
    // {
    //     $fallback = [
    //         'composite' => [
    //             'price' => '215.45',
    //             'change' => '1.23',
    //             'change_percent' => '0.57',
    //             'is_positive' => true,
    //             'name' => 'BRVM Composite',
    //         ],
    //         'brvm10' => [
    //             'price' => '165.32',
    //             'change' => '0.89',
    //             'change_percent' => '0.54',
    //             'is_positive' => true,
    //             'name' => 'BRVM 10',
    //         ],
    //     ];

    //     return array_merge($fallback[$type] ?? [], [
    //         'timestamp' => now()->toIso8601String(),
    //     ]);
    // }
}
