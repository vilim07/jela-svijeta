<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Lang;
use App\Models\Meal;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Insert data into the 'lang' table
        //This is done because in order to use Astronomic laravel/translatable the used locales must be in the translatable.php file
        $locales = config('translatable.locales');
        foreach ($locales as $locale){
            DB::table('langs')->insert([
                ['locale' => $locale],
            ]);
        }

        Category::factory(5)->create();
        Tag::factory(10)->create();
        Ingredient::factory(10)->create();


        // Create meals without categories but with tags and ingredients
        Meal::factory(5)->create()->each(function ($meal) {
            // Attach at least one tag to each meal
            $tags = Tag::inRandomOrder()->take(mt_rand(1, 5))->pluck('id');
            $meal->tags()->attach($tags);

            // Attach one or more ingredients to each meal
            $ingredients = Ingredient::inRandomOrder()->take(mt_rand(1, 5))->pluck('id');
            $meal->ingredients()->attach($ingredients);
        });

        // Create meals with categories and with tags and ingredients
        Meal::factory(5)->create()->each(function ($meal) {
            // Attach at least one tag to each meal
            $tags = Tag::inRandomOrder()->take(mt_rand(1, 5))->pluck('id');
            $meal->tags()->attach($tags);

            // Attach one or more ingredients to each meal
            $ingredients = Ingredient::inRandomOrder()->take(mt_rand(1, 5))->pluck('id');
            $meal->ingredients()->attach($ingredients);

            // Associate a category to some meals
            $category = Category::inRandomOrder()->first();
            $meal->category()->associate($category);
            $meal->save();
        });


        // Delete two meals
        $mealsToDelete = Meal::inRandomOrder()->take(3)->get();
        $mealsToDelete->each(function ($meal) {
            $meal->delete();
        });
    }
}
