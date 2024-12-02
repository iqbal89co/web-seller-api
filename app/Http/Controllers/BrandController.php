<?php

namespace App\Http\Controllers;

use App\Exports\BrandExport;
use App\Models\Brand;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    public function __invoke(Request $request)
    {
        $brands = Brand::orderBy('created_at', 'desc')->get();
        return response()->json([
            'message' => 'data successfully retrieved',
            'data' => $brands
        ]);
    }

    public function detail(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'error' => 'Brand not found',
            ], 404);
        }
        return response()->json([
            'message' => 'data successfully retrieved',
            'data' => $brand
        ]);
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'slug' => 'required|unique:categories,slug|string|max:255',
            'name' => 'required|unique:categories,name|string|max:255',
        ]);

        $newBrand = Brand::create($validatedData);
        return response()->json([
            'message' => 'Brand successfully added',
            'data' => $newBrand
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'slug' => 'required|unique:categories,slug,' . $id . '|string|max:255',
            'name' => 'required|unique:categories,name,' . $id . '|string|max:255',
        ]);

        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'error' => 'Brand not found',
            ], 404);
        }
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->save();
        return response()->json([
            'message' => 'Brand successfully updated',
            'data' => $brand
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'error' => 'Brand not found',
            ], 404);
        }
        $brand->delete();
        return response()->json([
            'message' => 'Brand successfully deleted',
            'data' => $brand
        ]);
    }
    public function export_excel(Request $request)
    {
        $date = get_indo_date(date('Y-m-d'));
        $filename = "Daftar Kategori - {$date}.xlsx";
        return Excel::download(new BrandExport, $filename);
    }
}
