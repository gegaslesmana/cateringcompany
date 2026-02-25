<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Division; 
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk fungsi Sum

class ApprovalController extends Controller
{
    public function index() 
    {
        // 1. Ambil semua data order untuk tabel
        $orders = Order::with(['division', 'user', 'plant'])->latest()->get(); 
        
        // 2. Data untuk dropdown filter
        $divisions = Division::all();
        $plants = Plant::all(); 

        // 3. LOGIKA SUMMARY: Menghitung Total People yang sudah di-Approve PER SHIFT
        // Ini akan menghasilkan data seperti: [12:00 => 150, 18:00 => 40, dst]
       $summaryPerShift = Order::where('status', 'approved') // Pastikan pakai kutip ''
    ->whereDate('order_date', date('Y-m-d'))
    ->select('shift_time', DB::raw('SUM(qty) as total_people'))
    ->groupBy('shift_time')
    ->get();

        // 4. Hitung Grand Total (Total semua shift yang sudah approved)
        $grandTotalApproved = $summaryPerShift->sum('total_people');

        // Kirim semua variabel ke view
        return view('hrd.orders.index', compact(
            'orders', 
            'divisions', 
            'plants', 
            'summaryPerShift', 
            'grandTotalApproved'
        ));
    }

    public function approve($id) 
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Data Headcount berhasil disetujui!');
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->ids; 
        if ($ids) {
            Order::whereIn('id', $ids)->update(['status' => 'approved']);
            return response()->json(['success' => 'Selected orders approved!']);
        }
        return response()->json(['error' => 'No orders selected'], 400);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}