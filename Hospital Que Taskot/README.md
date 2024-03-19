## instalasi
- npm install
- composer install

## migrasi db
- php artisan migrate
- php artisan db:seed --class=UserSeeder

## cara jalanin
- di tab 1 : npm run dev
- di tab 2 : php artisan serve

## username dan password
- admin 1
        name = 'Admin';
        email = 'admin@admin.com';
        password = Hash::make('adminadmin');
- pasien
        name = 'Pasien Satu';
        email = 'pasien@pasien.com';
        password = Hash::make('pasienpasien');
- admin registrasi 
        name = 'Admin Registrasi';
        email ='adminRegistrasi@admin.com';
        password = Hash::make('adminregistrasi');
- admin Poli
        name = 'Admin Poli';
        email ='adminPoli@admin.com';
        password = Hash::make('adminpoli');


suka lupa super admin : partial nav.blade