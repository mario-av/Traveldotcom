<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Review;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Database Seeder - Seeds initial data for the application.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@travel.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
        ]);

        
        $advanced = User::factory()->create([
            'name' => 'Advanced User',
            'email' => 'advanced@travel.com',
            'password' => Hash::make('password'),
            'rol' => 'advanced',
        ]);

        
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@travel.com',
            'password' => Hash::make('password'),
            'rol' => 'user',
        ]);

        
        $users = User::factory(5)->create();

        
        $categories = collect([
            ['name' => 'Beach', 'description' => 'Relaxing beach destinations with sun and sand.'],
            ['name' => 'Mountain', 'description' => 'Adventure in the mountains with hiking and nature.'],
            ['name' => 'City', 'description' => 'Urban exploration and cultural experiences.'],
            ['name' => 'Adventure', 'description' => 'Thrilling adventures and extreme sports.'],
            ['name' => 'Cultural', 'description' => 'Historical sites and cultural immersion.'],
        ])->map(fn($data) => Category::create($data));

        
        $paris = Vacation::factory()->create([
            'title' => 'Romantic Paris Getaway',
            'description' => 'Experience the magic of Paris with a 5-day trip including a Seine river cruise and Eiffel Tower dinner.',
            'location' => 'Paris, France',
            'price' => 1200.00,
            'duration_days' => 5,
            'available_slots' => 20,
            'active' => true,
            'featured' => true,
            'category_id' => $categories->firstWhere('name', 'City')->id,
            'user_id' => $admin->id,
        ]);

        $tokyo = Vacation::factory()->create([
            'title' => 'Tokyo Technology & Culture',
            'description' => 'Explore the vibrant streets of Tokyo, visit ancient temples, and enjoy world-class sushi.',
            'location' => 'Tokyo, Japan',
            'price' => 2500.00,
            'duration_days' => 7,
            'available_slots' => 15,
            'active' => true,
            'featured' => true,
            'category_id' => $categories->firstWhere('name', 'City')->id,
            'user_id' => $admin->id,
        ]);

        $cancun = Vacation::factory()->create([
            'title' => 'Cancun All-Inclusive Resort',
            'description' => 'Relax on the white sandy beaches of Cancun with unlimited food and drinks.',
            'location' => 'Cancun, Mexico',
            'price' => 1800.00,
            'duration_days' => 6,
            'available_slots' => 30,
            'active' => true,
            'featured' => false,
            'category_id' => $categories->firstWhere('name', 'Beach')->id,
            'user_id' => $admin->id,
        ]);

        $safari = Vacation::factory()->create([
            'title' => 'Kenyan Safari Adventure',
            'description' => 'Witness the Big Five in their natural habitat on this thrilling safari in Masai Mara.',
            'location' => 'Masai Mara, Kenya',
            'price' => 3500.00,
            'duration_days' => 8,
            'available_slots' => 10,
            'active' => true,
            'featured' => true,
            'category_id' => $categories->firstWhere('name', 'Adventure')->id,
            'user_id' => $advanced->id,
        ]);

        $alps = Vacation::factory()->create([
            'title' => 'Swiss Alps Ski Trip',
            'description' => 'Ski on the best slopes in the world and enjoy cozy chalets in Zermatt.',
            'location' => 'Zermatt, Switzerland',
            'price' => 2200.00,
            'duration_days' => 5,
            'available_slots' => 25,
            'active' => true,
            'featured' => false,
            'category_id' => $categories->firstWhere('name', 'Mountain')->id,
            'user_id' => $advanced->id,
        ]);

        $vacations = collect([$paris, $tokyo, $cancun, $safari, $alps]);

        
        Photo::create(['vacation_id' => $paris->id, 'path' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', 'is_main' => true]); 
        Photo::create(['vacation_id' => $paris->id, 'path' => 'https://images.unsplash.com/photo-1500318534783-7c87c0245cbd?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $paris->id, 'path' => 'https://images.unsplash.com/photo-1471623320832-752e8bdd164d?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $paris->id, 'path' => 'https://images.unsplash.com/photo-1522093007474-d86e9bf7ba6f?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 

        
        Photo::create(['vacation_id' => $tokyo->id, 'path' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', 'is_main' => true]); 
        Photo::create(['vacation_id' => $tokyo->id, 'path' => 'https://images.unsplash.com/photo-1536098561742-ca998e48cbcc?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $tokyo->id, 'path' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $tokyo->id, 'path' => 'https://images.unsplash.com/photo-1526481280693-3bfa1367dec0?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 

        
        Photo::create(['vacation_id' => $cancun->id, 'path' => 'https://images.unsplash.com/photo-1544525866-c9545dc46853?auto=format&fit=crop&w=800&q=80', 'is_main' => true]); 
        Photo::create(['vacation_id' => $cancun->id, 'path' => 'https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $cancun->id, 'path' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $cancun->id, 'path' => 'https://images.unsplash.com/photo-1473116763249-56381a355a10?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 

        
        Photo::create(['vacation_id' => $safari->id, 'path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80', 'is_main' => true]); 
        Photo::create(['vacation_id' => $safari->id, 'path' => 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $safari->id, 'path' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $safari->id, 'path' => 'https://images.unsplash.com/photo-1547471080-7541fbe39779?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 

        
        Photo::create(['vacation_id' => $alps->id, 'path' => 'https://images.unsplash.com/photo-1482869359363-233bb977465f?auto=format&fit=crop&w=800&q=80', 'is_main' => true]); 
        Photo::create(['vacation_id' => $alps->id, 'path' => 'https://images.unsplash.com/photo-1551524316-b86a0767e7c8?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $alps->id, 'path' => 'https://images.unsplash.com/photo-1498855926480-d98e83099315?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 
        Photo::create(['vacation_id' => $alps->id, 'path' => 'https://images.unsplash.com/photo-1465056836041-7f43ac27dcb5?auto=format&fit=crop&w=800&q=80', 'is_main' => false]); 

        
        $randomVacations = Vacation::factory(50)->create([
            'user_id' => $admin->id,
            'category_id' => $categories->random()->id,
        ])->each(function ($vacation) {
            
            Photo::factory()->count(2)->create(['vacation_id' => $vacation->id]);
            Photo::factory()->main()->create(['vacation_id' => $vacation->id]);
        });

        
        $vacations = collect([$paris, $tokyo, $cancun, $safari, $alps])->merge($randomVacations);

        
        Booking::factory(30)
            ->recycle($users->merge([$advanced, $testUser]))
            ->recycle($vacations)
            ->create();

        
        Booking::factory()->create([
            'user_id' => $testUser->id,
            'vacation_id' => $paris->id,
            'created_at' => now()->subDays(10), 
        ]);

        Booking::factory()->create([
            'user_id' => $testUser->id,
            'vacation_id' => $tokyo->id,
            'created_at' => now()->subDays(2), 
        ]);

        
        Review::factory(20)
            ->approved()
            ->recycle($users->merge([$advanced, $testUser]))
            ->recycle($vacations)
            ->create();

        
        
        Review::factory()->create([
            'user_id' => $testUser->id,
            'vacation_id' => $paris->id,
            'rating' => 5,
            'content' => 'Paris was absolutely magical! The dinner at the Eiffel Tower was the highlight.',
            'approved' => true,
        ]);

        
        Review::factory()->create([
            'user_id' => $testUser->id,
            'vacation_id' => $tokyo->id,
            'rating' => 4,
            'content' => 'Tokyo is amazing, but the flight was long. The sushi class was top notch though!',
            'approved' => false, 
        ]);
    }
}
