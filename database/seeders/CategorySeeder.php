<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'=>'Food & Drinks',
                'slug'=>'food-drinks',
                'type'=>'expense',
                'icon'=>'utensils',
                'color'=>'#FF5733',
                'description'=>'Grocesries, resturants,  cafes',
                'is_active'=>true,
            ],
            [
                'name'=>'Transportation',
                'slug'=>'transportation',
                'type'=>'expense',
                'icon'=>'bus',
                'color'=>'#349808',
                'description'=>'Bus, taxi, fuel fairs',
                'is_active'=>true,
            ],
            [
                'name'=>'Housing',
                'slug'=>'housing',
                'type'=>'expense',
                'icon'=>'house',
                'color'=>'#E74C3C',
                'description'=>'Rent, Maintainence',
                'is_active'=>true,
            ],
            [
                'name'=>'Utilities',
                'slug'=>'utilities',
                'type'=>'expense',
                'icon'=>'lightbulb',
                'color'=>'#F39C12',
                'description'=>'Electricity, water, internet',
                'is_active'=>true,
            ],
            [
                'name' => 'Healthcare',
                'slug' => 'healthcare',
                'type' => 'expense',
                'icon' => 'hospital',
                'color' => '#E91E63',
                'description' => 'Medicine, doctor visits',
                'is_active' => true,
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'type' => 'expense',
                'icon' => 'graduation-cap',
                'color' => '#9B59B6',
                'description' => 'Books, courses, tuition',
                'is_active' => true,
            ],
            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
                'type' => 'expense',
                'icon' => 'gamepad',
                'color' => '#1ABC9C',
                'description' => 'Movies, games, hobbies',
                'is_active' => true,
            ],
            [
                'name' => 'Shopping',
                'slug' => 'shopping',
                'type' => 'expense',
                'icon' => 'shopping-bag',
                'color' => '#FF9800',
                'description' => 'Clothes, electronics',
                'is_active' => true,
            ],
            [
                'name' => 'Freelance',
                'slug' => 'freelance',
                'type' => 'income',
                'icon' => 'laptop',
                'color' => '#27AE60',
                'description' => 'Freelance work income',
                'is_active' => true,
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'type' => 'income',
                'icon' => 'chart-line',
                'color' => '#16A085',
                'description' => 'Business income',
                'is_active' => true,
            ],
            [
                'name' => 'Other Income',
                'slug' => 'other-income',
                'type' => 'income',
                'icon' => 'wallet',
                'color' => '#00BCD4',
                'description' => 'Tuition, gifts, etc',
                'is_active' => true,
            ],
        ];

        foreach($categories as $category){
            Category::create($category);
        }

        $this->command->info('Categories seeded successfully');
    }
}
