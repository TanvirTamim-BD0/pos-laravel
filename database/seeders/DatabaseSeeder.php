<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
	        PermissionTableSeeder::class,
	        RoleSeeder::class,
            AdminSeeder::class,
            SettingSeeder::class,
            InvoiceSeeder::class,
            DistrictSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            CustomerSeeder::class,
	    ]);
    }
}
