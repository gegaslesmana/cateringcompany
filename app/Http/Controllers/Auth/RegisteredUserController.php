<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division; // Import Model Division Anda
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): View
    {
        // Ambil data divisi untuk ditampilkan di dropdown "Department"
        $divisions = Division::all(); 
        return view('auth.register', compact('divisions'));
    }

    /**
     * Menangani pendaftaran user baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        // Gunakan 'division_id' untuk memastikan relasi database yang kuat
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:operator,hrd,security'], 
            'division_id' => ['required', 'exists:divisions,id'], // Pastikan ID divisi ada di tabel
        ]);

        // 2. Simpan ke database
       $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => $request->role,
    'plant_id' => $request->plant_id ?? 1, 
    'division_id' => $request->division_id, // 👈 Ini yang bikin Harun punya divisi
]);

        event(new Registered($user));

        // 3. Langsung login setelah daftar
        Auth::login($user);

        // 4. Redirect berdasarkan Role
        return match($user->role) {
            'operator' => redirect()->route('operator.orders.index'),
            'hrd'      => redirect()->route('hrd.orders.index'),
            'security' => redirect()->route('security.monitoring.index'),
            default    => redirect('/dashboard'),
        };
    }
}