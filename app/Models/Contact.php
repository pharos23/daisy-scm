<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Contact Model
 *
 * Represents an entry in the 'contacts' table. This model defines
 * the fields that can be mass-assigned and includes support for
 * factory creation and soft deletion.
 */
class Contact extends Model
{
    // Enables the use of Laravel model factories (e.g., for testing and seeding)
    // and soft deletes (entries are not removed from DB, just marked as deleted)
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * These are the columns that can be filled when creating/updating a Contact
     * using methods like Contact::create([...]) or $contact->update([...]).
     */
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
