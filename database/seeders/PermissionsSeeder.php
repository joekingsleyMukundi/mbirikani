<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = static::allPermissions();

        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);

        foreach ($permissions as $k => $v){
            $permission = Permission::query()->create(["name" => $v['name'], "description" => $v['display_name'], "guard_name" => 'web']);

            $role->givePermissionTo($permission);
        }

    }

    public static function allPermissions(): array
    {
        $perms =  [
            "dashboards:main" => "View Main Dashboard",

            "users:list" => "List Staff",
            "users:create" => "Create Staff",
            "users:read" => "View Staff",
            "users:update" => "Update Staff",
            "users:delete" => "Delete Staff",
            "users:import" => "Import Staff",
            "users:export" => "Export Staff",

            "members:list" => "List Member",
            "members:create" => "Create Member",
            "members:read" => "View Member",
            "members:update" => "Update Member",
            "members:delete" => "Delete Member",
            "members:import" => "Import Member",
            "members:export" => "Export Member",

            "areas:list" => "List Areas",
            "areas:create" => "Create Areas",
            "areas:read" => "View Areas",
            "areas:update" => "Update Areas",
            "areas:delete" => "Delete Areas",
            "areas:import" => "Import Areas",
            "areas:export" => "Export Areas",

            "uses:list" => "List Land Categories",
            "uses:create" => "Create Land Categories",
            "uses:read" => "View Land Categories",
            "uses:update" => "Update Land Categories",
            "uses:delete" => "Delete Land Categories",
            "uses:import" => "Import Land Categories",
            "uses:export" => "Export Land Categories",

            "assets:list" => "List Group Ranch",
            "assets:create" => "Create  Group Ranch",
            "assets:read" => "View  Group Ranch",
            "assets:update" => "Update  Group Ranch",
            "assets:delete" => "Delete  Group Ranch",
            "assets:import" => "Import  Group Ranch",
            "assets:export" => "Export  Group Ranch",

            "subassets:list" => "List Parcels",
            "subassets:create" => "Create Parcels",
            "subassets:read" => "View Parcels",
            "subassets:update" => "Update Parcels",
            "subassets:delete" => "Delete Parcels",
            "subassets:import" => "Import Parcels",
            "subassets:export" => "Export Parcels",

            "allocations:list" => "List Allotments",
            "allocations:create" => "Create Allotments",
            "allocations:read" => "View Allotments",
            "allocations:update" => "Update Allotments",
            "allocations:delete" => "Delete Allotments",
            "allocations:import" => "Import Allotments",
            "allocations:export" => "Export Allotments",

            "audits:list" => "View Audits",

            "settings:list" => "Settings",
            "settings:general" => "General Settings",

            "roles:list" => "List Roles",
            "roles:create" => "Create Roles",
            "roles:read" => "View Roles",
            "roles:update" => "Update Roles",
            "roles:delete" => "Delete Roles",

            "reports:read" => "View Reports",

        ];

        $all = [];

        foreach ($perms as $name => $desc) {
            $all[] = [ "name" => $name, "display_name" => $desc];
        }

        return $all;
    }
}
