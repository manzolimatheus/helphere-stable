<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Institute extends Model
{
    use HasFactory;

    public $fillable = [
        'cnpj',
        'nome_instituicao',
        'id_categoria',
        'telefone',
        'email',
        'municipio',
        'uf',
        'logradouro',
        'pixKey',
        'titular',
        'image',
        'image_perfil',
        'descricao'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User'); //Instituição pertence a alguém
    }

    public function category_institutes(){
        return $this->belongsTo('App\Models\category_institute'); //Instituição pertence a uma categoria
    }


}
