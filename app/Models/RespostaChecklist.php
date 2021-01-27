<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespostaChecklist extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','atividade_id','pergunta_id','resposta' ];
}
