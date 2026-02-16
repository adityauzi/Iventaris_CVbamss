<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - CV BAMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">
</head>
<body>

    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <h1><i class="fas fa-satellite-dish"></i> CV BAMS</h1>
            </div>
           <ul class="nav-links">
    <li>
        <a href="{{ route('dashboard') }}" class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('pelanggan.index') }}" class="{{ request()->is('pelanggan*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Data Pelanggan
        </a>
    </li>
    <li>
        <a href="{{ route('pembayaran.index') }}" class="{{ request()->is('pembayaran*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> Pembayaran
        </a>
    </li>
    <li>
        <a href="{{ route('transkrip.index') }}" class="{{ request()->is('transkrip*') ? 'active' : '' }}""><i class="fas fa-chart-bar"></i> Transkrip</a>
    </li>
    <li>
    </li>
</ul>
        </aside>

        <main class="main-content">
            <div class="header">
                <h2>Data Pelanggan</h2>
                <div class="user-info">
                    <div>
                        <h4>Administrator</h4>
                        <p style="font-size: 0.9rem; color: var(--gray);">Super Admin</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+ISP&background=3498db&color=fff&size=128" alt="Admin Avatar">
                </div>
            </div>

            <div class="tab-navigation">
                @if(Auth::user()->role == 'super_admin')
    
@else
    <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; border: 1px solid #ffeeba; margin-bottom: 20px;">
        <i class="fas fa-lock"></i> <strong>Mode Terbatas:</strong> Anda hanya dapat melihat data. Penambahan data hanya untuk Super Admin.
    </div>
@endif
                <button class="tab-btn" data-tab="tambah-pelanggan">
                    <i class="fas fa-user-plus"></i> Tambah Pelanggan Baru
                </button>
                <button class="tab-btn active" data-tab="kelola-pelanggan">
                    <i class="fas fa-list"></i> Kelola Pelanggan
                </button>
            </div>

            <div id="tambah-pelanggan" class="tab-content">
                <div class="form-header">
                    <h3><i class="fas fa-user-plus"></i> Tambah Pelanggan Baru</h3>
                    <p>Tambah data pelanggan baru ke dalam sistem ISP</p>
                </div>

                <form id="form-tambah-pelanggan" action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="user-info">
    <div>
        <h4>{{ Auth::user()->full_name }}</h4>
        <p>{{ Auth::user()->role == 'super_admin' ? 'Super Admin' : 'Admin' }}</p>
    </div>
   
</div>
@if(Auth::user()->role == 'super_admin')
    
@else
    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">
        <i class="fas fa-lock"></i> Fitur Tambah Pelanggan hanya untuk Super Admin.
    </div>
@endif
             @if(session('success'))
    <div class="alert-auto-hide" style="background: #2ecc71; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(46,204,113,0.2);">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
                    <div class="form-grid">
                        <div class="form-section">
                            <h4 class="section-title"><i class="fas fa-id-card"></i> Informasi Pelanggan</h4>
                            <div class="form-group">
                                <label for="id-pelanggan">ID Pelanggan *</label>
                                <input type="text" name="customer_id_string" id="id-pelanggan" class="form-control" placeholder="PLG-001" required>
                            </div>
                            <div class="form-group">
                                <label for="nama-pelanggan">Nama Lengkap *</label>
                                <input type="text" name="full_name" id="nama-pelanggan" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label for="no-hp">Nomor HP *</label>
                                <input type="tel" name="phone" id="no-hp" class="form-control" placeholder="081234567890" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap *</label>
                                <textarea name="address" id="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="section-title"><i class="fas fa-wifi"></i> Paket & Instalasi</h4>
                            <div class="form-group">
                                <label for="paket-internet">Paket Internet *</label>
                                <select name="package" id="paket-internet" class="form-control" required>
                                   <option value="" disabled selected>Pilih paket internet</option>
                                    <option value="Lama 10 Mbps">Paket Lama - 10 Mbps - Rp 100.000/bulan</option>
                                    <option value="Baru 10 Mbps">Paket Baru - 10 Mbps - Rp 110.000/bulan</option>
                                    <option value="Lama 15 Mbps">Paket Lama - 15 Mbps - Rp 150.000/bulan</option>
                                    <option value="Baru 15 Mbps">Paket Baru - 15 Mbps - Rp 165.000/bulan</option>
                                    <option value="Lama 25 Mbps">Paket Lama - 25 Mbps - Rp 250.000/bulan</option>
                                    <option value="Baru 25 Mbps">Paket Baru - 25 Mbps - Rp 275.000/bulan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal-pemasangan">Tanggal Pemasangan *</label>
                                <input type="date" name="installation_date" id="tanggal-pemasangan" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal-expire">Jatuh Tempo</label>
                                <input type="date" name="expiry_date" id="tanggal-expire" class="form-control">
                            </div>
                            <div class="form-group mb-3">
    <label>Keterangan / Catatan</label>
    <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pasang di ruko lantai 2"></textarea>
</div>
                            <div class="form-group">
                                <label>Status Pelanggan</label>
                                <div class="status-options">
                                    <div class="status-option">
                                        <input type="radio" id="status-aktif" name="status" value="aktif" checked>
                                        <label for="status-aktif"><span>Aktif</span></label>
                                    </div>
                                    <div class="status-option">
                                        <input type="radio" id="status-nonaktif" name="status" value="nonaktif">
                                        <label for="status-nonaktif"><span>Nonaktif</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success btn-large">Simpan Pelanggan</button>
                        <button type="reset" class="btn btn-secondary btn-large">Reset Form</button>
                    </div>
                </form>
            </div>

            <div id="kelola-pelanggan" class="tab-content active">
                <div class="list-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3><i class="fas fa-users-cog"></i> Kelola Data Pelanggan</h3>
                    <div class="header-actions">
                        <button class="btn btn-success" onclick="document.querySelector('[data-tab=tambah-pelanggan]').click()"><i class="fas fa-user-plus"></i> Tambah Pelanggan</button>
                    </div>
                </div>

<div class="filter-controls" style="display: grid; grid-template-columns: 2fr 0.5fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 20px;">
    <div class="search-box">
        <input type="text" id="search-pelanggan" class="form-control" placeholder="Cari nama, ID, atau no HP...">
    </div>
    <button class="btn btn-primary" id="btn-search" style="background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
        <i class="fas fa-search"></i>
    </button>
                    <select id="filter-status" class="form-control">
                        <option value="all">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <select id="filter-paket" class="form-control">
                        <option value="all">Semua Paket</option>
                        <option value="Lama 10 Mbps">Paket Lama - 10 Mbps</option>
                        <option value="Baru 10 Mbps">Paket Baru - 10 Mbps</option>
                        <option value="Lama 15 Mbps">Paket Lama - 15 Mbps</option>
                        <option value="Baru 15 Mbps">Paket Baru - 15 Mbps</option>
                        <option value="Lama 25 Mbps">Paket Lama - 25 Mbps</option>
                        <option value="Baru 25 Mbps">Paket Baru - 25 Mbps</option>
                    </select>

                </div>

                <div class="stats-summary" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div class="stat-summary-card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; border-bottom: 3px solid #3498db;">
                        <div class="stat-summary-value" style="font-size: 2rem; font-weight: bold;">{{ $total }}</div>
                        <div class="stat-summary-label" style="color: #95a5a6;">Total Pelanggan</div>
                    </div>
                    <div class="stat-summary-card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; border-bottom: 3px solid #2ecc71;">
                        <div class="stat-summary-value" style="font-size: 2rem; font-weight: bold;">{{ $aktif }}</div>
                        <div class="stat-summary-label" style="color: #95a5a6;">Pelanggan Aktif</div>
                    </div>
                    <div class="stat-summary-card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; border-bottom: 3px solid #e67e22;">
                        <div class="stat-summary-value" style="font-size: 2rem; font-weight: bold;">{{ $nonaktif }}</div>
                        <div class="stat-summary-label" style="color: #95a5a6;">Pelanggan Nonaktif</div>
                    </div>
                    <button type="button" id="openDueCustomersModal" class="stat-summary-card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; border: none; border-bottom: 3px solid #e74c3c; cursor: pointer;">
                        <div class="stat-summary-value" style="font-size: 2rem; font-weight: bold;">{{ $dueCustomersCount }}</div>
                        <div class="stat-summary-label" style="color: #95a5a6;">Kelompok Jatuh Tempo</div>
                    </button>
                </div>

                <div id="dueCustomersModal" style="display:none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.45); align-items: center; justify-content: center; padding: 16px;">
                    <div style="background: #fff; width: min(900px, 100%); max-height: 85vh; overflow: auto; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                        <div style="display:flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #eee;">
                            <h3 style="margin: 0;"><i class="fas fa-users"></i> Kelompok Pelanggan Jatuh Tempo</h3>
                            <button type="button" id="closeDueCustomersModal" style="border:none; background:transparent; font-size: 1.8rem; cursor:pointer; color:#666;">&times;</button>
                        </div>
                        <div style="padding: 16px 20px 20px;">
                            @if($dueCustomersCount > 0)
                                <table style="width:100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th style="text-align:left; padding:10px 8px; border-bottom:1px solid #eee;">No</th>
                                            <th style="text-align:left; padding:10px 8px; border-bottom:1px solid #eee;">ID Pelanggan</th>
                                            <th style="text-align:left; padding:10px 8px; border-bottom:1px solid #eee;">Nama</th>
                                            <th style="text-align:left; padding:10px 8px; border-bottom:1px solid #eee;">Paket</th>
                                            <th style="text-align:left; padding:10px 8px; border-bottom:1px solid #eee;">Jatuh Tempo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dueCustomers as $i => $customer)
                                            <tr>
                                                <td style="padding:10px 8px; border-bottom:1px solid #f2f2f2;">{{ $i + 1 }}</td>
                                                <td style="padding:10px 8px; border-bottom:1px solid #f2f2f2;">{{ $customer->customer_id_string }}</td>
                                                <td style="padding:10px 8px; border-bottom:1px solid #f2f2f2;">{{ $customer->full_name }}</td>
                                                <td style="padding:10px 8px; border-bottom:1px solid #f2f2f2;">{{ $customer->package }}</td>
                                                <td style="padding:10px 8px; border-bottom:1px solid #f2f2f2;">{{ \Carbon\Carbon::parse($customer->expiry_date)->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p style="margin:0; color:#7f8c8d;">Tidak ada pelanggan yang jatuh tempo saat ini.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="table-container" style="background: white; border-radius: 10px; padding: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <table class="pelanggan-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; background: #f8f9fa;">
                                <th style="padding: 15px;">No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Paket</th>
                                <th>Tanggal Pasang</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                            
                        </thead>
                        <tbody id="pelanggan-data">
                            @foreach($customers as $no => $item)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 15px;">{{ $no + 1 }}</td>
                                <td style="font-weight: bold;">{{ $item->customer_id_string }}</td>
                                <td>{{ $item->full_name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ Str::limit($item->address, 15) }}</td>
                                <td><span style="background: #e1f5fe; color: #0288d1; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $item->package }}</span></td>
                                <td>{{ $item->installation_date }}</td>
                                <td>{{ $item->expiry_date ?? '-' }}</td>
                                <td><span class="status-badge {{ $item->status == 'aktif' ? 'status-active' : 'status-expired' }}">{{ ucfirst($item->status) }}</span></td>
                                <td>{{ $item->keterangan ?? '-' }}</td> <td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <button class="btn-icon btn-detail" style="background: #3498db; color: white; border: none; padding: 5px 8px; border-radius: 4px; cursor: pointer;" 
                                            data-name="{{ $item->full_name }}" data-id="{{ $item->customer_id_string }}" data-phone="{{ $item->phone }}" data-address="{{ $item->address }}" data-package="{{ $item->package }}" data-status="{{ $item->status }}" data-install="{{ $item->installation_date }}" data-expire="{{ $item->expiry_date }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon btn-edit" 
    data-dbid="{{ $item->id }}" 
    data-name="{{ $item->full_name }}" 
    data-phone="{{ $item->phone }}" 
    data-status="{{ $item->status }}" 
    data-package="{{ $item->package }}"
    data-keterangan="{{ $item->keterangan }}"  {{-- <--- TAMBAHKAN INI --}}
    style="background: #f39c12; color: white; border: none; padding: 5px 8px; border-radius: 4px; cursor: pointer; display:inline-flex; align-items:center; justify-content:center; min-width: 32px; min-height: 30px;">
    <i class="fas fa-edit"></i>
</button>
                                     @php
    $phone = preg_replace('/^0/', '62', $item->phone);

    $message = "Halo *{$item->full_name}*,\n\n"
        . "Kami dari *CV BAMS* ingin mengingatkan bahwa layanan internet paket "
        . "*{$item->package}* Anda akan jatuh tempo pada tanggal "
        . "*{$item->expiry_date}*.\n\n"
        . "Mohon segera melakukan pembayaran untuk menghindari isolir layanan.\n\n"
        . " Metode Pembayaran:\n"
        . "- BRI\n616801005179509\n"
        . "- Mandiri\n1710006839313\n"
        . "- BNI\n0209467638\n"
        . "- BCA\n0901329604\n"
        . "- Bank Jatim\n1652021740\n"
        . "(Transfer ke rekening resmi atas nama *PURWATI*)\n\n"
        . " Setelah melakukan pembayaran, mohon kirimkan *bukti transfer* "
        . "melalui WhatsApp ini agar dapat segera kami proses.\n\n"
        . "Terima kasih atas kerja samanya.";

    $waUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
@endphp

<a href="{{ $waUrl }}"
   target="_blank"
   class="btn-icon"
   style="background:#25d366;color:white;border:none;padding:5px 8px;
          border-radius:4px;text-decoration:none;
          display:inline-flex;align-items:center;justify-content:center;">
    <i class="fab fa-whatsapp" title="Kirim Tagihan WA"></i>
</a>


                                     
                                        <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 5px 8px; border-radius: 4px; cursor: pointer;"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="footer">
                <p>© 2023 Dashboard Admin ISP. Semua hak dilindungi.</p>
            </div>
        </main>
    </div>

    <div id="modal-detail-pelanggan" class="modal" style="display:none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
        <div class="modal-content" style="background: white; padding: 30px; border-radius: 12px; width: 450px;">
            <h3><i class="fas fa-info-circle"></i> Detail Pelanggan</h3>
            <div id="detail-content" style="line-height: 2; margin-top: 15px;"></div>
            <button class="btn btn-secondary" style="margin-top: 20px; width: 100%;" onclick="closeModal('modal-detail-pelanggan')">Tutup</button>
        </div>
    </div>

    <div id="modal-edit-pelanggan" class="modal">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Edit Data Pelanggan</h3>
                <button class="modal-close" onclick="closeModal('modal-edit-pelanggan')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-edit-pelanggan" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" id="edit-nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nomor HP</label>
                        <input type="tel" name="phone" id="edit-phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Pindah Paket Internet</label>
                        <select name="package" id="edit-paket" class="form-control">
                            <option value="Lama 10 Mbps">Paket Lama - 10 Mbps - Rp 100.000</option>
                            <option value="Baru 10 Mbps">Paket Baru - 10 Mbps - Rp 110.000</option>
                            <option value="Lama 15 Mbps">Paket Lama - 15 Mbps - Rp 150.000</option>
                            <option value="Baru 15 Mbps">Paket Baru - 15 Mbps - Rp 165.000</option>
                            <option value="Lama 25 Mbps">Paket Lama - 25 Mbps - Rp 250.000</option>
                            <option value="Baru 25 Mbps">Paket Baru - 25 Mbps - Rp 275.000</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="edit-status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
    <label>Keterangan Detail</label>
    <textarea name="keterangan" id="edit-keterangan" class="form-control" rows="3"></textarea>
</div>
                    <button type="submit" class="btn btn-success" style="width: 100%; padding: 12px;">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-pelanggan');
    const searchBtn = document.getElementById('btn-search');
    const filterStatus = document.getElementById('filter-status');
    const filterPaket = document.getElementById('filter-paket');
    const tableBody = document.getElementById('pelanggan-data');
    const rows = tableBody.getElementsByTagName('tr');

    function filterData() {
        const searchFilter = searchInput.value.toLowerCase();
        const statusFilter = filterStatus.value;
        const paketFilter = filterPaket.value;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            // Kolom: 0=No, 1=ID, 2=Nama, 3=No HP, 4=Alamat, 5=Paket, 6=Tanggal Pasang, 7=Jatuh Tempo, 8=Status, 9=Keterangan
            const idCol = row.getElementsByTagName('td')[1];
            const nameCol = row.getElementsByTagName('td')[2];
            const phoneCol = row.getElementsByTagName('td')[3];
            const paketCol = row.getElementsByTagName('td')[5];
            const statusCol = row.getElementsByTagName('td')[8];

            if (idCol && nameCol && phoneCol && paketCol && statusCol) {
                const idText = (idCol.textContent || idCol.innerText).toLowerCase();
                const nameText = (nameCol.textContent || nameCol.innerText).toLowerCase();
                const phoneText = (phoneCol.textContent || phoneCol.innerText).toLowerCase();
                const paketText = (paketCol.textContent || paketCol.innerText).toLowerCase();
                const statusText = (statusCol.textContent || statusCol.innerText).toLowerCase();

                // Cek pencarian teks (ID, Nama, No HP)
                const matchesSearch = searchFilter === '' ||
                    idText.indexOf(searchFilter) > -1 ||
                    nameText.indexOf(searchFilter) > -1 ||
                    phoneText.indexOf(searchFilter) > -1;

                // Cek filter status
                const matchesStatus = statusFilter === 'all' ||
                    (statusFilter === 'aktif' && statusText.includes('aktif')) ||
                    (statusFilter === 'nonaktif' && statusText.includes('nonaktif'));

                // Cek filter paket
                const matchesPaket = paketFilter === 'all' ||
                    paketText.indexOf(paketFilter.toLowerCase()) > -1;

                if (matchesSearch && matchesStatus && matchesPaket) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }
    }

    // Jalankan fungsi saat input pencarian berubah (real-time)
    searchInput.addEventListener('input', filterData);

    // Jalankan fungsi saat tombol diklik
    searchBtn.addEventListener('click', filterData);

    // Jalankan fungsi saat filter status berubah
    filterStatus.addEventListener('change', filterData);

    // Jalankan fungsi saat filter paket berubah
    filterPaket.addEventListener('change', filterData);

    // Jalankan fungsi saat user tekan "Enter" di kotak pencarian
    searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            filterData();
        }
    });
});
</script>

    <script src="{{ asset('js/pelanggan.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            const urlParams = new URLSearchParams(window.location.search);
            const tabFromUrl = urlParams.get('tab');
            const savedTab = localStorage.getItem('activePelangganTab');
            const defaultTab = tabFromUrl || savedTab || 'kelola-pelanggan';

            function activateTab(tabId) {
                tabBtns.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                const targetBtn = document.querySelector(`.tab-btn[data-tab="${tabId}"]`);
                const targetContent = document.getElementById(tabId);

                if (targetBtn && targetContent) {
                    targetBtn.classList.add('active');
                    targetContent.classList.add('active');
                }
            }

            activateTab(defaultTab);

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    localStorage.setItem('activePelangganTab', this.getAttribute('data-tab'));
                });
            });
        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dueModal = document.getElementById('dueCustomersModal');
    const openDueBtn = document.getElementById('openDueCustomersModal');
    const closeDueBtn = document.getElementById('closeDueCustomersModal');

    if (openDueBtn && dueModal) {
        openDueBtn.addEventListener('click', function() {
            dueModal.style.display = 'flex';
        });
    }

    if (closeDueBtn && dueModal) {
        closeDueBtn.addEventListener('click', function() {
            dueModal.style.display = 'none';
        });
    }

    if (dueModal) {
        dueModal.addEventListener('click', function(e) {
            if (e.target === dueModal) {
                dueModal.style.display = 'none';
            }
        });
    }
});
</script>
</body>
</html>