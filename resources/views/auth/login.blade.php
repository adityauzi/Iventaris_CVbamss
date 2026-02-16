<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin ISP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
            <div class="logo"><i class="fas fa-satellite-dish"></i><h1>CV BAMS</h1></div>
            <p class="tagline">Dashboard Management ISP</p>
        </div>

        <div class="login-form-wrapper">
            <div class="login-form-container">
                @if($errors->any())
                    <div style="background: #e74c3c; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if(session('success'))
                    <div style="background: #2ecc71; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="login-form" action="{{ route('login.post') }}" method="POST" class="form-active">
                    @csrf
                    <div class="form-header">
                        <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>