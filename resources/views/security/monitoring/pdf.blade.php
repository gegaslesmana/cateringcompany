<!DOCTYPE html>
<html>
<head>
    <title>Catering Report - Emerald Edition</title>
    <style>
        /* Konfigurasi Warna Hijau Sesuai Logo */
        :root {
            --primary-color: #064e3b; /* Hijau Tua (Forest Green) */
            --accent-color: #10b981;  /* Hijau Muda (Emerald Green) */
            --border-color: #d1fae5;  /* Hijau Sangat Muda untuk border */
            --text-dark: #064e3b;
            --text-light: #6b7280;
            --bg-light: #f0fdf4;     /* Background Hijau Tipis */
        }

        @page { 
            margin: 0; 
        }
        
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: var(--text-dark); 
            line-height: 1.5; 
            margin: 0;
            padding: 0;
        }

        /* Border Atas Modern Gradient Hijau */
        .top-bar {
            height: 8px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            width: 100%;
        }

        .container {
            padding: 1cm 1.5cm;
        }

        /* Header / Kop Surat */
        .header-table {
            width: 100%;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-name { 
            font-size: 22px; 
            font-weight: 800; 
            color: var(--primary-color);
            text-transform: uppercase; 
            margin: 0; 
            letter-spacing: 1px;
        }

        .company-address { 
            font-size: 10px; 
            color: var(--text-light); 
            margin-top: 5px;
        }

        /* Judul Dokumen */
        .title-section {
            text-align: right;
        }

        .doc-title { 
            font-size: 18px; 
            font-weight: bold; 
            color: var(--primary-color);
            margin: 0;
        }

        .doc-number { 
            font-size: 11px; 
            color: var(--accent-color);
            font-weight: bold;
        }

        /* Info Box Hijau Muda */
        .info-box {
            background-color: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            width: 100%;
        }

        .info-table td {
            font-size: 11px;
            padding: 3px 0;
        }

        .label { color: var(--accent-color); font-weight: bold; width: 100px; }

        /* Tabel Utama */
        .main-table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            margin-bottom: 40px;
        }

        .main-table th { 
            background-color: var(--primary-color); 
            color: white; 
            padding: 12px 15px; 
            font-size: 11px; 
            text-transform: uppercase;
            text-align: left;
            border: none;
        }

        .main-table th:first-child { border-radius: 8px 0 0 0; }
        .main-table th:last-child { border-radius: 0 8px 0 0; }

        .main-table td { 
            padding: 12px 15px; 
            font-size: 11px; 
            border-bottom: 1px solid var(--border-color);
        }

        .main-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .total-row td { 
            background-color: var(--primary-color); 
            color: white; 
            font-weight: bold;
            font-size: 13px;
            border: none;
        }
        
        .total-row td:first-child { border-radius: 0 0 0 8px; }
        .total-row td:last-child { border-radius: 0 0 8px 0; }

        /* Approval Section */
        .approval-card {
            border: 1px solid var(--border-color);
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
        }

        .approval-box { 
            text-align: center; 
            font-size: 11px; 
        }

        .signature-space { 
            height: 60px; 
            margin: 10px 0;
        }

        .signer-name {
            font-weight: bold;
            text-decoration: underline;
            color: var(--primary-color);
            display: block;
        }

        .footer { 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            font-size: 9px; 
            color: #9ca3af; 
            text-align: center; 
            padding: 15px 0;
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <div class="top-bar"></div>

    <div class="container">
        <table class="header-table">
            <tr>
                <td width="80" style="vertical-align: middle;">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" width="80">
                    @else
                        <div style="width: 70px; height: 70px; background: var(--primary-color); color: white; border-radius: 8px; text-align: center; line-height: 70px; font-size: 10px;">LOGO</div>
                    @endif
                </td>
                <td style="vertical-align: middle; padding-left: 20px;">
                    <p class="company-name">PT. CRAZE INDONESIA</p>
                    <p class="company-address">
                        Jababeka Industrial Estate Blok C-12, Cikarang, Bekasi<br>
                        T: (021) 1234 5678 &bull; E: security.admin@craze.co.id
                    </p>
                </td>
                <td class="title-section" style="vertical-align: middle;">
                    <p class="doc-title">EMPLOYEE MEALS RECAP</p>
                    <p class="doc-number">Ref: {{ date('Ymd') }}/SEC-CAT/{{ date('m') }}</p>
                </td>
            </tr>
        </table>

        <div class="info-box">
            <table class="info-table" width="100%">
                <tr>
                    <td class="label">DATE REPORT</td>
                    <td style="font-weight: bold;">: {{ date('l, d F Y') }}</td>
                    <td class="label">DEPARTMENT</td>
                    <td style="font-weight: bold;">: SECURITY & GA</td>
                </tr>
                <tr>
                    <td class="label">CATEGORY</td>
                    <td>: Employee Daily Meals</td>
                    <td class="label">STATUS</td>
                    <td>: <span style="background-color: var(--accent-color); color: white; padding: 2px 8px; border-radius: 4px; font-size: 9px;">VERIFIED</span></td>
                </tr>
            </table>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th width="8%">NO</th>
                    <th width="27%">SHIFT PERIOD</th>
                    <th width="40%">DIVISION / DEPARTMENT</th>
                    <th width="25%" style="text-align: center;">HEADCOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $d)
                <tr>
                    <td style="text-align: center; color: var(--text-light);">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td style="font-weight: bold; color: var(--primary-color);">{{ $d->shift_time }}</td>
                    <td>{{ $d->division->name ?? 'N/A' }}</td>
                    <td style="text-align: center; font-weight: bold; border-left: 1px solid var(--border-color);">
                        {{ $d->total }} <small style="font-weight: normal; color: var(--text-light);">Employee</small>
                    </td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right; padding-right: 25px;">TOTAL EMPLOYEE EATING</td>
                    <td style="text-align: center;">{{ $data->sum('total') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="approval-card">
            <table width="100%" class="approval-table">
                <tr>
                    <td class="approval-box" width="33%">
                        <span style="color: var(--text-light);">Prepared by:</span><br>
                       
                        <div class="signature-space"></div>
                        <span class="signer-name">( ____________________ )</span>
                    </td>
                    <td class="approval-box" width="34%">
                        <span style="color: var(--text-light);">Checked by:</span><br>
                       
                        <div class="signature-space"></div>
                        <span class="signer-name">( ____________________ )</span>
                    </td>
                    <td class="approval-box" width="33%">
                        <span style="color: var(--text-light);">Approved by:</span><br>
                        <strong>HRD Manager</strong>
                        <div class="signature-space"></div>
                        <span class="signer-name">( ____________________ )</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} PT. CRAZE INDONESIA &bull; Emerald System Generated Report &bull; HRDGA-IT CRAZE
    </div>
</body>
</html>