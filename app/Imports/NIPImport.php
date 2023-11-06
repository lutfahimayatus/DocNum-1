<?php

namespace App\Imports;

use App\Models\NIP;
use Maatwebsite\Excel\Concerns\ToModel;

class NIPImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new NIP([
            'nip'     => $row[0],
        ]);
    }
}
