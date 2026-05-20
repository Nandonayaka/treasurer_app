<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kas Kelas</title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #1e293b; font-size: 12px; margin: 0; padding: 30px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #10b981; font-size: 20px; }
        .header p { margin: 5px 0; color: #64748b; font-weight: bold; }
        .summary { margin-bottom: 25px; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; background: #f8fafc; }
        .summary table { width: 100%; }
        .summary-title { font-size: 10px; color: #64748b; text-transform: uppercase; font-weight: bold; }
        .summary-value { font-size: 16px; font-weight: bold; color: #1e293b; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #10b981; color: white; padding: 10px; text-align: left; text-transform: uppercase; font-size: 10px; }
        table.data td { border-bottom: 1px solid #f1f5f9; padding: 10px; font-size: 11px; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; color: #94a3b8; }
        .type-income { color: #10b981; font-weight: bold; }
        .type-expense { color: #ef4444; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN RIWAYAT KAS</h1>
        <p>{{ $classroom->name }}</p>
        <p style="font-size: 10px; color: #94a3b8;">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    @php
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
    @endphp

    <div class="summary">
        <table>
            <tr>
                <td>
                    <div class="summary-title">Total Pemasukan</div>
                    <div class="summary-value" style="color: #10b981;">Rp{{ number_format($totalIncome, 0, ',', '.') }}</div>
                </td>
                <td>
                    <div class="summary-title">Total Pengeluaran</div>
                    <div class="summary-value" style="color: #ef4444;">Rp{{ number_format($totalExpense, 0, ',', '.') }}</div>
                </td>
                <td style="text-align: right;">
                    <div class="summary-title">Saldo Akhir</div>
                    <div class="summary-value">Rp{{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama / Referensi</th>
                <th>Keterangan</th>
                <th>Tipe</th>
                <th style="text-align: right;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $tx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $tx->member ? $tx->member->name : 'UMUM' }}</strong></td>
                <td>{{ $tx->description ?: '-' }}</td>
                <td class="{{ $tx->type == 'income' ? 'type-income' : 'type-expense' }}">
                    {{ $tx->type == 'income' ? 'MASUK' : 'KELUAR' }}
                </td>
                <td style="text-align: right;"><strong>Rp{{ number_format($tx->amount, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dihasilkan otomatis oleh Sistem Bendahara Digital.</p>
    </div>
</body>
</html>
