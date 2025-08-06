@extends('master')

@section('content')
<h2>Voucher Saya</h2>
<ul>
    @foreach($vouchers as $voucher)
        <li>
            Kode: {{ $voucher->code }} | Diskon: {{ $voucher->discount }}% | 
            Expired: {{ $voucher->expired_at }} | 
            Status: {{ $voucher->is_used ? 'Sudah digunakan' : 'Belum digunakan' }}
        </li>
    @endforeach
</ul>

<form method="POST" action="{{ route('vouchers.redeem') }}">
    @csrf
    <input type="text" name="code" placeholder="Masukkan kode voucher">
    <button type="submit">Gunakan Voucher</button>
</form>
@endsection