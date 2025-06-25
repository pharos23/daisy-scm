<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// File to import excel files into the database
class ContactsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Contact([
            'local'            => $row['local'],
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
