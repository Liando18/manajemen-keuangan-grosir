<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .print-container {
                max-width: 100%;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            .print-hidden {
                display: none !important;
            }
        }

        body {
            margin: 0;
            padding: 0;
        }

        .print-container {
            width: 297mm;
            height: 210mm;
            margin: 20px auto;
            padding: 0;
            background: white;
            box-shadow: 0 0 0 1px #e5e7eb;
        }

        .header-corp {
            text-align: center;
            border-bottom: 1px solid #000;
            padding: 15px 30px;
            margin: 0;
        }

        .header-corp p {
            font-size: 11px;
            color: #333;
            margin: 0;
            line-height: 1.4;
        }

        .content-body {
            padding: 30px;
        }

        .footer-signature {
            margin-top: 20px;
            width: 200px;
            text-align: center;
            margin-left: auto;
            margin-right: 0px;
        }

        .signature-item {
            text-align: center;
        }

        .signature-date {
            margin-bottom: 80px;
            font-size: 11px;
            color: #333;
        }

        .signature-name {
            font-size: 11px;
            color: #000;
            margin-top: 30px;
            padding-top: 5px;
            min-height: 15px;
        }

        .signature-title {
            font-size: 10px;
            color: #333;
            margin-top: 2px;
            font-weight: 600;
        }

        .print-container {
            position: relative;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="print-hidden text-center py-4 sticky top-0 bg-white border-b border-gray-200 shadow-md z-50">
        <button onclick="window.print()"
            class="bg-blue-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-600 transition-all">
            Cetak Laporan
        </button>
    </div>

    <div class="print-container">
        <div class="header-corp">
            <h1 class="text-2xl font-bold">Grosir Netral</h1>
            <p class="text-sm">Jl. Bukit Ngalau No.Kel, RT.3/RW.3, Batu Gadang, Kec. Lubuk Kilangan, Kota Padang,
                Sumatera Barat 25236
            </p>
        </div>

        <div class="content-body">
            {{ $slot }}
        </div>

        <div class="footer-signature">
            <div class="signature-item">
                <div class="signature-date">
                    Padang, {{ \Carbon\Carbon::now()->translatedFormat('d-m-Y') }} <br>
                    <div class="signature-title">Pemilik</div>
                </div>
                <div class="signature-name">
                    @php
                        $owner = \App\Models\Akun::where('role', 'pemilik')->first();
                    @endphp
                    ({{ $owner ? $owner->nama : '____________________' }})
                </div>
            </div>
        </div>
    </div>
</body>

</html>
