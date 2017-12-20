<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 0;
        while ($count < 10000) {
            DB::table('users')->insert([
                'name' => random_bytes(10),
                'email' => random_bytes(10).'@gmail.com',
                'password' => bcrypt(random_bytes(6)),
                'remember_token' => bcrypt(random_bytes(6))
            ]);
            $count++;
        }

    }
}
