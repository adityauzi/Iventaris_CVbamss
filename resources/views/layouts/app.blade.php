<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CV BAMS</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    @stack('scripts')
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <h1><i class="fas fa-satellite-dish"></i> CV BAMS</h1>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
    <li>
        <a href="{{ route('pelanggan.index') }}" class="{{ request()->is('pelanggan*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Data Pelanggan
        </a>
    </li>                <li> <a href="{{ route('pembayaran.index') }}" class="{{ request()->is('pembayaran*') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Pembayaran </a></li>
    <li>
        <a href="{{ route('transkrip.index') }}" class="{{ request()->is('transkrip*') ? 'active' : '' }}""><i class="fas fa-chart-bar"></i> Transkrip</a>
    </li>            </ul>

            <div class="sidebar-user-box">
                @php
                    $roleLabel = Auth::user()->role == 'super_admin' ? 'Super Admin' : 'Admin';
                    $name = Auth::user()->full_name ?? 'User';
                    $parts = preg_split('/\s+/', trim($name));
                    $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . substr($parts[1] ?? '', 0, 1));
                @endphp

                <div class="sidebar-user-avatar" aria-hidden="true">{{ $initials }}</div>
                <div class="sidebar-user-meta">
                    <h4 title="{{ $name }}">{{ $name }}</h4>
                    <span class="sidebar-role-badge {{ Auth::user()->role == 'super_admin' ? 'is-super-admin' : 'is-admin' }}">
                        {{ $roleLabel }}
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-logout-btn" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            @yield('content')
            
            <div class="footer">
                <p>© 2025 Dashboard Admin ISP. Semua hak dilindungi.</p>
                <p>Versi 2.1.0</p>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    @stack('scripts')
    <script>
    // FUNGSI: Menghilangkan notifikasi secara otomatis setelah 3 detik
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-success, [style*="background: #2ecc71"], [style*="background: #e74c3c"]');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500); // Menghapus elemen dari HTML
            }, 3000); // 3000ms = 3 detik
        });
    });
</script>
</body>
</html>