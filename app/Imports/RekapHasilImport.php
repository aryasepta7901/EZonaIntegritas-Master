<?php

namespace App\Imports;

use App\Models\RekapHasil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RekapHasilImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        for ($i = 1; $i <= 3; $i++) {
            if ($i = 1) {
                $pilar_id = 'HBA';
                $opsi_id = $row['IPAK'];
            } elseif ($i = 2) {
                $pilar_id = 'HPA';
                $opsi_id = $row['Capaian_Kinerja'];
            } elseif ($i = 3) {
                $pilar_id = 'HPA';
                $opsi_id = $row['Capaian_Kinerja'];
            }
            $tahun = $row['tahun'];
            $satker = $row['satker'];
            $id = $tahun . $satker . $pilar_id;
            $RekapHasil = new RekapHasil([
                'id' => $id,
                'tahun' => $tahun,
                'opsi_id' => $opsi_id,
                'pilar_id' => $pilar_id,
                'nilai' => 'nilai',
                'satker_id' => $satker,
            ]);
            $RekapHasil->save();
        }
    }
    public function rules(): array
    {
        return [
            // 'id' => 'required|unique:users',
            // 'name'  => 'required|min:5',
            // 'email'  => 'required|email:dns|unique:users',
            // 'no_telp' => 'required|min:11',
            // 'satker_id' => 'required',
            // 'level_id' => 'required',
        ];
    }
}
