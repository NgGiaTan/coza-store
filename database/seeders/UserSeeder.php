<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    
    public function run()
    {
        $user = new User();
        $user->email = 'admin@localhost.com';
        $user->name = 'admin';
        $user->password = Hash::make('12345');
        $user->save();

        echo "User created successfully.";
}

}
//tao mat khau de copy vao phpmyadmin:
// php artisan tinker
// > use Illuminate\Support\Facades\Hash;
// > $hashedPassword = Hash::make('12345');

//chay file nay de tao user test:
//php artisan db:seed --class=UserSeeder