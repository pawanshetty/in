<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
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

        DB::table('roles')->delete();

       
        Role::create([
            'id'            => 1,
            'name'          => 'Admin',
            'description'   => 'The ADmin role, can create, edit, delete users and add to groups'
        ]);

        Role::create([
            'id'            => 2,
            'name'          => 'User',
            'description'   => 'You Exist, with or without groups'
        ]);
        
       
    }
}
