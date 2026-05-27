<!DOCTYPE html>
<html>

<head>

    <title>
        Laporan SAW Distribusi
    </title>

    <style>

        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

    </style>

</head>

<body>

    <h2>
        Laporan Ranking Prioritas Distribusi
        Metode SAW
    </h2>

    <p>

        Tanggal:
        {{ date('d M Y') }}

    </p>

    <table>

        <thead>

            <tr>

                <th>Ranking</th>

                <th>Kode Barang</th>

                <th>Nama Barang</th>

                <th>Nilai SAW</th>

                <th>Prioritas</th>

            </tr>

        </thead>

        <tbody>

            @foreach($rankingSAW as $index => $b)

            <tr>

                <td>
                    {{ $index + 1 }}
                </td>

                <td>
                    {{ $b->kode_barang }}
                </td>

                <td>
                    {{ $b->nama_barang }}
                </td>

                <td>
                    {{ $b->nilai_saw }}
                </td>

                <td>

                    @if($b->nilai_saw >= 0.80)

                        Sangat Prioritas

                    @elseif($b->nilai_saw >= 0.60)

                        Prioritas

                    @else

                        Normal

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>