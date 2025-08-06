\<?php
$products = [
    ['name' => 'Product 1', 'price' => 100000],
    ['name' => 'Product 2', 'price' => 200000],
    ['name' => 'Product 3', 'price' => 500000],
];
?>
@extends('master')
@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-primary shadow-sm">
                <h4 class="mb-1">Selamat Datang <b>{{ Auth::user()->name }}</b>!</h4>
                <span>Anda Login sebagai <b>{{ Auth::user()->role }}</b>.</span>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-info shadow-sm mb-0">
                @if (Auth::user()->points >= 100 && Auth::user()->points < 150)
                    <span>Poin Anda: <b>{{ Auth::user()->points }}</b>.<br>Selamat, Anda mendapat diskon sebesar {{ Auth::user()->discount * 100 }}%</span>
                @elseif (Auth::user()->points >= 150)
                    <span>Poin Anda: <b>{{ Auth::user()->points }}</b>.<br>Selamat, Anda mendapat diskon sebesar {{ Auth::user()->discount * 100 }}%</span>
                @else
                    <span>Poin Anda: <b>{{ Auth::user()->points }}</b>.</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <h4 class="mb-3 font-weight-bold">Daftar Produk</h4>
        </div>
    </div>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">{{ $product['name'] }}</h5>
                    <div class="mb-2">
                        @if(Auth::user()->discount > 0)
                            <span class="text-muted" style="text-decoration: line-through;">
                                Rp {{ number_format($product['price'], 0, ',', '.') }}
                            </span>
                            <span class="text-danger ml-2">
                                -{{ Auth::user()->discount * 100 }}%
                            </span>
                        @endif
                    </div>
                    <h4 class="text-primary font-weight-bold">
                        Rp {{ number_format($product['price'] * (1 - Auth::user()->discount), 0, ',', '.') }}
                    </h4>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('buy', $product['name']) }}" class="btn btn-outline-primary btn-block">
                        Beli Sekarang
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<style>
    .card {
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    .card-title {
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>
@endsection