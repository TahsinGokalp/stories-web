<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Tahsin Gökalp";
        $user->email = "tahsinsaan@gmail.com";
        $user->password = Hash::make("12345678");
        $user->save();

        $user = new User();
        $user->name = "Doğa İrem";
        $user->email = "dogairem@tahsingokalp.dev";
        $user->password = Hash::make("12345678");
        $user->save();
    }
}
