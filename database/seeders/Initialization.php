<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/* Models */
use App\Http\Models\Contact;
use App\Http\Models\UserContact;
use App\Http\Models\User;

use DB;

class Initialization extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::beginTransaction();

        $now = date('Y-m-d H:i:s');

        $permission = array(
             ['name' => 'access_all', 'guard_name' => 'api' ,'created_at'=> $now ,'updated_at'=> $now],
             ['name' => 'customers_list', 'guard_name' => 'api' ,'created_at'=> $now ,'updated_at'=> $now],
             ['name' => 'customers_create', 'guard_name' => 'api' ,'created_at'=> $now ,'updated_at'=> $now],
             ['name' => 'customers_detail', 'guard_name' => 'api' ,'created_at'=> $now ,'updated_at'=> $now],
             ['name' => 'customers_delete', 'guard_name' => 'api' ,'created_at'=> $now ,'updated_at'=> $now],
             ['name' => 'customers_update', 'guard_name' => 'api' ,'created_at'=> $now ,'updated_at'=> $now],
         );

        Permission::insert($permission);

        $admin = Role::create(['name' => 'admin'])->givePermissionTo(['access_all']);
        Role::create(['name' => 'customer'])->givePermissionTo(['access_all']);

        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'BuildOne',
            'email' => 'admin@buildone.com',
            'phone' => '1234567',
            'city' => 'city',
            'country' => 'country',
            'password' => Hash::make('123456'),
            'status' => User::STATUS['active']

        ]);

        $user->assignRole('admin');

        DB::commit();
    }
}
