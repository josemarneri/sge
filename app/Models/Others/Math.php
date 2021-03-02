<?php

namespace App\Models\Others;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Math extends Model
{
    use HasFactory;
    
    //Pega uma string horas 00:00 e onverte para um inteiro minutos 
    public function horasToMin($horas){
        $pos1 = strpos($horas, ':');
        $hora= substr($horas, 0,$pos1);
        $min = substr($horas, $pos1+1,$pos1+3);
        $n_horas = intval($hora);
        $n_min = intval($min);
        $n_min += $n_horas * 60;
        return $n_min;
    }
    //converte um inteiro minutos para uma string horas 00:00 
    public function minToHoras($minutos){
        $sinal = (($minutos / 60) < 0) ? '-':'';
        $horas = abs(intval($minutos / 60));
        $min = abs($minutos % 60);
        $minutos_string = $min < 10 ? '0'. $min : $min;
        $horas_string = $horas < 10 ? '0'. $horas : $horas;
        return $sinal . $horas_string . ':' . $minutos_string;
    }
    
    public function somaHoras($hora1, $hora2){
        $min1 = $this->horasToMin($hora1);
        $min2 = $this->horasToMin($hora2);
        $minTotal = $min1 + $min2;
        $horaTotal = $this->minToHoras($minTotal);
        return $horaTotal;
    }
    
    //Pega uma string horas 00:00 e onverte para um inteiro minutos 
    public function horasToDec($horas){
        $pos1 = strpos($horas, ':');
        $hora= substr($horas, 0,$pos1);
        $min = substr($horas, $pos1+1,$pos1+3);
        $n_horas = intval($hora);
        $n_min = intval($min)/60;
        $horasDec = number_format($n_horas + $n_min, 2);
        return $horasDec;
    }
    
}
