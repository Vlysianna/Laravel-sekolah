@extends('master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 mt-5">
            <h4 class="mb-3 text-center">Reset Password</h4>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('forgot.password.send') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="{{ old('email', $email ?? '') }}" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset</button>
            </form>
            @if(isset($resetLink))
                <div class="alert alert-success mt-3">
                    <b>Simulasi:</b> Klik link berikut untuk reset password:<br>
                    <a href="{{ $resetLink }}">{{ $resetLink }}</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection