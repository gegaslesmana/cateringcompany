<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitoringController extends Controller
{
    public function index()
    {
        // Mengambil data agregat (Total Employee per Dept per Shift)
        $data = $this->getMonitoringData();
        return view('security.monitoring.index', compact('data'));
    }

    public function printPdf()
    {
        $data = $this->getMonitoringData();

        // Logika konversi Logo ke Base64 agar terbaca oleh DOMPDF
        $path = public_path('images/Logo.png');
        $logoBase64 = null;

        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);
        }

        $pdf = Pdf::loadView('security.monitoring.pdf', compact('data', 'logoBase64'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Catering-Report-' . date('Y-m-d') . '.pdf');
    }

    /**
     * HELPER: Mengambil data headcount yang sudah disetujui HRD
     */
   private function getMonitoringData()
{
    return Order::with('division')
        ->where('status', 'approved') 
        ->whereDate('order_date', date('Y-m-d')) 
        ->select('shift_time', 'division_id', DB::raw('SUM(qty) as total'))
        ->groupBy('shift_time', 'division_id')
        ->get()
        ->map(function($item) {
            // Paksa 'total' menjadi integer agar tidak dibaca sebagai string oleh JavaScript
            $item->total = (int) $item->total;
            return $item;
        });
}
}