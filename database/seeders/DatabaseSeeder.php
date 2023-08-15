<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
        ]);

        $this->seedDemoRestaurants();

        $vendorDemo = User::where('email', 'vendor@admin.com')->first();
        $restaurantDemo = Restaurant::first();

        $restaurantDemo->owner_id = $vendorDemo->id;
        $restaurantDemo->save();
    }


    /**
     * Product::factory(7) defines a Product Factory of seven Products. It doesn't actually create these Products immediately because we didn't call create() method.
     * Category::factory(5)->has($products) - We define a Factory of five Categories and each category will contain seven distinct products.
     * Following the same logic each Restaurant will have five distinct Categores defined by CategoryFactory, and each Vendor user will have a single restaurant.
     * When we finally call ->create() method, all entries in the database are created at once and all models will have correct relationships.
     */
    public function seedDemoRestaurants()
    {
        $products   = Product::factory(7);
        $categories = Category::factory(5)->has($products);
        $restaurant = Restaurant::factory()->has($categories);

        $staffMember = User::factory()->staff();
        $restaurant  = Restaurant::factory()->has($categories)->has($staffMember, 'staff');

        User::factory(50)->vendor()->has($restaurant)->create();
    }
}
