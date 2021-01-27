<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComessaFuncionario extends Model
{
    use HasFactory;
     protected $fillable = [
        'id', 'comessa_id', 'funcionario_id',
    ];
}
