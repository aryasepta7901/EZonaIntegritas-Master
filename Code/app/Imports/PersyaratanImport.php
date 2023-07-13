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
        $persyaratan = Persyaratan::where('satker_id', $row['satker_id'])->where('tahun', $row['tahun'])->first();

        if ($persyaratan) {
            // Jika update
            $persyaratan->tahun = $row['tahun'];
            $persyaratan->satker_id = $row['satker_id'];
            $persyaratan->wbk = $row['wbk'];
            $persyaratan->wbbm = $row['wbbm'];
            // Update kolom lain yang ingin Anda perbarui
            $persyaratan->save();
        } else {
            // jika Create
            $persyaratan = new Persyaratan([
                'tahun' => $row['tahun'],
                'satker_id' => $row['satker_id'],
                'wbk' => $row['wbk'],
                'wbbm' => $row['wbbm'],
            ]);
            $persyaratan->save();
        }
    }
    public function rules(): array
    {
        return [
            'tahun' => 'required',
            'satker_id' => 'required',
            'wbk'  => 'required',
            'wbbm'  => 'required',
        ];
    }
}
