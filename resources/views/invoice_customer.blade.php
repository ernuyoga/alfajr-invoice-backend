<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Customer</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        .header { text-align: center; }
        .logo { width: 100px; }
        .rekap-title { background: #d6b13a; color: #fff; font-weight: bold; text-align: center; padding: 6px 0; margin-bottom: 10px; }
        .flex-row { display: flex; justify-content: space-between; align-items: flex-start; }
        .trx-info { width: 60%; }
        .trx-kode { font-size: 20px; color: #d6b13a; font-weight: bold; text-align: right; }
        .company-info { text-align: right; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid #333; padding: 6px 8px; }
        .table th { background: #d6b13a; color: #fff; }
        .table-no-border { width: 100%; border: none; margin-bottom: 0; }
        .table-no-border td { border: none; padding: 4px 0; }
        .section-title { margin-top: 18px; font-weight: bold; }
        .yellow { background: #ffeebd; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .footer { margin-top: 28px; font-size: 13px; }
        .stamp { width: 100px; }
        .sign { margin-top: 30px; text-align: right; }
        .status { background: #ffeebd; font-weight: bold; }
        .lunas { background: #d6b13a; color: #fff; font-weight: bold; padding: 4px 0; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('logo.png') }}" class="logo" alt="Logo" />
    </div>
    <div class="rekap-title">
        REKAP PEMBAYARAN TRANSAKSI
    </div>
    <div class="flex-row">
        <div class="trx-info">
            <table class="table-no-border">
                <tr>
                    <td>Transaksi</td>
                    <td>: Transaksi Paket Umroh</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">User</td>
                    <td style="vertical-align: top;">
                        @foreach($invoice->jamaahs as $idx => $jamaah)
                            {{ $idx+1 }}. {{ $jamaah->jamaahMAwalan->nama ?? '' }} {{ $jamaah->nama }}<br>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <div class="trx-kode">{{ $invoice->kode }}</div>
            <div class="company-info">
                PT ALFAJR TRAVELINDO INDONESIA <br>
                KANTOR MADIUN<br>
                Jl. Panjaitan 3C Madiun<br>
                @alfajrindonesia.id<br>
                0815-5666-8666
            </div>
        </div>
    </div>
    <br>
    <div>
        <span>Yang Terhormat {{ $invoice->jamaahs[0]->jamaahMAwalan->nama ?? '' }} {{ $invoice->jamaahs[0]->nama ?? '' }} dan keluarga</span><br>
        Berikut adalah rincian pembayarannya:
    </div>

    <table class="table">
        <tr>
            <th>Uraian</th>
            <th>Jumlah Pax</th>
            <th>Biaya Umroh</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>
                {{ $invoice->paket->nama ?? '-' }} Program {{ $invoice->paket->durasi ?? '-' }} Hari<br>
                Kloter {{ \Carbon\Carbon::parse($invoice->paket->tanggal)->format('d F Y') }}<br>
                <span style="font-size:12px;">
                    Paket sudah termasuk:
                    <ul style="margin: 6px 10px;">
                        <li>Tiket Pesawat International Flight</li>
                        <li>Seragam, mukena/ihram, syal, buku, tas slempang</li>
                        <li>Visa, handling, hotel, bus, makan 3x sehari</li>
                        <li>Muthowif dan Tour Leader</li>
                        <li>Asuransi Perjalanan</li>
                        <li>Air Zamzam</li>
                        <li>Koper</li>
                        <li>Transport koper</li>
                        <li>Transport manasik PP</li>
                        <li>Transport pemberangkatan Umroh</li>
                        <li>Transport kepulangan Umroh</li>
                        <li>Pendampingan pembuatan paspor elektronik</li>
                    </ul>
                </span>
            </td>
            <td class="text-right">{{ count($invoice->jamaahs) }}</td>
            <td class="text-right">Rp {{ number_format($invoice->paket->harga ?? 0, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($invoice->total_tagihan ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="section-title">Pembayaran Diterima</div>
    <table class="table">
        <tr>
            <th></th>
            <th>Tanggal</th>
            <th>Nominal</th>
            <th>Total</th>
        </tr>
        @foreach($invoice->pembayaranDiterimas as $idx => $bayar)
            <tr>
                <td>{{ $idx+1 }}. {{ $bayar->jenis }}</td>
                <td>{{ \Carbon\Carbon::parse($bayar->tanggal)->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</td>
                @if($idx == 0)
                    <td class="text-right" rowspan="{{ count($invoice->pembayaranDiterimas) }}">
                        Rp {{ number_format($invoice->total_bayar, 0, ',', '.') }}
                    </td>
                @endif
            </tr>
        @endforeach
    </table>

    <table class="table">
        <tr>
            <td class="yellow text-bold">Sisa Pembayaran</td>
            <td class="yellow text-right">Rp {{ number_format($invoice->sisa_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="status">STATUS</td>
            <td class="lunas text-center">
                {{ strtoupper($invoice->invoiceMStatus->nama ?? '') }}
            </td>
        </tr>
    </table>

    <div class="footer">
        Terima kasih telah melakukan transaksi paket umroh di PT AlFajr Travelindo Indonesia.
    </div>
    <div class="sign">
        <div>Madiun, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>Hormat Kami,</div>
        <div>PT. Al Fajr Travelindo Indonesia<br>Kantor Madiun</div>
        <img src="{{ public_path('stamp.png') }}" class="stamp" alt="Stempel" />
        <div>Dr. Fitra Pinanditha, M.Pd.</div>
    </div>
</body>
</html>
