<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent = Role::where('name', User::PARENT)->firstOrFail();
        $child = Role::where('name', User::CHILD)->firstOrFail();

        $user = new User();
        $user->name = 'Parent';
        $user->email = 'parent@test.com';
        $user->password = Hash::make('12345678');
        $user->save();
        $user->assignRole($parent);

        $user = new User();
        $user->name = 'Child';
        $user->email = 'child@test.com';
        $user->password = Hash::make('12345678');
        $user->save();
        $user->assignRole($child);
    }
}
