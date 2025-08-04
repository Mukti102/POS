<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Hutang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section table {
            width: 100%;
        }

        .info-section td {
            padding: 3px 0;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }

        td {
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .number {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .status {
            text-align: center;
            font-weight: bold;
        }

        .status.lunas {
            color: #28a745;
        }

        .status.belum-lunas {
            color: #dc3545;
        }

        .status.cicilan {
            color: #ffc107;
        }

        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            color: #333;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .signature {
            margin-top: 50px;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN DATA HUTANG</h1>
        <p>{{ setting('site_name') ?? 'Nama Perusahaan' }}</p>
        <p>Periode: {{ $start_date ?? date('d/m/Y') }} - {{ $end_date ?? date('d/m/Y') }}</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <table style="border: none;">
            <tr>
                <td style="border: none; width: 150px;"><strong>Total Customer:</strong></td>
                <td style="border: none;">{{ $debts->groupBy('customer_name')->count() }} orang</td>
                <td style="border: none; width: 150px;"><strong>Total Transaksi:</strong></td>
                <td style="border: none;">{{ $debts->count() }} item</td>
            </tr>
        </table>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 15%;">Nama Customer</th>
                    <th style="width: 18%;">Nama Produk/Barang</th>
                    <th style="width: 8%;">Jumlah</th>
                    <th style="width: 12%;">Harga Satuan</th>
                    <th style="width: 12%;">Total</th>
                    <th style="width: 12%;">Terbayar</th>
                    <th style="width: 10%;">Sisa</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total_keseluruhan = 0;
                    $total_terbayar = 0;
                    $total_sisa = 0;
                @endphp

                @foreach ($debts as $hutang)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $hutang->transaction->costumer->name }}</td>
                        <td>{{ $hutang->transaction->transactionItems->first()->product->name }}</td>
                        <td class="text-center">{{ $hutang->transaction->transactionItems->first()->quantity }}</td>
                        <td>Rp
                            {{ number_format($hutang->transaction->transactionItems->first()->product->selling_price) }}
                        </td>
                        <td>Rp {{ number_format($hutang->total_debt, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($hutang->paid, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($hutang->remaining, 0, ',', '.') }}</td>
                        <td class="status">
                            @if ($hutang->status !== 'lunas')
                                <span class="badges bg-danger">Belum Lunas</span>
                            @else
                                <span class="badges bg-lightgreen">Lunas</span>
                            @endif

                        </td>
                    </tr>
                    @php
                        $total_keseluruhan += $hutang->total_debt;
                        $total_terbayar += $hutang->paid;
                        $total_sisa += $hutang->remaining;
                    @endphp
                @endforeach

                <!-- Total Row -->
                <tr style="background-color: #f0f0f0; font-weight: bold;">
                    <td colspan="5" class="text-center"><strong>TOTAL KESELURUHAN</strong></td>
                    <td class="number"><strong>Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</strong></td>
                    <td class="number"><strong>Rp {{ number_format($total_terbayar, 0, ',', '.') }}</strong></td>
                    <td class="number"><strong>Rp {{ number_format($total_sisa, 0, ',', '.') }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="summary">
        <h3>RINGKASAN</h3>
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 250px;">Total Hutang Keseluruhan:</td>
                <td style="border: none; text-align: right; font-weight: bold;">Rp
                    {{ number_format($total_keseluruhan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none;">Total Sudah Terbayar:</td>
                <td style="border: none; text-align: right; font-weight: bold; color: green;">Rp
                    {{ number_format($total_terbayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none;">Total Sisa Hutang:</td>
                <td style="border: none; text-align: right; font-weight: bold; color: red;">Rp
                    {{ number_format($total_sisa, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none;">Persentase Terbayar:</td>
                <td style="border: none; text-align: right; font-weight: bold;">
                    {{ $total_keseluruhan > 0 ? number_format(($total_terbayar / $total_keseluruhan) * 100, 1) : 0 }}%
                </td>
            </tr>
        </table>

        <div style="margin-top: 15px;">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; width: 250px;">Status Hutang:</td>
                    <td style="border: none;"></td>
                </tr>
                <tr>
                    <td style="border: none; padding-left: 20px;">- Lunas:</td>
                    <td style="border: none; text-align: right;">{{ $debts->where('status', 'lunas')->count() }}
                        transaksi</td>
                </tr>
                <tr>
                    <td style="border: none; padding-left: 20px;">- Belum Lunas:</td>
                    <td style="border: none; text-align: right;">{{ $debts->where('status', 'belum lunas')->count() }}
                        transaksi</td>
                </tr>
            </table>
        </div>
    </div>


</body>

</html>
