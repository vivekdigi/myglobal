<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'  => $row['name'],
            'email' => $row['email'],
            'username' => $row['username'],
            'phone' => $row['phone_number'],
            'country' => $row['country'],
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
