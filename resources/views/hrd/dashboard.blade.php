@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard HRD</h2>

    {{-- Grafik Tren Bulanan --}}
    <div class="mb-4">
        <h4>Tren Order Bulanan</h4>
        <canvas id="chart"></canvas>
    </div>

    {{-- Log Aktivitas User --}}
    <div>
        <h4>Log Aktivitas Terbaru</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->activity }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ChartJS CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthly->pluck('month')) !!},
        datasets: [{
            label: 'Total Order',
            data: {!! json_encode($monthly->pluck('total')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection