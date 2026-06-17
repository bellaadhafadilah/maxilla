<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $transaksi->id_transaksi }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }
        .receipt-container {
            width: 58mm; /* Thermal printer width */
            padding: 4mm 2mm;
            box-sizing: border-box;
            margin: 0 auto;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .header {
            margin-bottom: 8px;
        }
        .header h1 {
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }
        
        .info-section {
            margin-bottom: 6px;
        }
        .info-row {
            display: flex;
            justify-content: flex-start;
        }
        
        .item-section {
            margin: 4px 0;
        }
        .item-name {
            text-transform: uppercase;
            display: block;
            margin-top: 4px;
        }
        .item-detail {
            display: flex;
            justify-content: space-between;
        }
        
        .summary-section {
            margin-top: 6px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
        }
        
        .footer {
            margin-top: 15px;
            font-size: 9px;
        }

        @media print {
            body { width: 58mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body style="background-color: #f3f4f6; padding: 20px;">

<div class="receipt-container" style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin: 0 auto; width: 100%; max-width: 400px;">
    <!-- Header -->
    <div class="header text-center">
        <h1 class="font-bold" style="font-size: 18px; color: #1e3a8a;">Klinik Gigi Maxilla</h1>
        <p>Jalan Sultan Agung No. 30</p>
        <p>Kejambon Tegal</p>
        <p>0283 4532746</p>
    </div>

    <div class="divider"></div>

    <!-- Info -->
    <div class="info-section">
        <div class="info-row">
            <span>Tgl. {{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span>No. M-{{ str_pad($transaksi->id_transaksi, 10, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Items -->
    <div class="item-section">
        <!-- Obat-obatan -->
        @foreach($transaksi->reservasi->rekamMedis->resepObats as $resep)
            @if($resep->obat)
            <span class="item-name" style="font-weight: bold;">{{ $resep->obat->nama_obat }}</span>
            <div class="item-detail" style="display: flex; justify-content: space-between;">
                <span>{{ $resep->jumlah }} PCS x Rp {{ number_format($resep->obat->harga, 0, ',', '.') }}</span>
                <span>Rp {{ number_format($resep->jumlah * $resep->obat->harga, 0, ',', '.') }}</span>
            </div>
            @endif
        @endforeach

        <!-- Tindakan -->
        @if($transaksi->total_tindakan > 0)
            <span class="item-name" style="font-weight: bold;">{{ $transaksi->reservasi->rekamMedis->planning ?? 'Tindakan Medis' }}</span>
            <div class="item-detail" style="display: flex; justify-content: space-between;">
                <span>1 Kali</span>
                <span>Rp {{ number_format($transaksi->total_tindakan, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>

    <div class="divider"></div>

    <!-- Summary -->
    <div class="summary-section">
        <div class="summary-row" style="display: flex; justify-content: space-between;">
            <span>Total</span>
            <span style="font-weight: bold;">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row" style="display: flex; justify-content: space-between;">
            <span>Tunai</span>
            <span>Rp {{ $transaksi->metode_pembayaran == 'Cash' ? number_format($transaksi->total_bayar, 0, ',', '.') : '0' }}</span>
        </div>
        <div class="summary-row" style="display: flex; justify-content: space-between;">
            <span>Kartu Debit</span>
            <span>Rp {{ $transaksi->metode_pembayaran != 'Cash' ? number_format($transaksi->total_bayar, 0, ',', '.') : '0' }}</span>
        </div>
        <div class="summary-row font-bold" style="display: flex; justify-content: space-between; margin-top: 4px;">
            <span>Bayar Tunai</span>
            <span>Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row" style="display: flex; justify-content: space-between;">
            <span>Kembali</span>
            <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="info-section">
        <div class="info-row">
            <span>ID Pasien : #{{ $transaksi->reservasi->id_reservasi }}</span>
        </div>
        <div class="info-row">
            <span>Nama Pasien : {{ $transaksi->reservasi->nama_pasien ?? ($transaksi->reservasi->user->nama ?? '-') }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Footer -->
    <div class="footer text-center" style="margin-top: 20px;">
        <p>Terima kasih telah mempercayakan perawatan gigi Anda di Maxilla Dental Care.</p>
        <p class="font-bold" style="margin-top: 8px;">SEMOGA LEKAS SEMBUH</p>
    </div>
</div>

</body>
</html>
