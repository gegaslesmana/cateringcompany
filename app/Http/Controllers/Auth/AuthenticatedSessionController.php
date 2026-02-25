<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Tangani permintaan autentikasi login.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    // 1. Ambil data user berdasarkan email (username)
    $userCheck = \App\Models\User::where('email', $request->email)->first();

    // 2. Jika email tidak ditemukan
    if (!$userCheck) {
        return back()->with('error_type', 'username_wrong')
                     ->withInput($request->only('email'));
    }

    // 3. Jika email ada, coba verifikasi password
    // Kita gunakan Auth::attempt secara manual untuk menangkap kegagalan password
    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        return back()->with('error_type', 'password_wrong')
                     ->withInput($request->only('email'));
    }

    // Jika berhasil sampai sini, berarti login sukses
    $request->session()->regenerate();

    $user = Auth::user();

    // Redirect sesuai role
    return match($user->role) {
        'operator' => redirect()->route('operator.orders.index'),
        'hrd'      => redirect()->route('hrd.orders.index'),
        'security' => redirect()->route('security.monitoring.index'),
        default    => redirect('/dashboard'),
    };
}

    /**
     * Logout user dan hapus session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}