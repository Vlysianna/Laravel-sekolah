 
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login - Database</title>
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
            #timerDisplay {
                margin-top: 10px;
                font-weight: bold;
                color: #d9534f;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="text-center brand">Login Aplikasi</div>
                    <hr>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <b>Oops!</b> {{session('error')}}
                        </div>
                    @endif
                    <form action="{{ route('actionLogin') }}" method="post" id="loginForm">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" id="loginButton">Log In</button>
                        <div id="timerDisplay" class="text-center" style="display: none;">
                            Silahkan coba lagi dalam <span id="timeLeft">30</span> detik
                        </div>
                        <hr>
                        <p class="text-center">Belum punya akun? <a href="{{ route('register') }}">Registrasi</a> sekarang!</p>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                @if(session('timeout'))
                    startTimer({{ session('timeout') }});
                @endif
            });

            function startTimer(duration) {
                var timeLeft = duration;
                var loginButton = $('#loginButton');
                var timerDisplay = $('#timerDisplay');
                var timeLeftSpan = $('#timeLeft');
                var form = $('#loginForm');
                
                // Disable form and show timer
                loginButton.prop('disabled', true);
                form.find('input').prop('disabled', true);
                timerDisplay.show();
                
                var countdown = setInterval(function() {
                    timeLeft--;
                    timeLeftSpan.text(timeLeft);
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        loginButton.prop('disabled', false);
                        form.find('input').prop('disabled', false);
                        timerDisplay.hide();
                    }
                }, 1000);
            }
        </script>
    </body>
</html>
        
    