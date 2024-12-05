<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function __invoke(Request $request)
    {
        $transactions = Transaction::with('transaction_items.product', 'customer')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'message' => 'data successfully retrieved',
            'data' => $transactions
        ]);
    }

    public function spend_band(Request $request)
    {
        // SELECT
        // CASE 
        //     WHEN (ti.qty * p.selling_price) BETWEEN 0 AND 100000 THEN '0 - 100,000'
        //     WHEN (ti.qty * p.selling_price) BETWEEN 100001 AND 300000 THEN '100,001 - 300,000'
        //     WHEN (ti.qty * p.selling_price) BETWEEN 300001 AND 600000 THEN '300,001 - 600,000'
        //     WHEN (ti.qty * p.selling_price) BETWEEN 600001 AND 1000000 THEN '600,001 - 1,000,000' 
        //     ELSE '> 1,000,000'
        // END AS "Spend Band",
        // COUNT(*) AS "Total Transactions"
        // FROM transactions t
        // JOIN transaction_items ti ON t.id = ti.transaction_id  
        // JOIN products p ON ti.product_id = p.id
        // GROUP BY
        // CASE
        //     WHEN (ti.qty * p.selling_price) BETWEEN 0 AND 100000 THEN '0 - 100,000'
        //     WHEN (ti.qty * p.selling_price) BETWEEN 100001 AND 300000 THEN '100,001 - 300,000'
        //     WHEN (ti.qty * p.selling_price) BETWEEN 300001 AND 600000 THEN '300,001 - 600,000'
        //     WHEN (ti.qty * p.selling_price) BETWEEN 600001 AND 1000000 THEN '600,001 - 1,000,000'
        //     ELSE '> 1,000,000'
        // END;
        $results = DB::table('transactions as t')
            ->join('transaction_items as ti', 't.id', '=', 'ti.transaction_id')
            ->join('products as p', 'ti.product_id', '=', 'p.id')
            ->select(DB::raw("
        CASE 
            WHEN (ti.qty * p.selling_price) BETWEEN 0 AND 100000 THEN '0 - 100,000'
            WHEN (ti.qty * p.selling_price) BETWEEN 100001 AND 300000 THEN '100,001 - 300,000'
            WHEN (ti.qty * p.selling_price) BETWEEN 300001 AND 600000 THEN '300,001 - 600,000'
            WHEN (ti.qty * p.selling_price) BETWEEN 600001 AND 1000000 THEN '600,001 - 1,000,000' 
            ELSE '> 1,000,000'
        END AS `Spend Band`,
        COUNT(*) AS `Total Transactions`
    "))
            ->groupBy(DB::raw("
        CASE
            WHEN (ti.qty * p.selling_price) BETWEEN 0 AND 100000 THEN '0 - 100,000'
            WHEN (ti.qty * p.selling_price) BETWEEN 100001 AND 300000 THEN '100,001 - 300,000'
            WHEN (ti.qty * p.selling_price) BETWEEN 300001 AND 600000 THEN '300,001 - 600,000'
            WHEN (ti.qty * p.selling_price) BETWEEN 600001 AND 1000000 THEN '600,001 - 1,000,000'
            ELSE '> 1,000,000'
        END
    "))
            ->get();
        return response()->json([
            'message' => 'data successfully retrieved',
            'data' => $results
        ]);
    }

    public function detail(Request $request, $id)
    {
        $transaction = Transaction::with('transaction_items.product', 'customer')->find($id);
        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found',
            ], 404);
        }
        return response()->json([
            'message' => 'data successfully retrieved',
            'data' => $transaction
        ]);
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer',
        ]);

        $transactionId = null;
        DB::transaction(function () use ($validatedData, &$transactionId, $request) {
            $date = Carbon::now()->format('ymd');
            $count = Transaction::whereDate('created_at', Carbon::today())->count() + 1;
            $sequence = str_pad($count, 4, '0', STR_PAD_LEFT);
            $transaction_number = 'TRXN' . $date . $sequence;

            $transaction = Transaction::create([
                'transaction_number' => $transaction_number,
                'transaction_date' => Carbon::now(),
                'customer_id' => $request->user()->id,
            ]);

            $transactionId = $transaction->id;

            foreach ($validatedData['items'] as $item) {
                $product = Product::find($item['product_id']);
                $transaction->transaction_items()->create([
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                ]);
            }
        });

        $transaction = Transaction::with('transaction_items.product', 'customer')->find($transactionId);
        return response()->json([
            'message' => 'Transaction successfully added',
            'data' => $transaction
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer',
        ]);

        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found',
            ], 404);
        }

        DB::transaction(function () use ($request, $transaction) {
            $transaction->transaction_items()->delete();

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $transaction->transaction_items()->create([
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                ]);
            }
        });

        $transaction = Transaction::with('transaction_items.product', 'customer')->find($id);
        return response()->json([
            'message' => 'Transaction successfully updated',
            'data' => $transaction
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found',
            ], 404);
        }
        $transaction->delete();
        return response()->json([
            'message' => 'Transaction successfully deleted',
        ]);
    }

    public function export_excel(Request $request)
    {
        $date = get_indo_date(date('Y-m-d'));
        $filename = "Daftar transaksi - {$date}.xlsx";
        return Excel::download(new TransactionExport, $filename);
    }
}
