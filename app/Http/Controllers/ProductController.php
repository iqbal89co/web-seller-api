<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{

    public function __invoke(Request $request)
    {
        $products = Product::with('category', 'brand', 'writer')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'message' => 'Data successfully retrieved',
            'data' => $products
        ]);
    }

    public function detail(Request $request, $id)
    {
        $product = Product::with('category', 'brand', 'writer')->find($id);
        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Data successfully retrieved',
            'data' => $product
        ]);
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'string|unique:products,code|max:255',
            'name' => 'required|string|max:255',
            'unit' => 'string|max:255',
            'barcode' => 'string|max:255',
            'category_id' => 'integer|exists:categories,id',
            'brand_id' => 'integer|exists:brands,id',
            'selling_price' => 'required|integer',
        ]);

        $data = $validatedData + ['writer_id' => auth()->user()->id];
        $newProduct = Product::create($data);
        $product = Product::with('category', 'brand', 'writer')->find($newProduct->id);
        return response()->json([
            'message' => 'Product successfully added',
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'string|unique:products,code,' . $id . '|max:255',
            'name' => 'required|string|max:255',
            'unit' => 'string|max:255',
            'barcode' => 'string|max:255',
            'category_id' => 'integer|exists:categories,id',
            'brand_id' => 'integer|exists:brands,id',
            'selling_price' => 'required|integer',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }
        $product->code = $request->code;
        $product->name = $request->name;
        $product->unit = $request->unit;
        $product->barcode = $request->barcode;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->selling_price = $request->selling_price;
        $product->writer_id = auth()->user()->id;
        $product->save();
        $updatedProduct = Product::with('category', 'brand', 'writer')->find($product->id);
        return response()->json([
            'message' => 'Product successfully updated',
            'data' => $updatedProduct
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }
        $product->delete();
        return response()->json([
            'message' => 'Product successfully deleted',
            'data' => $product
        ]);
    }

    public function export_excel(Request $request)
    {
        $date = get_indo_date(date('Y-m-d'));
        $filename = "Daftar produk - {$date}.xlsx";
        return Excel::download(new ProductsExport, $filename);
    }
}
