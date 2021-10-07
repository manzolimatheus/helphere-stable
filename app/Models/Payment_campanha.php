<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_campanha extends Model
{
    use HasFactory;

    public $fillable = [
        'id_campanha',
        'valorDoado',
        'id_doador'
    ];

}
