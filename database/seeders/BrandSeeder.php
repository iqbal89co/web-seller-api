<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('brands')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $brands = [
            [
                'name' => 'Indomie',
                'slug' => 'indomie'
            ],
            [
                'name' => 'Mie Sedaap',
                'slug' => 'mie-sedaap'
            ],
            [
                'name' => 'ABC',
                'slug' => 'abc'
            ],
            [
                'name' => 'Kecap Bango',
                'slug' => 'kecap-bango'
            ],
            [
                'name' => 'Frisian Flag',
                'slug' => 'frisian-flag'
            ],
            [
                'name' => 'Sari Roti',
                'slug' => 'sari-roti'
            ],
            [
                'name' => 'Yakult',
                'slug' => 'yakult'
            ],
            [
                'name' => 'Aqua',
                'slug' => 'aqua'
            ],
            [
                'name' => 'Bear Brand',
                'slug' => 'bear-brand'
            ],
            [
                'name' => 'So Klin',
                'slug' => 'so-klin'
            ],
            [
                'name' => 'Rinso',
                'slug' => 'rinso'
            ],
            [
                'name' => 'Lifebuoy',
                'slug' => 'lifebuoy'
            ],
            [
                'name' => 'Sunlight',
                'slug' => 'sunlight'
            ],
            [
                'name' => 'Good Day',
                'slug' => 'good-day'
            ],
            [
                'name' => 'Pocari Sweat',
                'slug' => 'pocari-sweat'
            ],
            [
                'name' => 'Kapal Api',
                'slug' => 'kapal-api'
            ],
            [
                'name' => 'Top Coffee',
                'slug' => 'top-coffee'
            ],
            [
                'name' => 'Ultra Milk',
                'slug' => 'ultra-milk'
            ],
            [
                'name' => 'Tolak Angin',
                'slug' => 'tolak-angin'
            ],
            [
                'name' => 'Nu Green Tea',
                'slug' => 'nu-green-tea'
            ]
        ];
        Brand::insert($brands);
    }
}
