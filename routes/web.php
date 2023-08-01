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
    $data = [];

    foreach ($optionChainIndices as $optionChainIndice) {
        $time = Carbon::parse($optionChainIndice->time)->tz('Asia/Kolkata');

        $timeArr = [
            $time->format('H'),
            $time->format('i'),
            $time->format('s'),
        ];

        $timeArr = array_map(fn ($item) => (int) $item, $timeArr);

        $item = [
            $timeArr,
            $optionChainIndice->changein_open_interest_diff,
            $optionChainIndice->open_interest_diff
        ];

        array_push($data, $item);
    }

    $jsonData = json_encode($data);

    return view('welcome', compact('jsonData'));
});
