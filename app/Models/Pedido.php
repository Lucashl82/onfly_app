<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'destino', 'data_ida', 'data_volta', 'status'];

    public function rules() {
        return [
            'nome' => 'required',            
            'data_ida' =>'required',
            'data_volta'=> 'required',
            'destino' =>'required',
            'status' => 'required'
        ];

        /*
            1) tabela
            2) nome da coluna que será pesquisada na tabela3
            3) id do registro que será desconsiderado na pesquisa
        */
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres'
        ];
    }
}
