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
        'total_changein_open_interest_ce',
        'total_changein_open_interest_pe',
        'total_open_interest_ce',
        'total_open_interest_pe',
    ];
}
