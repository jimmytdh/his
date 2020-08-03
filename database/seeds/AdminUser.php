<?php

use Illuminate\Database\Seeder;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'fname' => 'Jimmy',
            'lname' => 'Lomocso',
            'pos_code' => 1,
            'dept_code' => 1,
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'level' => 'admin',
            'status' => 1
        ]);

        DB::table('user')->insert([
            'fname' => 'Von',
            'lname' => 'Cabiluna',
            'pos_code' => 2,
            'dept_code' => 2,
            'username' => 'von',
            'password' => bcrypt('von'),
            'level' => 'standard',
            'status' => 1
        ]);

        DB::table('department')->insert([
            'abbr' => 'IHOMP',
            'name' => 'Integrated Hospital Operations and Management Program'
        ]);

        DB::table('department')->insert([
            'abbr' => 'IMCU',
            'name' => 'Intermediate Care Unit'
        ]);

        DB::table('position')->insert([
            'abbr' => 'CMT II',
            'name' => 'Computer Maintenance Technologist II'
        ]);

        DB::table('position')->insert([
            'abbr' => 'Nursing 1',
            'name' => 'Nursing 1'
        ]);
    }
}
