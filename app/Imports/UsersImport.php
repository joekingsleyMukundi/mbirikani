<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public $role_id;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($role_id)
    {
        $this->role_id = $role_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email'=> $row['email'],
            'phone'=> $row['phone'],
            'password' => Hash::make($row['password']),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $user->assignRole($this->role_id);

        return $user;
    }
}
