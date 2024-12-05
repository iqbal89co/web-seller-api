<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();
        DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Role::insert([
            [
                'slug' => 'administrator',
                'name' => 'Administrator',
            ],
            [
                'slug' => 'customer',
                'name' => 'Customer'
            ]
        ]);

        Permission::insert([
            [
                'name' => 'checkout'
            ],
            [
                'name' => 'manage-products'
            ],
            [
                'name' => 'manage-transactions'
            ],
            [
                'name' => 'manage-master'
            ]
        ]);

        $administrator = Role::where('name', 'administrator')->first();

        $administrator->permissions()->attach(
            Permission::whereIn('name', ['checkout', 'manage-products', 'manage-transactions', 'manage-master'])->pluck('id')
        );

        $customer = Role::where('name', 'customer')->first();
        $customer->permissions()->attach(
            Permission::where('name', 'checkout')->pluck('id')
        );

        $users = [
            [
                'name' => 'Admin Testing',
                'email' => 'admin@testing.com',
                'password' => bcrypt('password'),
                'role'  => 'administrator'
            ],
            [
                'name' => 'Customer Testing',
                'email' => 'customer@testing.com',
                'password' => bcrypt('password'),
                'role'  => 'customer'
            ],
        ];
        foreach ($users as $user) {
            $newUser = User::where('email', $user['email'])->first();
            if (!$newUser) {
                $newUser = new User();
            }
            $newUser->name = $user['name'];
            $newUser->email = $user['email'];
            $newUser->password = $user['password'];
            $newUser->save();
            $newUser->roles()->attach($customer->id);

            if ($user['role'] === 'administrator') {
                $newUser->roles()->attach($administrator->id);
                $newUser->active_role_id = $administrator->id;
            } else {
                $newUser->active_role_id = $customer->id;
            }
            $newUser->save();
        }

        DB::commit();
    }
}
