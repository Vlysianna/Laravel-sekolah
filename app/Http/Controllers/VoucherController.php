<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Auth::user()->vouchers;
        return view('vouchers.index', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers',
            'discount' => 'required|integer|min:1',
            'expired_at' => 'required|date',
        ]);

        Voucher::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'expired_at' => $request->expired_at,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Voucher created!');
    }

    public function redeem(Request $request)
    {
        $request->validate(['code' => 'required']);
        $voucher = Voucher::where('code', $request->code)
            ->where('user_id', Auth::id())
            ->where('is_used', false)
            ->where('expired_at', '>=', now())
            ->first();

        if (!$voucher) {
            return back()->withErrors(['code' => 'Voucher tidak valid atau sudah digunakan/expired']);
        }

        $voucher->update(['is_used' => true]);
        return back()->with('success', 'Voucher berhasil digunakan! Diskon: ' . $voucher->discount . '%');
    }
}