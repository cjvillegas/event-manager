<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(array (
        	[
        		'username' => 'user_one',
        		'password' => bcrypt('12341234'),
        		'first_name' => 'john',
        		'last_name' => 'doe',
        		'created_at' => \Carbon::now()
        	],
            [
        		'username' => 'user_two',
        		'password' => bcrypt('12341234'),
        		'first_name' => 'jane',
        		'last_name' => 'doe',
        		'created_at' => \Carbon::now()
        	]
        ));
    }
}
