<?php

namespace Database\Seeders;

use App\Models\BerandaImage;
use Illuminate\Database\Seeder;

class BerandaImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            // Carousel Images
            [
                'type' => 'carousel',
                'image_path' => 'image/styleback.png',
                'title' => 'Style Back Collection',
                'description' => 'Discover our latest style back collection',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'carousel',
                'image_path' => 'image/bigsale.jpg',
                'title' => 'Big Sale',
                'description' => 'Get amazing discounts on selected items',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'carousel',
                'image_path' => 'image/casualfit.jpg',
                'title' => 'Casual Fit',
                'description' => 'Perfect for everyday wear',
                'order' => 3,
                'is_active' => true,
            ],
            // Banner Image
            [
                'type' => 'banner',
                'image_path' => 'image/banner.png',
                'title' => 'Most Culture Banner',
                'description' => 'Explore our cultural collection',
                'order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($images as $image) {
            BerandaImage::create($image);
        }
    }
}
