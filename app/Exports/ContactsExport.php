<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contact::select([
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
            'obs'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Local',
            'Grupo',
            'Nome',
            'Telemóvel',
            'Extensão',
            'Funcionalidades',
            'Ativação',
            'Desativação',
            'Ticket SCMP',
            'Ticket FSE',
            'ICCID',
            'Equipamento',
            'Serial Number',
            'IMEI',
            'Observações'
        ];
    }
}
