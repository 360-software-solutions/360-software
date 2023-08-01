<?php

use App\Models\OptionChainIndice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $optionChainIndices = OptionChainIndice::whereDate('time', now())->get();
    $dataCOI = [];
    $dataOI = [];

    foreach ($optionChainIndices as $optionChainIndice) {
        $time = Carbon::parse($optionChainIndice->time)->tz('Asia/Kolkata');

        $timeArr = [
            $time->format('H'),
            $time->format('i'),
            $time->format('s'),
        ];

        $timeArr = array_map(fn ($item) => (int) $item, $timeArr);

        $itemCOI = [
            $timeArr,
            $optionChainIndice->changein_open_interest_diff,
        ];

        $itemOI = [
            $timeArr,
            $optionChainIndice->open_interest_diff
        ];

        array_push($dataCOI, $itemCOI);
        array_push($dataOI, $itemOI);
    }

    $jsonDataCOI = json_encode($dataCOI);
    $jsonDataOI = json_encode($dataOI);

    return view('welcome', compact('jsonDataCOI', 'jsonDataOI'));
});
