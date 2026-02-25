@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --bg-main: #f1f5f9;
        --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body, html { 
        height: 100vh; 
        overflow: hidden; /* Mencegah Scroll Utama */
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-main);
    }

    .main-wrapper {
        height: calc(100vh - 80px); /* Menyesuaikan dengan tinggi navbar */
        padding: 15px;
        display: flex;
        flex-direction: column;
    }

    /* Header Compact */
    .compact-header {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        padding: 15px 25px;
        border-radius: 16px;
        margin-bottom: 15px;
        color: white;
        box-shadow: var(--card-shadow);
    }

    /* Card Styling */
    .glass-card {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: var(--card-shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    /* Stat Cards */
    .mini-stat {
        padding: 12px;
        border-radius: 12px;
        background: #f8fafc;
        border-left: 4px solid #3b82f6;
        margin-bottom: 10px;
    }

    /* Table Compact */
    .table-container {
        flex-grow: 1;
        overflow-y: auto; /* Scroll hanya di dalam tabel jika data banyak */
        scrollbar-width: thin;
    }

    .table-container::-webkit-scrollbar { width: 5px; }
    .table-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .table thead th {
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Grids */
    .grid-layout {
        display: grid;
        grid-template-columns: 1.2fr 2fr 1.5fr; /* 3 Kolom */
        gap: 15px;
        flex-grow: 1;
        min-height: 0; /* Penting untuk flexbox child overflow */
    }

    .badge-shift {
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 700;
        background: #e2e8f0;
        color: #475569;
    }

    h5 { font-weight: 800; font-size: 1rem; margin-bottom: 15px; }
</style>

<div class="main-wrapper">
    
    <div class="compact-header animate__animated animate__fadeInDown">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-800 mb-0"><i class="bi bi-shield-check me-2"></i>Security Monitoring</h4>
                <small class="opacity-75">Live Data Analytics • {{ date('d M Y') }}</small>
            </div>
            <div class="d-flex gap-2">
                <button onclick="location.reload()" class="btn btn-sm btn-light rounded-pill px-3 fw-bold">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
                <a href="{{ route('monitoring.print') }}" target="_blank" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                    <i class="bi bi-printer-fill me-1"></i> REPORT
                </a>
            </div>
        </div>
    </div>

    @php
        $shiftTotals = $data->groupBy('shift_time')->map(fn($row) => $row->sum('total'));
        $totalAll = $data->sum('total');
    @endphp

    <div class="grid-layout">
        
        <div class="animate__animated animate__fadeInLeft">
            <div class="glass-card p-3">
                <h5><i class="bi bi-activity me-2 text-primary"></i>Summary</h5>
                
                <div class="mini-stat" style="border-left-color: #6366f1;">
                    <small class="text-muted d-block fw-bold">TOTAL EATING</small>
                    <h3 class="fw-800 mb-0">{{ $totalAll }} <small class="fs-6 fw-normal">Pax</small></h3>
                </div>

                <div class="flex-grow-1 mt-2">
                    <h6 class="fw-bold mb-3 text-muted">SHIFT BREAKDOWN</h6>
                    @foreach($shiftTotals as $shift => $total)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded bg-light">
                        <span class="badge-shift">Shift {{ $shift }}</span>
                        <span class="fw-800">{{ $total }} Pax</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-auto" style="height: 180px;">
                    <canvas id="shiftPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="animate__animated animate__fadeInUp">
            <div class="glass-card p-3">
                <h5><i class="bi bi-bar-chart-fill me-2 text-success"></i>Department Analysis</h5>
                <div class="flex-grow-1" style="min-height: 0;">
                    <canvas id="deptBarChart"></canvas>
                </div>
            </div>
        </div>

        <div class="animate__animated animate__fadeInRight">
            <div class="glass-card p-0">
                <div class="p-3 border-bottom bg-light rounded-top">
                    <h5 class="mb-0"><i class="bi bi-list-stars me-2 text-warning"></i>Live Logs</h5>
                </div>
                <div class="table-container p-2">
                    <table class="table table-hover align-middle" style="font-size: 0.85rem;">
                        <thead>
                            <tr class="text-muted">
                                <th>Shift</th>
                                <th>Dept</th>
                                <th class="text-center">Pax</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <td><span class="badge-shift">{{ $d->shift_time }}</span></td>
                                <td class="fw-bold text-truncate" style="max-width: 100px;">{{ $d->division->name ?? 'N/A' }}</td>
                                <td class="text-center fw-800 text-primary">{{ (int)$d->total }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4">No data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rawData = @json($data).map(item => ({
        ...item,
        total: Number(item.total) 
    }));

    const accentColors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'];

    // --- AGGREGATE DEPT ---
    const deptTotals = {};
    rawData.forEach(item => {
        const name = item.division ? item.division.name : 'N/A';
        deptTotals[name] = (deptTotals[name] || 0) + item.total;
    });

    // --- BAR CHART ---
    new Chart(document.getElementById('deptBarChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(deptTotals),
            datasets: [{
                label: 'Employees',
                data: Object.values(deptTotals),
                backgroundColor: accentColors.map(c => c + 'cc'),
                borderRadius: 8,
                barThickness: 30
            }]
        },
        options: {
            indexAxis: 'y', // Mengubah ke Horizontal agar lebih modern dan hemat ruang
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
            }
        }
    });

    // --- AGGREGATE SHIFT ---
    const shiftData = {};
    rawData.forEach(item => {
        shiftData[item.shift_time] = (shiftData[item.shift_time] || 0) + item.total;
    });

    // --- DOUGHNUT CHART ---
    new Chart(document.getElementById('shiftPieChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(shiftData).map(s => 'Shift ' + s),
            datasets: [{
                data: Object.values(shiftData),
                backgroundColor: accentColors.slice(2),
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }
            }
        }
    });
});
</script>
@endsection