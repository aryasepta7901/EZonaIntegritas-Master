<?php

namespace App\Imports;

use App\Models\Persyaratan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PersyaratanImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithCalculatedFormulas
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Persyaratan([
            'id' => $row['id'],
            'tahun' => $row['tahun'],
            'satker_id' => $row['satker_id'],
            'wbk' => $row['wbk'],
            'wbbm' => $row['wbbm'],
        ]);
    }
    public function rules(): array
    {
        return [
            'id' => 'unique:persyaratan',
            'tahun' => 'required',
            'satker_id' => 'required',
            'wbk'  => 'required',
            'wbbm'  => 'required',
        ];
    }
}
