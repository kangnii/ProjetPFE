<?php

namespace App\Imports;

use App\Models\Echeance;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EcheancesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Echeance|null
    */
    public function model(array $row)
    {


        return new Echeance([
            'nom' => $row['nom'],
            'prenoms' => $row['prenoms'],
            'numero_whatsapp' => $row['numero_whatsapp'],
            'date_echeance' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject( (int)$row['date_echeance']),
            'numero_police' => $row['numero_police'],
            'numeroclient' => $row['numeroclient'],
            'type_contrat' => $row['type_contrat']
        ]);




    }


}

