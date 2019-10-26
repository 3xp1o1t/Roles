<?php

use App\Product;
use Caffeinated\Shinobi\Models\Permission;
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
        $this->call([
            PermissionsTableSeeder::class,
            UsersTableSeeder::class,
            ProductsTableSeeder::class
        ]);
    }
}
