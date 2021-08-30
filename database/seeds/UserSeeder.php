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
        $u = \App\User::create([
            'email'    => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        echo 'Created user '.$u->email.' with password "password"'.PHP_EOL;
    }
}
