<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (App::environment() === 'production') {
            exit('Nope Nope Nope');
        }

        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => "Pawan",
            'email' => 'pawanshetty@outlook.com',
            'password' => bcrypt('secret'),
            'role_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => "test",
            'email' => 'test@outlook.com',
            'password' => bcrypt('secret'),
            'role_id' => 1
        ]);
    }
}
