<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Contact Model. To make the desired data for each entry in the Contact table
class Contact extends Model
{
    use HasFactory;
    // These are the variables we want in our database
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
