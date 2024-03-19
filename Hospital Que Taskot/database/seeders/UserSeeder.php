<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('adminadmin');
        $admin->save();

        $patient = new User();
        $patient->name = 'Pasien Satu';
        $patient->email = 'pasien@pasien.com';
        $patient->password = Hash::make('pasienpasien');
        $patient->save();

        $adminRegistrasi = new User();
        $adminRegistrasi->name = 'Admin Registrasi';
        $adminRegistrasi->email ='adminRegistrasi@admin.com';
        $adminRegistrasi->password = Hash::make('adminregistrasi');
        $adminRegistrasi->save();

        $adminPoli = new User();
        $adminPoli->name = 'Admin Poli';
        $adminPoli->email ='adminPoli@admin.com';
        $adminPoli->password = Hash::make('adminpoli');
        $adminPoli->save();


        $adminRole = Role::create(['name' => 'admin']);
        $patientRole = Role::create(['name' => 'pasien']);
        $adminRegisterRole = Role::create(['name' => 'adminRegister']);
        $adminPoliRole = Role::create(['name' => 'adminPoli']);
        $admin->assignRole('admin');
        $adminRegistrasi->assignRole('adminRegister');
        $adminPoli->assignRole('adminPoli');
        $patient->assignRole('pasien');

    }
}
