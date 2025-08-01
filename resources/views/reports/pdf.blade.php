<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Tahun {{ $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: left;
            margin: 0;
            padding: 20px;
        }

        .header {
            position: relative;
            margin-bottom: 25px;
            height: 80px;
        }

        .header img {
            position: absolute;
            left: 0;
            top: 0;
            width: 50px;
        }

        .header .title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 20px;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        td.center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo.png') }}" alt="Logo">
        <div class="title">
            <h2>Laporan Surat Masuk & Keluar</h2>
            <p>Per Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    <h4>Surat Masuk Tahun {{ $year }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Asal Surat / Pengirim</th>
                <th>Perihal</th>
                <th>Tanggal Surat</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($incoming as $i => $letter)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $letter->letter_number }}</td>
                    <td>{{ $letter->sender_name ?? '-' }}</td>
                    <td>{{ $letter->regarding }}</td>
                    <td>{{ \Carbon\Carbon::parse($letter->date_of_letter)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($letter->date_of_entry)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td class="center" colspan="6">Data tidak ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4>Surat Keluar Tahun {{ $year }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Perusahaan Tujuan</th>
                <th>Perihal</th>
                <th>Tanggal Surat</th>
                <th>Tanggal Keluar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($outgoing as $i => $letter)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $letter->letter_number }}</td>
                    <td>{{ $letter->purpose ?? '-' }}</td>
                    <td>{{ $letter->regarding ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($letter->date_of_letter)->format('d-m-Y') }}</td>
                    <td>{{ $letter->created_at ? \Carbon\Carbon::parse($letter->created_at)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="center" colspan="6">Data tidak ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
