<?php

namespace App\Console\Commands;

use App\Models\OptionChainIndice;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetOptionChainIndices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:option-chain-indices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get option chain indices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => 'https://nseindia.com',
            'timeout'  => 30.0, // 5000 milliseconds
        ]);

        $response = $client->request('GET', '/api/option-chain-indices?symbol=NIFTY', [
            'headers' => [
                'Host' => 'nseindia.com',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:82.0) Gecko/20100101 Firefox/82.0',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Accept-Encoding' => 'gzip, deflate, br',
                'DNT' => '1',
                'Connection' => 'keep-alive',
                'Upgrade-Insecure-Requests' => '1',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'no-cache',
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        $filteredData = $data['filtered']['data'];
        $records = $data['records'];

        $firstExpiryDate = $records['expiryDates'][0];
        $timestamp = $records['timestamp'];
        $underlyingValue = $records['underlyingValue'];

        $initialStrikePrice = $absoluteUnderlyingValue = ceil($underlyingValue / 50) * 50;

        $strikePrices = [$absoluteUnderlyingValue];

        for ($i = 0; $i < 12; $i++) {
            $absoluteUnderlyingValue -= 50;
            array_push($strikePrices, $absoluteUnderlyingValue);
        }

        $absoluteUnderlyingValue = $initialStrikePrice;

        for ($i = 0; $i < 12; $i++) {
            $absoluteUnderlyingValue += 50;
            array_push($strikePrices, $absoluteUnderlyingValue);
        }

        usort($strikePrices, fn ($a, $b) => $a > $b);

        $totalChangeinOpenInterestCE = 0;
        $totalChangeinOpenInterestPE = 0;

        $totalOpenInterestCE = 0;
        $totalOpenInterestPE = 0;

        foreach ($filteredData as $data) {
            if (in_array($data['strikePrice'], $strikePrices)) {
                $totalChangeinOpenInterestCE += $data['CE']['changeinOpenInterest'];
                $totalOpenInterestCE += $data['CE']['openInterest'];

                $totalChangeinOpenInterestPE += $data['PE']['changeinOpenInterest'];
                $totalOpenInterestPE += $data['PE']['openInterest'];
            }
        }

        OptionChainIndice::create([
            'symbol' => 'NIFTY',
            'time' => Carbon::parse($timestamp, 'Asia/Kolkata')->tz('UTC'),
            'total_changein_open_interest_ce' => $totalChangeinOpenInterestCE,
            'total_changein_open_interest_pe' => $totalChangeinOpenInterestPE,
            'total_open_interest_ce' => $totalOpenInterestCE,
            'total_open_interest_pe' => $totalOpenInterestPE,
        ]);
    }
}
