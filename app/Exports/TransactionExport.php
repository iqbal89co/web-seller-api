<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class TransactionExport implements FromCollection, WithTitle, WithHeadings, WithColumnWidths
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            '##',
            'Nomor Transaksi',
            'Tanggal Transaksi',
            'Customer',
            'Nama Barang',
            'Harga Jual',
            'QTY',
            'Total Harga',
        ];
    }

    public function title(): string
    {
        return 'Daftar Barang';
    }

    public function collection(): Collection
    {
        $transactions = Transaction::with('customer', 'transaction_items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [];
        $totalAllHargaJual = 0;
        $totalAllQty = 0;
        $totalAllJumlah = 0;

        $i = 0;
        foreach ($transactions as $transaction) {
            $i++;
            $j = 0;
            $totalPrice = 0;

            foreach ($transaction->transaction_items as $item) {
                $j++;
                $total_per_barang = $item->qty * $item->product->selling_price;
                $totalPrice += $total_per_barang;

                $totalAllHargaJual += $item->product->selling_price;
                $totalAllQty += $item->qty;
                $totalAllJumlah += $total_per_barang;

                $data[] = [
                    'number' => $i,
                    'number2' => $j,
                    'transaction_number' => $transaction->transaction_number,
                    'transaction_date' => $transaction->transaction_date,
                    'customer_name' => $transaction->customer->name ?? '',
                    'item_name' => $item->product->name ?? '',
                    'selling_price' => number_format($item->product->selling_price, 2),
                    'qty' => $item->qty,
                    'jumlah' => number_format($total_per_barang, 2),
                ];
            }
        }

        $totals = [
            'number' => '',
            'number2' => '',
            'transaction_number' => 'Total',
            'transaction_date' => '',
            'customer_name' => '',
            'item_name' => '',
            'selling_price' => number_format($totalAllHargaJual, 2),
            'qty' => $totalAllQty,
            'jumlah' => number_format($totalAllJumlah, 2),
        ];

        return collect(array_merge([$totals], $data));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 5,
            'C' => 20,
            'D' => 15,
            'E' => 20,
            'F' => 30,
            'G' => 15,
            'H' => 10,
            'I' => 20,
            'J' => 20,
        ];
    }
}
