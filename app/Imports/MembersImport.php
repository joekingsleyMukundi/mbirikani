<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class MembersImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Member([
            'membership_number' => $row['membership_number'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'id_no' => $row['national_identification_number'],
            'sex' => $row['sex'] ?? "",
            'age' => $row['age'] ?? "",
            'email'=> $row['email'] ?? "",
            'phone'=> $row['phone'] ?? "",
            'kra'=> $row['kra'],
            'password' => Hash::make("password"),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function rules(): array
    {
        return [
            'membership_number' => 'required|unique:members',
            'first_name' => 'required',
            'last_name' => 'required',
            'id_no' => 'nullable',
            'sex' => 'nullable',
            'age' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'kra' => 'nullable',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
