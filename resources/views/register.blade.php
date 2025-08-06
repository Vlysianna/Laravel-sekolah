<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Database</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .brand {
            font-weight: bold;
            font-size: 2rem;
            color: #2575fc;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card p-4">
                <div class="text-center brand">Register Aplikasi</div>
                <hr>
                <!-- Tampilkan error validasi -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <b>Oops!</b> {{ session('error') }}
                        @if(str_contains(session('error'), 'detik'))
                            <div id="countdown" class="mt-2"></div>
                            <script>
                                const msg = "{{ session('error') }}";
                                const time = parseInt(msg.match(/\d+/)[0]);
                                let seconds = time;
                                const countdown = setInterval(() => {
                                    document.getElementById('countdown').innerHTML = `Tersisa: ${seconds} detik`;
                                    seconds--;
                                    if (seconds < 0) {
                                        clearInterval(countdown);
                                        location.reload();
                                    }
                                }, 1000);
                            </script>
                        @endif
                    </div>
                @endif
                @if(session('register_data'))
                    <div class="alert alert-success">
                        <b>{{ session('success') }}</b>
                        <ul class="mb-0">
                            <li><b>Nama:</b> {{ session('register_data.name') }}</li>
                            <li><b>Email:</b> {{ session('register_data.email') }}</li>
                            <li><b>Nomor HandPhone:</b> {{ session('register_data.phone') }}</li>
                            <li><b>Alamat:</b> {{ session('register_data.address') }}</li>
                        </ul>
                    </div>
                @endif
                <form action="{{ route('create') }}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nomor HandPhone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Nomor HandPhone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" name="address" class="form-control" placeholder="Alamat" value="{{ old('address') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                    <hr>
                    <p class="text-center mt-3">
                        <a href="{{ route('login') }}">Sudah punya akun? Login sekarang!</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>