<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CustomerImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        // 1. Lewati jika kolom NAMA kosong (Menghindari baris hantu)
        if (empty($row['nama'])) return null;

        // 2. Pembersihan Nama Pelanggan
        $fullName = preg_replace('/\s*\(.*?\)\s*/', '', $row['nama']);

        // 3. Simpan Pelanggan Baru (Jika belum ada)
        $customer = Customer::firstOrCreate(
            ['customer_id_string' => $row['no_customer'] ?? 'PLG-' . uniqid()],
            [
                'expiry_date' => !empty($row['start'])
                    ? Carbon::parse($row['start'])->addMonthNoOverflow()->day(15)->format('Y-m-d')
                    : now()->addMonthNoOverflow()->day(15)->format('Y-m-d'),
                'full_name' => trim($fullName),
                'address'   => $row['alamat'] ?? 'Semanding',
                'package'   => ((int)$row['wifi'] >= 250000) ? '25 Mbps' : '10 Mbps',
                'installation_date' => !empty($row['start']) ? Carbon::parse($row['start'])->format('Y-m-d') : date('Y-m-d'),
                'status'    => 'aktif',
                'phone'     => '0800000000'
            ]
        );

        // 4. OTOMATIS: Buat Riwayat Pembayaran untuk bulan 'START'
        if ($customer->wasRecentlyCreated || $customer->exists) {
            $amount = (int) $row['wifi'];
            $paidMonth = !empty($row['start']) ? Carbon::parse($row['start'])->month : date('n');

            Payment::create([
                'customer_id'    => $customer->id,
                'transaction_id' => 'TRX-' . strtoupper(Str::random(8)),
                'amount_paid'    => $amount,
                'payment_method' => 'cash',
                'paid_months'    => [$paidMonth], // Otomatis lunas di bulan pendaftaran
                'period_months'  => 1,
                'created_at'     => !empty($row['start']) ? Carbon::parse($row['start']) : now(),
            ]);
        }

        return $customer;
    }
}