<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Rincian;
use App\Models\Satker;
use App\Models\StatusRekap;
use App\Models\SubRincian;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $level = [
            [
                'id' => 'A',
                'name' => 'Admin',
            ],
            [
                'id' => 'AT',
                'name' => 'Anggota Tim',
            ],
            [
                'id' => 'DL',
                'name' => 'Pengendali Teknis',
            ],
            [
                'id' => 'EP',
                'name' => 'Evaluator Provinsi',
            ],
            [
                'id' => 'KT',
                'name' => 'Ketua Tim',
            ],
            [
                'id' => 'PT',
                'name' => 'PIC Satker',
            ],

        ];
        Level::insert($level);

        $rincian = [
            [
                'id' => 'H',
                'rincian' => 'Hasil',
                'bobot' => 40.00,
            ],
            [
                'id' => 'P',
                'rincian' => 'Pengungkit',
                'bobot' => 60.00,
            ]
        ];
        Rincian::insert($rincian);

        $status_rekap = [
            // [
            //     'id' => 0,
            //     'status' => 'Penilaian Mandiri',
            // ],
            [
                'id' => 1,
                'status' => 'Proses Penilaian BPS Provinsi',
            ],
            [
                'id' => 2,
                'status' => 'Tindak Lanjut BPS Provinsi',
            ],
            [
                'id' => 3,
                'status' => 'Tidak Diusulkan BPS Provinsi',
            ],
            [
                'id' => 4,
                'status' => 'Proses Penilaian TPI',
            ],
            [
                'id' => 5,
                'status' => 'Tindak Lanjut TPI ',
            ],
            [
                'id' => 6,
                'status' => 'Diusulkan BPS RI',
            ],
            [
                'id' => 7,
                'status' => 'Tidak Diusulkan BPS RI',
            ],
            [
                'id' => 8,
                'status' => 'Cetak Surat Pengantar Provinsi',
            ],
        ];
        StatusRekap::insert($status_rekap);

        $subRincian = [
            [
                'id' => 'HB',
                'subRincian' => 'Birokrasi yang bersih dan akuntabel',
                'bobot' => 22.5,
                'rincian_id' => 'H'
            ],
            [
                'id' => 'HP',
                'subRincian' => 'Pelayanan Publik yang Prima',
                'bobot' => 17.5,
                'rincian_id' => 'H'
            ],
            [
                'id' => 'PP',
                'subRincian' => 'Pemenuhan',
                'bobot' => 30,
                'rincian_id' => 'P'
            ],
            [
                'id' => 'PR',
                'subRincian' => 'Reform',
                'bobot' => 30,
                'rincian_id' => 'P'
            ],
        ];
        SubRincian::insert($subRincian);

        $satker = [
            [
                'id' => '1000',
                'nama_sakter' => 'Inspektorat Utama',
                'wilayah' => '1',
            ]
        ];
        // Satker::insert($satker);

        $user = [
            [
                'id' => '11123123121',
                'name' => 'M.Arya',
                'email' => 'aryasepta7901@gmail.com',
                'no_telp' => '082279157895',
                'satker_id' => '1000',
                'level_id' => 'A',
            ]
        ];
        User::insert($user);
    }
}
