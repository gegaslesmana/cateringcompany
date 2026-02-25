<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Method index untuk melihat riwayat order dan form input
     */
    public function index()
    {
        // Pastikan relasi 'user' atau 'creator' sesuai dengan model Order Anda
        // Menggunakan 'created_by' sebagai kunci pencarian history
        $orders = Order::with(['division', 'plant'])
            ->where('created_by', Auth::id()) 
            ->latest()
            ->get();

        return view('operator.orders.index', compact('orders'));
    }

    /**
     * Method store untuk menyimpan data Headcount
     */
    public function store(Request $request)
    {
        $request->validate([
            'qty'         => 'required|integer|min:1',
            'division_id' => 'required',
            'plant_id'    => 'required',
            'shift_time'  => 'required',
            'order_date'  => 'required|date',
        ]);

        // Cek apakah sudah ada input untuk departemen, tanggal, dan shift yang SAMA
        $existingOrder = Order::where('division_id', $request->division_id)
            ->where('order_date', $request->order_date)
            ->where('shift_time', $request->shift_time)
            ->where('status', 'pending')
            ->first();

        if ($existingOrder) {
            $existingOrder->update([
                'qty' => $existingOrder->qty + $request->qty
            ]);
            return back()->with('success', 'Jumlah personil ditambahkan ke input sebelumnya.');
        }

        // SIMPAN DATA BARU
Order::create([
    'created_by'  => Auth::id(), // Mengisi kolom created_by
    'user_id'     => Auth::id(), // Mengisi kolom user_id (tambahkan baris ini)
    'division_id' => $request->division_id,
    'plant_id'    => $request->plant_id,
    'shift_time'  => $request->shift_time,
    'order_date'  => $request->order_date,
    'qty'         => $request->qty,
    'name'        => Auth::user()->name,
    'remark'      => $request->remark,
    'status'      => 'pending'
]);

        return back()->with('success', 'Data headcount berhasil dikirim!');
    }

    public function create()
    {
        return view('operator.orders.create');
    }
}