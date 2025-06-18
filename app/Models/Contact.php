<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'local',
        'grupo',
        'nome',
        'telemovel',
        'extensao',
        'funcionalidades',
        'ativacao',
        'desativacao',
        'ticket_scmp',
        'ticket_fse',
        'iccid',
        'equipamento',
        'serial_number',
        'imei',
        'obs',
    ];
}
