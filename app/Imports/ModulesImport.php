<?php

namespace App\Imports;

use App\Models\Module;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ModulesImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Module([
            'module_name' => $row['module_name'],
            'module_code' => $row['module_code'],
            'description' => $row['description'],
            'credits' => $row['credits'],
        ]);
    }
}
