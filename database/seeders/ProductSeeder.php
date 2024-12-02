<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $products = [
            [
                'code' => 'B0001',
                'name' => 'Indomie Goreng Original',
                'unit' => 'pcs',
                'barcode' => '123456789012',
                'category_id' => 'makanan-instan-siap-saji',
                'brand_id' => 'indomie',
                'selling_price' => 3500
            ],
            [
                'code' => 'B0002',
                'name' => 'Mie Sedaap Ayam Bawang',
                'unit' => 'pcs',
                'barcode' => '123456789013',
                'category_id' => 'makanan-instan-siap-saji',
                'brand_id' => 'mie-sedaap',
                'selling_price' => 3000
            ],
            [
                'code' => 'B0003',
                'name' => 'Kecap Manis Bango Botol 135ml',
                'unit' => 'pcs',
                'barcode' => '123456789014',
                'category_id' => 'bumbu-dan-rempah',
                'brand_id' => 'kecap-bango',
                'selling_price' => 14000
            ],
            [
                'code' => 'B0004',
                'name' => 'Aqua Galon 19L',
                'unit' => 'galon',
                'barcode' => '123456789015',
                'category_id' => 'minuman',
                'brand_id' => 'aqua',
                'selling_price' => 21000
            ],
            [
                'code' => 'B0005',
                'name' => 'Good Day Cappuccino Sachet',
                'unit' => 'pcs',
                'barcode' => '123456789016',
                'category_id' => 'minuman',
                'brand_id' => 'good-day',
                'selling_price' => 1500
            ],
            [
                'code' => 'B0006',
                'name' => 'Roti Tawar Sari Roti 400g',
                'unit' => 'pcs',
                'barcode' => '123456789017',
                'category_id' => 'roti-dan-kue',
                'brand_id' => 'sari-roti',
                'selling_price' => 14000
            ],
            [
                'code' => 'B0007',
                'name' => 'Sabun Lifebuoy Total 10',
                'unit' => 'pcs',
                'barcode' => '123456789018',
                'category_id' => 'perawatan-tubuh',
                'brand_id' => 'lifebuoy',
                'selling_price' => 3500
            ],
            [
                'code' => 'B0008',
                'name' => 'Kopi Kapal Api Sachet',
                'unit' => 'pcs',
                'barcode' => '123456789019',
                'category_id' => 'minuman',
                'brand_id' => 'kapal-api',
                'selling_price' => 2000
            ],
            [
                'code' => 'B0009',
                'name' => 'Yakult Fermented Milk 65ml',
                'unit' => 'pcs',
                'barcode' => '123456789020',
                'category_id' => 'minuman',
                'brand_id' => 'yakult',
                'selling_price' => 2500
            ],
            [
                'code' => 'B0010',
                'name' => 'Sunlight Lemon 800ml',
                'unit' => 'pcs',
                'barcode' => '123456789021',
                'category_id' => 'pembersih-rumah-tangga',
                'brand_id' => 'sunlight',
                'selling_price' => 15000
            ],
            [
                'code' => 'B0011',
                'name' => 'Ultra Milk Cokelat 1L',
                'unit' => 'pcs',
                'barcode' => '123456789022',
                'category_id' => 'minuman',
                'brand_id' => 'ultra-milk',
                'selling_price' => 14000
            ],
            [
                'code' => 'B0012',
                'name' => 'Rinso Anti Noda 900g',
                'unit' => 'pcs',
                'barcode' => '123456789023',
                'category_id' => 'pembersih-rumah-tangga',
                'brand_id' => 'rinso',
                'selling_price' => 20000
            ],
            [
                'code' => 'B0013',
                'name' => 'Frisian Flag Kental Manis 385g',
                'unit' => 'pcs',
                'barcode' => '123456789024',
                'category_id' => 'susu-dan-olahan',
                'brand_id' => 'frisian-flag',
                'selling_price' => 12000
            ],
            [
                'code' => 'B0014',
                'name' => 'Tolak Angin Cair 15ml',
                'unit' => 'pcs',
                'barcode' => '123456789025',
                'category_id' => 'kesehatan',
                'brand_id' => 'tolak-angin',
                'selling_price' => 5500
            ],
            [
                'code' => 'B0015',
                'name' => 'Good Day Vanilla Latte 3in1 Sachet',
                'unit' => 'pcs',
                'barcode' => '123456789026',
                'category_id' => 'minuman',
                'brand_id' => 'good-day',
                'selling_price' => 2000
            ],
            [
                'code' => 'B0016',
                'name' => 'Bear Brand Sterilized Milk 189ml',
                'unit' => 'pcs',
                'barcode' => '123456789027',
                'category_id' => 'susu-dan-olahan',
                'brand_id' => 'bear-brand',
                'selling_price' => 9500
            ]
        ];

        foreach ($products as $product) {
            $category = Category::where('slug', $product['category_id'])->first();
            $brand = Brand::where('slug', $product['brand_id'])->first();

            if ($category && $brand) {
                $product['category_id'] = $category->id;
                $product['brand_id'] = $brand->id;
                $product['writer_id'] = 1;
                Product::create($product);
            }
        }
    }
}
