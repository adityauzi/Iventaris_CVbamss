<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // PENTING: Untuk cek login & role
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar pelanggan dan statistik di kartu UI
     */
    public function index()
    {
        $customers = Customer::orderBy('customer_id_string', 'asc')->get();        
        // Menghitung statistik untuk kartu di UI sesuai CSS dashboard kamu
        $total = $customers->count();
        $aktif = $customers->where('status', 'aktif')->count();
        $nonaktif = $customers->where('status', 'nonaktif')->count();

        $today = Carbon::today();
        $dueCustomers = Customer::where('status', 'aktif')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', $today)
            ->orderBy('expiry_date', 'asc')
            ->get();
        $dueCustomersCount = $dueCustomers->count();

        return view('viewWeb.customer', compact('customers', 'total', 'aktif', 'nonaktif', 'dueCustomers', 'dueCustomersCount'));
    }

    /**
     * Menyimpan data pelanggan baru (Hanya Super Admin)
     */
    public function store(Request $request)
    {
        // 1. KEAMANAN: Cek apakah user adalah super_admin
        if (Auth::user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Akses ditolak! Hanya Super Admin yang boleh menambah data.');
        }

        // 2. VALIDASI: Pastikan data wajib diisi agar tidak error database
        $request->validate([
            'customer_id_string' => 'required|unique:customers,customer_id_string',
            'full_name' => 'required|string|max:255',
            'package' => 'required',
            'installation_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        // Default jatuh tempo: tanggal 15 bulan depan dari tanggal pemasangan (model sebelumnya)
        $defaultExpiryDate = Carbon::parse($request->installation_date)
            ->addMonthNoOverflow()
            ->day(15)
            ->format('Y-m-d');

        $status = $request->status ?: 'aktif';

        // Jika nonaktif, jatuh tempo harus mati/hilang
        $expiryDate = $status === 'nonaktif'
            ? null
            : ($request->expiry_date ?: $defaultExpiryDate);

        // 3. SIMPAN: Menggunakan pemetaan manual agar lebih aman dari error null
        Customer::create([
            'customer_id_string' => $request->customer_id_string,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'package' => $request->package,
            'installation_date' => $request->installation_date,
            'expiry_date' => $expiryDate,
            'status' => $status,
            'keterangan' => $request->keterangan,
            
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan Berhasil Ditambahkan!');
    }

    /**
     * Memperbarui data pelanggan (Hanya Super Admin)
     */
   public function update(Request $request, $id)
{
    if (Auth::user()->role !== 'super_admin') {
        return redirect()->back()->with('error', 'Akses ditolak!');
    }

    $customer = Customer::findOrFail($id);

    $request->validate([
        'full_name' => 'required',
        'package'   => 'required',
        'keterangan'=> 'nullable|string', // <--- Tambahkan Ini
        'expiry_date'=> 'nullable|date',
        'status' => 'required|in:aktif,nonaktif',
    ]);

    $payload = $request->all();

    // Normalisasi agar lintas environment selalu terbaca sebagai format tanggal DB
    if (!empty($payload['expiry_date'])) {
        $payload['expiry_date'] = Carbon::parse($payload['expiry_date'])->format('Y-m-d');
    }

    // Aturan bisnis: pelanggan nonaktif tidak boleh punya jatuh tempo.
    // Jika aktif kembali dari nonaktif, jatuh tempo otomatis ON ke tanggal 15 bulan depan.
    if (($payload['status'] ?? $customer->status) === 'nonaktif') {
        $payload['expiry_date'] = null;
    } elseif ($customer->status === 'nonaktif' && ($payload['status'] ?? null) === 'aktif') {
        $payload['expiry_date'] = now()->addMonthNoOverflow()->day(15)->format('Y-m-d');
    }

    $customer->update($payload); // Ini otomatis mengambil 'keterangan' dari form

    return redirect()->route('pelanggan.index', ['tab' => 'kelola-pelanggan'])->with('success', 'Data Berhasil Diperbarui!');
}

    /**
     * Menghapus data pelanggan (Hanya Super Admin)
     */
    public function destroy($id)
    {
        // KEAMANAN: Cek role
        if (Auth::user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Anda tidak punya izin menghapus data!');
        }

        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('pelanggan.index', ['tab' => 'kelola-pelanggan'])->with('success', 'Data pelanggan berhasil dihapus!');
    }
    public function import(Request $request) 
{
    $request->validate(['file_customer' => 'required|mimes:xlsx,xls,csv']);
    
    // Proses Import
    Excel::import(new CustomerImport, $request->file('file_customer'));
    
    return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil dipindahkan!');
}
}