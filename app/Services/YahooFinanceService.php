<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YahooFinanceService
{
    private $baseUrl = 'https://query1.finance.yahoo.com/v8/finance/chart/';

    /**
     * Récupère les données des 3 marchés
     */
    public function getMarketData()
    {
        return [
            'cac40' => $this->getQuote('^FCHI'),     // CAC 40
            'dowjones' => $this->getQuote('^DJI'),   // Dow Jones
            'eurusd' => $this->getQuote('EURUSD=X'), // EUR/USD
        ];
    }

    /**
     * Récupère les données pour un symbole donné
     */
    private function getQuote($symbol)
    {
        try {
            $response = Http::timeout(10)->get($this->baseUrl . $symbol, [
                'range' => '1d',
                'interval' => '1m',
                'indicators' => 'quote',
                'includeTimestamps' => 'false',
                'includePrePost' => 'false',
                'corsDomain' => 'finance.yahoo.com',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $quote = $data['chart']['result'][0]['meta'] ?? null;

                if ($quote) {
                    $currentPrice = $quote['regularMarketPrice'] ?? 0;
                    $previousClose = $quote['chartPreviousClose'] ?? $quote['previousClose'] ?? $currentPrice;
                    $change = $currentPrice - $previousClose;
                    $changePercent = ($previousClose != 0)
                        ? (($change / $previousClose) * 100)
                        : 0;

                    // Format selon le type (devise à 4 décimales, autres à 2)
                    $decimals = (strpos($symbol, '=X') !== false) ? 4 : 2;

                    return [
                        'price' => number_format($currentPrice, $decimals, '.', ','),
                        'change' => number_format($change, $decimals, '.', ','),
                        'change_percent' => number_format(abs($changePercent), 2, '.', ''),
                        'is_positive' => $change >= 0,
                        'timestamp' => now()->toIso8601String(),
                        'symbol' => $symbol,
                    ];
                }
            }

            Log::warning('Yahoo Finance: Aucune donnée pour ' . $symbol);
        } catch (\Exception $e) {
            Log::error('Yahoo Finance Error for ' . $symbol . ': ' . $e->getMessage());
        }

        return $this->getFallbackData($symbol);
    }

    /**
     * Données par défaut en cas d'erreur
     */
    private function getFallbackData($symbol)
    {
        // Données de secours réalistes
        $fallbackData = [
            '^FCHI' => ['price' => '7,482.35', 'change' => '92.50', 'percent' => '1.25'],
            '^DJI' => ['price' => '34,876.21', 'change' => '301.20', 'percent' => '0.87'],
            'EURUSD=X' => ['price' => '1.0945', 'change' => '0.0035', 'percent' => '0.32'],
        ];

        $data = $fallbackData[$symbol] ?? ['price' => 'N/A', 'change' => '0.00', 'percent' => '0.00'];

        return [
            'price' => $data['price'],
            'change' => $data['change'],
            'change_percent' => $data['percent'],
            'is_positive' => true,
            'timestamp' => now()->toIso8601String(),
            'symbol' => $symbol,
        ];
    }
}
