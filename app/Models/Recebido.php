<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recebido extends Model
{
    use HasFactory;
    protected $table = 'recebidos';
    protected $fillable = [
      'id','descricao','valor','fatura_id','data','obs'
    ];
}
