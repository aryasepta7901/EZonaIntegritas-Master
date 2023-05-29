<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'no_telp' => $row['no_telp'],
            'satker_id' => $row['satker_id'],
            'level_id' => $row['level_id'],
        ]);
    }
    public function rules(): array
    {
        return [
            'id' => 'required|unique:users',
            'name'  => 'required|min:5',
            'email'  => 'required|email:dns|unique:users',
            'no_telp' => 'required|min:11|max:14',
            'satker_id' => 'required',
            'level_id' => 'required',
        ];
    }
}
