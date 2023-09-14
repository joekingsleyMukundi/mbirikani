<?php
namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Setting::create([
            'business_name' => "Webmasters Ranch Management",
            'business_phone' => "254720250520",
            'business_email' => "admin@webmasters.co.ke",
            'business_location' => "Nairobi, Kilimani, Menelik Road, Shiloh Residence",
        ]);


    }

}
