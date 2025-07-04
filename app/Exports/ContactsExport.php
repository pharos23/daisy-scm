<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ContactsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
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

    public function map($row): array
    {
        return [
            $row->local,
            $row->grupo,
            $row->nome,
            $row->telemovel,
            $row->extensao,
            $row->funcionalidades,
            $row->ativacao,
            $row->desativacao,
            $row->ticket_scmp,
            $row->ticket_fse,
            $row->iccid,
            $row->equipamento,
            $row->serial_number,
            "'" . $row->imei, // Prefix with apostrophe to preserve format
            $row->obs,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'N' => NumberFormat::FORMAT_TEXT, // Column N = 14th column = IMEI
        ];
    }
}
