<?php

namespace App\Imports;

use App\Models\Opsi;
use App\Models\Pilar;
use App\Models\RekapHasil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
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
            if ($i == 1) {
                $pilar_id = 'HBA';
                $opsi_id = $row['ipak'];
            } elseif ($i == 2) {
                $pilar_id = 'HBB';
                $opsi_id = $row['capaian_kinerja'];
            } elseif ($i == 3) {
                $pilar_id = 'HPA';
                $opsi_id = $row['ipkp'];
            }

            $bobot = Pilar::where('id', $pilar_id)->first('bobot')->bobot;
            $tahun = $row['tahun'];
            $satker = $row['satker'];
            $id = $tahun . $satker . $pilar_id;

            $rekapHasil = RekapHasil::where('id', $id)->first();


            if ($rekapHasil) {
                // Update
                $rekapHasil->opsi_id = $opsi_id;
                $rekapHasil->nilai =  Opsi::where('id', $opsi_id)->first()->bobot * $bobot;
                // Update kolom lain yang ingin Anda perbarui
                $rekapHasil->save();
                // Hapus data anggota
            } else {
                // Jika update
                $RekapHasil = new RekapHasil([
                    'id' => $id,
                    'tahun' => $tahun,
                    'opsi_id' => $opsi_id,
                    'pilar_id' => $pilar_id,
                    'nilai' => Opsi::where('id', $opsi_id)->first()->bobot * $bobot,
                    'satker_id' => $satker,
                ]);
                $RekapHasil->save();
            }
        }
    }
    public function rules(): array
    {
        return [
            'tahun'  => 'required',
            'satker'  => 'required',
            'ipak'  => 'required',
            'capaian_kinerja'  => 'required',
            'ipkp'  => 'required',
        ];
    }
}
