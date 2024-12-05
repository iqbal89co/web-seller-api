<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductsExport implements FromCollection, WithTitle, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',
            'Kode Produk',
            'Nama Produk',
            'Satuan',
            'Barcode',
            'Kategori',
            'Brand',
            'Harga Jual',
        ];
    }
    public function title(): string
    {
        return 'Daftar Barang';
    }
    public function collection()
    {
        $products = Product::with('category', 'brand')->orderBy('created_at', 'desc')->get();
        return $products->map(function ($x, $i) {
            return [
                'number' => $i + 1,
                'code' => $x->code,
                'name' => $x->name,
                'unit' => $x->unit,
                'barcode' => $x->barcode,
                'category' => $x->category->name,
                'brand' => $x->brand->name,
                'selling_price' => $x->selling_price,
            ];
        });
    }
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 40,
            'D' => 15,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
        ];
    }
}
