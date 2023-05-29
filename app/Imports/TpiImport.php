<?php

namespace App\Imports;

use App\Models\TPI;
use App\Models\anggota_tpi;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TpiImport implements ToModel, SkipsEmptyRows, WithHeadingRow, WithValidation, SkipsOnFailure, WithCalculatedFormulas
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = strtoupper(str_replace(' ', '', $row['nama'] . $row['tahun'] .  'wil' . $row['wilayah']));
        if (TPI::where('id', $id)->doesntExist()) {
            $tpi = new TPI([
                'id' => $id,
                'tahun' => $row['tahun'],
                'nama' => $row['nama'],
                'dalnis' => $row['dalnis'],
                'ketua_tim' => $row['ketua_tim'],
                'wilayah' => $row['wilayah'],
            ]);
            $tpi->save();

            if (empty($row['anggota_3']) && empty($row['anggota_2'])) {
                // Jika anggota_3 dan anggota_2 tidak diisi maka:
                $no = 1;
            } elseif (empty($row['anggota_3'])) {
                $no = 2;
            } else {
                $no = 3;
            }

            for ($i = 1; $i <= $no; $i++) {
                $anggota_tpi = new anggota_tpi([
                    'id' => $id . $row['anggota_' . $i],
                    'tpi_id' => $id,
                    'anggota_id' => $row['anggota_' . $i],
                ]);
                $anggota_tpi->save();
            }
        }
    }
    public function rules(): array
    {
        return [
            'id' => 'unique:tpi',
            'tahun' => 'required',
            'nama' => 'required',
            'wilayah'  => 'required',
            'dalnis'  => 'required',
            'ketua_tim'  => 'required',
        ];
    }
    // Menggunakan opsi setCalculateFormulas untuk mengambil hasil dari rumus
    public function getCalculatedFormulas(): bool
    {
        return true;
    }
}
