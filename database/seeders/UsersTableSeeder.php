<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->delete();

        DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'ELIAS VEGA DELGADO',
                'number' => '91260182',
                'address' => 'Carrera 21 # 99-27 Fontana',
                'phone' => '3168886468',
                'email' => 'discom.is@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$mYqyo8WMZY4WyKM8g6DJ9.qaSok6TtPrh4jJvvp1LQd52RJSB0hEm',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'remember_token' => NULL,
                'current_team_id' => NULL,
                'profile_photo_path' => NULL,
                'position' => 'Administrador Sistema',
                'transfer' => 1,
                'status' => 'activo',
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
                'company_id' => 1,
                'branch_id' => 1,
                'document_id' => 3,
                'role_id' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Ecounts dos',
                'number' => '91260183',
                'address' => 'Carrera 33 # 98-27 Bucaramanga',
                'phone' => '3168666468',
                'email' => 'ecountsdos@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$vJbGCfozckE5G99BLeKEPukdScAKRItAzpyu3ipEo3pV.Pit0W/Qy',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'remember_token' => NULL,
                'current_team_id' => NULL,
                'profile_photo_path' => NULL,
                'position' => 'Administrativo',
                'transfer' => 1,
                'status' => 'activo',
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
                'company_id' => 1,
                'branch_id' => 1,
                'document_id' => 3,
                'role_id' => 2,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Ecounts tres',
                'number' => '91260184',
                'address' => 'Carrera 45 # 58-47 Bucaramanga',
                'phone' => '3168666479',
                'email' => 'ecountstres@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$PQZtUCzoWJn8euBCMcyESeM8/2SPqA.ms92eJsJs5/UPoxUyjF3Cm',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'remember_token' => NULL,
                'current_team_id' => NULL,
                'profile_photo_path' => NULL,
                'position' => 'Supervisor',
                'transfer' => 1,
                'status' => 'activo',
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
                'company_id' => 1,
                'branch_id' => 2,
                'document_id' => 3,
                'role_id' => 3,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Ecounts cuatro',
                'number' => '91260185',
                'address' => 'Carrera 6 # 12-27 Bucaramanga',
                'phone' => '316458468',
                'email' => 'ecountscuatro@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$ksmHBTY5ODmHIf53wxq/seM9M6J9zBMugytMWajjFPwwKks3v6EYa',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'remember_token' => NULL,
                'current_team_id' => NULL,
                'profile_photo_path' => NULL,
                'position' => 'Compras',
                'transfer' => 0,
                'status' => 'activo',
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
                'company_id' => 1,
                'branch_id' => 3,
                'document_id' => 3,
                'role_id' => 4,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Ecounts cinco',
                'number' => '91260186',
                'address' => 'Carrera 60 # 22-77 Bucaramanga',
                'phone' => '3164758468',
                'email' => 'ecountscinco@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$XC0.4WWMczaCI2QenaZ3sOLvX6BqUzSllpHypegSQz3g68AstH5ga',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'remember_token' => NULL,
                'current_team_id' => NULL,
                'profile_photo_path' => NULL,
                'position' => 'Ventas',
                'transfer' => 0,
                'status' => 'activo',
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
                'company_id' => 1,
                'branch_id' => 4,
                'document_id' => 3,
                'role_id' => 5,
            ),
        ));


    }
}
