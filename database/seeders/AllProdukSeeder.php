<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InspirationalOutfit;
use App\Models\FeaturedItem;

class AllProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Inspirational Outfits
        InspirationalOutfit::create([
            'title' => '"Dare To Win" For The Dedicated Individuals',
            'image_path' => 'inspirational-outfits/inspirasi1.jpg',
            'date' => '2025-06-05',
            'position' => 'left',
            'order' => 1,
            'is_active' => true,
        ]);

        InspirationalOutfit::create([
            'title' => 'Made For Those Who Are Silent But Resilient',
            'image_path' => 'inspirational-outfits/inspirasi2.jpg',
            'date' => '2025-07-10',
            'position' => 'right',
            'order' => 2,
            'is_active' => true,
        ]);

        // Seed Featured Items
        FeaturedItem::create([
            'title' => 'Universe Collection',
            'image_path' => 'featured-items/banner2.jpg',
            'background_color' => '#343a40',
            'order' => 1,
            'is_active' => true,
        ]);

        FeaturedItem::create([
            'title' => 'Minimalist Shoes',
            'image_path' => 'featured-items/banner-sepatu.jpg',
            'background_color' => '#f8f9fa',
            'order' => 2,
            'is_active' => true,
        ]);

        FeaturedItem::create([
            'title' => 'Marvel Collection',
            'image_path' => 'featured-items/banner-sepatu2.jpg',
            'background_color' => '#7c3aed',
            'order' => 3,
            'is_active' => true,
        ]);

        FeaturedItem::create([
            'title' => 'Future Hoodie',
            'image_path' => 'featured-items/banner-hoodie.jpg',
            'background_color' => '#212529',
            'order' => 4,
            'is_active' => true,
        ]);
    }
}
