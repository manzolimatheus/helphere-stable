<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campanha extends Model
{
    use HasFactory;

    public $fillable = [
        'nome',
        'id_categoria',
        'telefone',
        'email',
        'data_fim',
        'endereco',
        'cidade',
        'pixKey',
        'titular',
        'img_path',
        'descricao'
    ];
}
