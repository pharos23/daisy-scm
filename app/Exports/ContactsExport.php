<?php

// File to export data from the "contacts" database table

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ContactsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
     * Returns the collection of data to export.
     * This selects only the relevant fields from the `contacts` table.
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

    /**
     * Defines the column headers to appear in the first row of the Excel file.
     * These are static labels that match the selected fields above.
     */
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

    /**
     * Maps each database row into an array of values to be exported.
     * You can format or transform values here as needed.
     * The IMEI is prefixed with an apostrophe to ensure Excel treats it as plain text
     * (preventing it from removing leading zeros or applying scientific notation).
     */
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

    /**
     * Specifies formatting for certain Excel columns.
     * Column 'N' (14th column, which is IMEI) is set to plain text format
     * to avoid any issues with large numbers being misinterpreted by Excel.
     */
    public function columnFormats(): array
    {
        return [
            'N' => NumberFormat::FORMAT_TEXT, // Column N = 14th column = IMEI
        ];
    }
}
