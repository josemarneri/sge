<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;
    protected $table = 'faturas';
    protected $fillable = [
      'id','descricao','data','valor_calculado','desconto','valor_nf','nf','obs'
    ];
}
