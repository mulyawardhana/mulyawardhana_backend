<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Mulya Wardhana',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'author']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        // User ke Visitor
        $user = User::create([
            'name' => 'Mulya ',
            'email' => 'mulya@admin.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'visitor']);

        $permissions = Permission::where('name','article-lis')->pluck('id','id');

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
