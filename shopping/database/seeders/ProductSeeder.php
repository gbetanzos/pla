<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Apples', 'brand' => 'Del Monte'],
            ['name' => 'Bananas', 'brand' => 'Florida'],
            ['name' => 'Oranges', 'brand' => 'Calfresh'],
            ['name' => 'Milk', 'brand' => 'Horizon'],
            ['name' => 'Eggs', 'brand' => 'Tyson'],
            ['name' => 'Bread', 'brand' => "Dave's"],
            ['name' => 'Butter', 'brand' => 'Anchor'],
            ['name' => 'Cheese', 'brand' => 'Tillamook'],
            ['name' => 'Yogurt', 'brand' => 'Chobani'],
            ['name' => 'Cereal', 'brand' => "Kellogg's"],
            ['name' => 'Pasta', 'brand' => 'Barilla'],
            ['name' => 'Tomato Sauce', 'brand' => 'Prego'],
            ['name' => 'Spaghetti', 'brand' => "De'Luzio"],
            ['name' => 'Rice', 'brand' => "Uncle Ben's"],
            ['name' => 'Beans', 'brand' => 'Goya'],
            ['name' => 'Salsa', 'brand' => 'Hormel'],
            ['name' => 'Chicken Breast', 'brand' => 'Perdue'],
            ['name' => 'Ground Beef', 'brand' => "Butcher's Circle"],
            ['name' => 'Coffee Beans', 'brand' => 'Starbucks'],
            ['name' => 'Tea Bags', 'brand' => 'Lipton'],
            ['name' => 'Pancake Mix', 'brand' => 'Tostitos'],
            ['name' => 'Canned Soup', 'brand' => "Campbell's"],
            ['name' => 'Potatoes', 'brand' => "J'sBaby"],
            ['name' => 'Onions', 'brand' => 'Fresh'],
            ['name' => 'Carrots', 'brand' => 'Fresh'],
            ['name' => 'Lettuce', 'brand' => 'Fresh'],
            ['name' => 'Cucumbers', 'brand' => 'Fresh'],
            ['name' => 'Frozen Peas', 'brand' => 'Birds Eye'],
            ['name' => 'Olive Oil', 'brand' => 'Olive Garden']
        ];
        Product::insert($data);
    }
}
