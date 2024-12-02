<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $categories = [
            [
                'name' => 'Makanan Pokok',
                'slug' => 'makanan-pokok'
            ],
            [
                'name' => 'Makanan Instan & Siap Saji',
                'slug' => 'makanan-instan-siap-saji'
            ],
            [
                'name' => 'Makanan Ringan',
                'slug' => 'makanan-ringan'
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman'
            ],
            [
                'name' => 'Bumbu dan Rempah',
                'slug' => 'bumbu-dan-rempah'
            ],
            [
                'name' => 'Produk Daging dan Ikan',
                'slug' => 'produk-daging-dan-ikan'
            ],
            [
                'name' => 'Produk Susu dan Olahan',
                'slug' => 'produk-susu-dan-olahan'
            ],
            [
                'name' => 'Sayur dan Buah Segar',
                'slug' => 'sayur-dan-buah-segar'
            ],
            [
                'name' => 'Roti dan Kue',
                'slug' => 'roti-dan-kue'
            ],
            [
                'name' => 'Produk Beku',
                'slug' => 'produk-beku'
            ],
            [
                'name' => 'Kebutuhan Rumah Tangga',
                'slug' => 'kebutuhan-rumah-tangga'
            ],
            [
                'name' => 'Perawatan Tubuh',
                'slug' => 'perawatan-tubuh'
            ],
            [
                'name' => 'Produk Bayi',
                'slug' => 'produk-bayi'
            ],
            [
                'name' => 'Alat Tulis dan Perlengkapan Kantor',
                'slug' => 'alat-tulis-dan-perlengkapan-kantor'
            ],
            [
                'name' => 'Produk Elektronik Kecil',
                'slug' => 'produk-elektronik-kecil'
            ],
            [
                'name' => 'Produk Kesehatan',
                'slug' => 'produk-kesehatan'
            ],
            [
                'name' => 'Makanan Hewan',
                'slug' => 'makanan-hewan'
            ]
        ];
        Category::insert($categories);
    }
}
