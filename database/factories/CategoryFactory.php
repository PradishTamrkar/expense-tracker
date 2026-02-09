<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
            'type'=>$this->faker->randomElement(['income','expense']),
            'icon'=>$this->faker->randomElement(['utensils','bus','house','laptop','walet']),
            'color'=>$this->faker->hexColor(),
            'description'=>$this->faker->sentence(),
            'is_active'=>true,
        ];
    }

    //custom state:only expense categories
    public function expense(): static
    {   
        return $this->state(function(array $attributes){
            return[
                'type'=>'expense',
            ];
        });
    }

    //custom state:only income categories
    public function income(): static
    {   
        return $this->state(function(array $attributes){
            return[
                'type'=>'income',
            ];
        });
    }
}
