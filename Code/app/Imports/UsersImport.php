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
        $id = $row['nip'];
        $user = User::where('id', $id)->first();
        if ($user) {
            // Jika Update
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->no_telp = $row['no_telp'];
            $user->satker_id = $row['satker_id'];
            $user->level_id = $row['level_id'];
            $user->save();
        } else {
            // jika Create
            $User = new User([
                'id' => $id,
                'name' => $row['name'],
                'email' => $row['email'],
                'no_telp' => $row['no_telp'],
                'satker_id' => $row['satker_id'],
                'level_id' => $row['level_id'],
            ]);
            $User->save();
        }
    }
    public function rules(): array
    {
        return [
            'name'  => 'required|min:5',
            'email'  => 'required',
            'no_telp' => 'required|min:11|max:14',
            'satker_id' => 'required',
            'level_id' => 'required',
        ];
    }
}
