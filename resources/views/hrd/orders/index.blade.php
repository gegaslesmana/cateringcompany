@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
    .dashboard-header { margin-bottom: 30px; padding-top: 20px; }
    .dashboard-header h2 { font-weight: 800; color: #1a5928; letter-spacing: -1px; }
    .modern-card { background: white; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); overflow: hidden; }
    .table-container { padding: 20px; }
    .table thead { background-color: #f1f5f9; }
    .table thead th { border: none; padding: 15px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #64748b; font-weight: 700; }
    .table tbody td { padding: 18px 15px; vertical-align: middle; color: #334155; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
    .badge-shift { background: #e2e8f0; color: #475569; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; }
    .badge-status { padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.72rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px; }
    .status-pending { background-color: #fff7ed; color: #c2410c; border: 1px solid #fdba74; }
    .status-approved { background-color: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
    .btn-approve { background: #1a5928; color: white; border: none; border-radius: 10px; padding: 8px 15px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; }
    .btn-approve:hover { background: #14461f; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(26, 89, 40, 0.3); color: white; }
    .btn-unapprove { background: #dc3545; color: white; border: none; border-radius: 10px; padding: 8px 15px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; }
    .btn-unapprove:hover { background: #bb2d3b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3); color: white; }
    
    /* Card Summary Styling */
    .summary-card { border-radius: 18px; border: none; transition: transform 0.3s ease; }
    .summary-card:hover { transform: translateY(-5px); }
</style>

<div class="container py-4">
    <div class="dashboard-header animate__animated animate__fadeInLeft">
        <div class="d-flex align-items-center gap-3">
            <div style="background: #1a5928; width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-clipboard-check-fill text-white fs-4"></i>
            </div>
            <div>
                <h2 class="mb-0">Approval Headcount</h2>
                <p class="text-muted mb-0 small">Rekapitulasi jumlah makan karyawan per Shift</p>
            </div>
        </div>
    </div>

    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-md-3 mb-3">
            <div class="card summary-card bg-success text-white shadow">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase small fw-bold opacity-75">Total Approved (Today)</h6>
                    <h2 class="fw-800 mb-0">{{ $grandTotalApproved ?? 0 }} <small class="fs-6">People</small></h2>
                </div>
            </div>
        </div>
        @foreach($summaryPerShift as $shift)
        <div class="col-md-2 mb-3">
            <div class="card summary-card bg-white border-start border-success border-4 shadow-sm">
                <div class="card-body p-3">
                    <p class="text-muted small fw-bold mb-1">Shift {{ $shift->shift_time }}</p>
                    <h4 class="mb-0 text-success fw-800">{{ $shift->total_people }}</h4>
                    <span class="text-muted" style="font-size: 0.7rem;">Approved People</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="modern-card animate__animated animate__fadeInUp">
        <div class="table-container">
            <div class="row mb-4 align-items-center">
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-2">Filter Divisi</label>
                    <select id="filterDivisi" class="form-select border-0 shadow-sm" style="border-radius: 12px;">
                        <option value="">Semua Divisi</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div->name }}">{{ $div->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-2">Filter Plant</label>
                    <select id="filterPlant" class="form-select border-0 shadow-sm" style="border-radius: 12px;">
                        <option value="">Semua Plant</option>
                        @foreach($plants as $p)
                            <option value="{{ $p->name }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 text-end pt-4">
                    <button id="btnBulkApprove" class="btn btn-outline-success d-none" style="border-radius: 12px; font-weight: 600;">
                        <i class="bi bi-check-all"></i> Approve Terpilih (<span id="selectedCount">0</span>)
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="orderTable" class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px;"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                            <th>Departemen / PIC</th>
                            <th class="text-center">Jumlah People</th>
                            <th>Plant</th>
                            <th>Shift</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $o)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="order-checkbox form-check-input" value="{{ $o->id }}">
                            </td>
                            <td>
                                <span class="fw-bold">{{ $o->division->name ?? '-' }}</span><br>
                                <small class="text-muted">PIC: {{ $o->name }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                    {{ $o->qty }} People
                                </span>
                            </td>
                            <td><span class="badge bg-light text-success border border-success-subtle">{{ $o->plant->name ?? '-' }}</span></td>
                            <td><span class="badge-shift">{{ $o->shift_time }}</span></td>
                            <td><span class="fw-600">{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</span></td>
                            
                            <td>
                                @if($o->status === 'approved')
                                    <span class="badge-status status-approved">
                                        <i class="bi bi-check-circle-fill"></i> Approved
                                    </span>
                                @else
                                    <span class="badge-status status-pending">
                                        <i class="bi bi-clock-history"></i> Pending
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($o->status !== 'approved')
                                    <form action="{{ route('hrd.orders.approve', $o->id) }}" method="POST" class="form-approve">
                                        @csrf
                                        <button type="submit" class="btn-approve" title="Setujui Order">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('hrd.orders.destroy', $o->id) }}" method="POST" class="form-unapprove">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn-unapprove" title="Batalkan/Hapus Order">
                                            <i class="bi bi-x-lg"></i> {{ $o->status === 'approved' ? 'Cancel' : 'Hapus' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script section tetap sama dengan yang Anda miliki sebelumnya --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const table = $('#orderTable').DataTable({
        "pageLength": 10,
        "ordering": false,
        "language": {
            "search": "",
            "searchPlaceholder": "Cari data...",
            "lengthMenu": "_MENU_ per halaman",
            "paginate": { "previous": "<", "next": ">" }
        }
    });

    // Filter Logic
    $('#filterDivisi').on('change', function() { table.column(1).search(this.value).draw(); });
    $('#filterPlant').on('change', function() { table.column(3).search(this.value).draw(); });

    // Select All
    $('#selectAll').on('click', function() {
        const rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
        updateBulkButton();
    });

    $(document).on('change', '.order-checkbox', function() { updateBulkButton(); });

    function updateBulkButton() {
        const checkedCount = $('.order-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#btnBulkApprove').removeClass('d-none');
            $('#selectedCount').text(checkedCount);
        } else {
            $('#btnBulkApprove').addClass('d-none');
        }
    }

    // Bulk Approve AJAX
    $('#btnBulkApprove').on('click', function() {
        let ids = [];
        $('.order-checkbox:checked').each(function() { ids.push($(this).val()); });

        Swal.fire({
            title: 'Konfirmasi Bulk Approve',
            text: "Setujui " + ids.length + " laporan headcount terpilih?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a5928',
            confirmButtonText: 'Ya, Approve Semua!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('hrd.orders.bulkApprove') }}",
                    type: 'POST',
                    data: { _token: "{{ csrf_token() }}", ids: ids },
                    success: function(response) {
                        Swal.fire('Berhasil!', response.success, 'success').then(() => { location.reload(); });
                    }
                });
            }
        });
    });

    // Delete/Cancel Confirmation
    $(document).on('click', '.btn-unapprove', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus Data?',
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => { if (result.isConfirmed) { form.submit(); } });
    });
});
</script>
@endsection