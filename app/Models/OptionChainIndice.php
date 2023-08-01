<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionChainIndice extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'time',
        'changein_open_interest_diff',
        'open_interest_diff',
    ];
}
