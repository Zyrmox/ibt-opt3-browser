<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $initial_user = [
            'name' => '',
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ];
        CreateNewUser::create($initial_user)
    }
}
