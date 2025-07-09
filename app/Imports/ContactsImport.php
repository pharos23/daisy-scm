<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// File to import excel files into the database
class ContactsImport implements ToModel, WithHeadingRow
{
    /**
     * This method is called for each row in the Excel file (after the heading row).
     * It converts a row of data into a Contact model instance that can be inserted into the database.
     *
     * @param array $row The current row being processed (as an associative array)
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Contact([
            'local'            => $row['local'],            // Must match the column header in Excel
            'grupo'            => $row['grupo'],
            'nome'             => $row['nome'],
            'telemovel'        => $row['telemovel'],
            'extensao'         => $row['extensao'],
            'funcionalidades'  => $row['funcionalidades'],
            'ativacao'         => $row['ativacao'],
            'desativacao'      => $row['desativacao'],
            'ticket_scmp'      => $row['ticket_scmp'],
            'ticket_fse'       => $row['ticket_fse'],
            'iccid'            => $row['iccid'],
            'equipamento'      => $row['equipamento'],
            'serial_number'    => $row['serial_number'],
            'imei'             => $row['imei'],
            'obs'              => $row['observacoes'],
        ]);
    }
}
