<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [

            [

               'name'=>'admin',

               'email'=>'admin@annajar.com',

                'is_admin'=>'1',
                
                'is_parentAdmin' => '1',

               'password'=> bcrypt('Annajar1999'),

            ],

            [

               'name'=>'User',

               'email'=>'user@annajar.com',

                'is_admin'=>'1',

                'is_parentAdmin' => '1',

               'password'=> bcrypt('Annajar1999'),

            ],

        ];

  

        foreach ($user as $key => $value) {

            User::create($value);

        }
    }
}
