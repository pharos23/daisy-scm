<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
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
        'equip_sn',
        'imei',
        'obs',
    ];
}
