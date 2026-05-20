<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Transaksi Kas</title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #1e293b; line-height: 1.5; margin: 0; padding: 40px; }
        .receipt-card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; position: relative; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #10b981; padding-bottom: 20px; }
        .header h1 { color: #10b981; margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; }
        .header p { margin: 5px 0 0; color: #64748b; font-size: 14px; font-weight: bold; }
        .details { margin-bottom: 30px; }
        .row { display: flex; margin-bottom: 15px; }
        .label { width: 140px; color: #64748b; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .value { flex: 1; font-weight: bold; color: #1e293b; border-bottom: 1px dashed #e2e8f0; }
        .amount-box { background: #f8fafc; border-radius: 8px; padding: 20px; text-align: center; margin-top: 20px; border: 1px solid #e2e8f0; }
        .amount-label { font-size: 10px; text-transform: uppercase; color: #64748b; margin-bottom: 5px; font-weight: bold; }
        .amount-value { font-size: 28px; color: #10b981; font-weight: 900; }
        .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 20px; }
        .watermark { position: absolute; font-size: 80px; color: rgba(16, 185, 129, 0.05); top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); pointer-events: none; }
        table { width: 100%; }
        td { vertical-align: top; padding: 8px 0; }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="watermark">BUKTI</div>
        <div class="header">
            <p>BUKTI TRANSAKSI KAS</p>
            <h1>{{ $transaction->classroom->name }}</h1>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td class="label">ID TRANSAKSI</td>
                    <td class="value">#TX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td class="label">NAMA</td>
                    <td class="value">{{ $transaction->member ? $transaction->member->name : 'UMUM/KAS KELAS' }}</td>
                </tr>
                <tr>
                    <td class="label">KETERANGAN</td>
                    <td class="value">{{ $transaction->description ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="label">TANGGAL</td>
                    <td class="value">{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <td class="label">TIPE</td>
                    <td class="value" style="color: {{ $transaction->type == 'income' ? '#10b981' : '#ef4444' }}">
                        {{ $transaction->type == 'income' ? 'Pemasukan (+)' : 'Pengeluaran (-)' }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="amount-box">
            <div class="amount-label">NOMINAL TRANSAKSI</div>
            <div class="amount-value">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</div>
        </div>

        <div class="footer">
            <p>Dihasilkan secara otomatis oleh Sistem Bendahara - {{ now()->format('d/m/Y H:i') }}</p>
            <p>Simpan bukti ini sebagai referensi pembayaran yang sah.</p>
        </div>
    </div>
</body>
</html>
