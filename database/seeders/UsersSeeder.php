<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'first_name' => "System",
            'last_name' => "Adminstator",
            'email' => "admin@gmail.com",
            'phone' => "254720250520",
            'password' => "$2y$10\$IXEZh7l3ZivV/SRQBxZTZukMC1PlOcB.BAEqRbQ3cjCVoENyUILPK",
        ]);


        $user->assignRole('Super Admin');
    }

}
