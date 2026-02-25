@extends('layouts.app')

@section('content')
<div class="container mt-4 animate__animated animate__fadeInDown">
    <div class="d-flex align-items-center justify-content-between bg-white p-3 shadow-sm rounded-4 border-start border-success border-4">
        <div class="d-flex align-items-center">
            <div class="bg-white rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" style="height: 40px;">
            </div>
            <div class="ms-3">
                <h5 class="fw-bold mb-0 text-dark" style="letter-spacing: 1px;">PT. CRAZE INDONESIA</h5>
                <small class="text-success-emphasis fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 2px;">E-Catering System Management</small>
            </div>
        </div>
        <div class="text-end d-none d-md-block">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                <i class="bi bi-geo-alt-fill me-1"></i> {{ auth()->user()->plant->name ?? 'Factory Unit' }}
            </span>
        </div>
    </div>
</div>

<div class="container py-5 animate__animated animate__fadeIn">
    <div class="row">
        {{-- Sisi Kiri: Form Input --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 animate__animated animate__backInLeft">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-success-emphasis">Input Headcount</h4>
                    <form action="{{ route('operator.orders.store') }}" method="POST">
                        @csrf
                        
                        {{-- Ganti Nama Lengkap menjadi Jumlah Personil --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Jumlah Personil (Makan)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                    <i class="bi bi-people-fill text-success"></i>
                                </span>
                                <input type="number" name="qty" class="form-control form-control-lg border-start-0 rounded-end-3 shadow-none border-light-subtle" placeholder="Contoh: 25" min="1" required>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">*Total personil departemen yang akan makan.</small>
                        </div>

                       <div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Divisi / Departemen</label>
    <div class="input-group">
        <span class="input-group-text bg-light border-end-0 rounded-start-3">
            <i class="bi bi-building text-success"></i>
        </span>
        {{-- Kita kunci pilihan agar PIC tidak bisa memilih departemen lain --}}
        <select name="division_id" class="form-select form-select-lg border-start-0 rounded-end-3 shadow-none bg-light" style="pointer-events: none;" readonly>
            <option value="{{ auth()->user()->division_id }}" selected>
                {{ auth()->user()->division->name ?? 'Departemen Belum Diset' }}
            </option>
        </select>
    </div>
    <small class="text-success" style="font-size: 0.7rem;">
        <i class="bi bi-info-circle-fill"></i> Otomatis terkunci sesuai akun PIC: <strong>{{ auth()->user()->division->name ?? '-' }}</strong>
    </small>
</div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Lokasi Plant (Pabrik)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                    <i class="bi bi-geo-alt-fill text-success"></i>
                                </span>
                                <select name="plant_id" class="form-select select-plant-custom border-start-0 rounded-end-3 shadow-none border-light-subtle" required>
                                    @foreach(\App\Models\Plant::all() as $plant)
                                        <option value="{{ $plant->id }}" {{ auth()->user()->plant_id == $plant->id ? 'selected' : '' }}>
                                            {{ $plant->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Pilih Shift Time</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(['12:00', '18:00', '00:00', '04:00'] as $time)
                                        <input type="radio" class="btn-check" name="shift_time" id="shift_{{ $time }}" value="{{ $time }}" required {{ $loop->first ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success-dark rounded-pill px-4 py-2 fw-semibold transition-hover" for="shift_{{ $time }}">
                                            <i class="bi bi-clock me-1"></i> {{ $time }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Tanggal Makan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                        <i class="bi bi-calendar3 text-success"></i>
                                    </span>
                                    <input type="date" name="order_date" class="form-control form-control-lg border-start-0 rounded-end-3 shadow-none border-light-subtle custom-datepicker" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Catatan (Remark)</label>
                            <textarea name="remark" class="form-control rounded-3 shadow-none border-light-subtle" rows="2" placeholder="Contoh: Tambahan lembur..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success-dark w-100 py-3 rounded-3 fw-bold shadow-sm transition-hover">
                            Kirim Data <i class="bi bi-send-fill ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Tabel List --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 animate__animated animate__fadeInUp">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold m-0 text-secondary">Riwayat Input Departemen</h4>
                        <span class="badge bg-success-subtle text-success p-2 px-3 rounded-pill">Total: {{ $orders->count() }} Entry</span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-success-emphasis">
                                <tr class="text-uppercase small fw-bold">
                                    <th class="py-3">Departemen</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Shift</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $o)
                                <tr class="transition-row">
                                    <td class="fw-medium text-dark">
                                        {{ $o->division->name }}<br>
                                        <small class="text-muted fw-normal">PIC: {{ $o->user->name }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold">
                                            {{ $o->qty }} People
                                        </span>
                                    </td>
                                    <td><code class="bg-success-subtle px-2 py-1 rounded text-success fw-bold">{{ $o->shift_time }}</code></td>
                                    <td class="small text-secondary">{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        @if($o->status == 'approved')
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 border border-success-subtle">
                                                <i class="bi bi-check-circle-fill me-1"></i> Approved
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 border border-warning-subtle">
                                                <i class="bi bi-clock-history me-1"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted small italic">Belum ada data headcount yang diinput.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --dark-green: #1a5928; --light-green-bg: #f0f7f1; }
    body { background-color: #f4f7f5; }
    .btn-success-dark { background-color: var(--dark-green); color: white; border: none; }
    .btn-success-dark:hover { background-color: #14461f; color: white; }
    .text-success-emphasis { color: var(--dark-green) !important; }
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 15px rgba(26, 89, 40, 0.2) !important; }
    .form-control:focus, .form-select:focus { border-color: var(--dark-green); box-shadow: 0 0 0 0.25rem rgba(26, 89, 40, 0.1); }
    .rounded-4 { border-radius: 1rem !important; }
    .btn-check:checked + .btn-outline-success-dark { background-color: var(--dark-green); color: white; border-color: var(--dark-green); }
    .btn-outline-success-dark { color: var(--dark-green); border: 2px solid var(--dark-green); background-color: transparent; }
    
    /* Perbaikan teks terpotong */
    .select-plant-custom {
        font-size: 0.9rem;
        height: calc(3.5rem + 2px);
        padding-right: 2.5rem !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .custom-datepicker::-webkit-calendar-picker-indicator {
        cursor: pointer;
        filter: invert(24%) sepia(45%) saturate(734%) hue-rotate(85deg) brightness(95%) contrast(91%);
    }
</style>
@endsection