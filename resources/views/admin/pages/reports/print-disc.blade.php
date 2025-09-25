<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            width: 21cm;
            font-size: 20px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <button class="no-print" id="print">Cetak</button>
    <button class="no-print" id="close">Tutup</button>

    <h3>PERSONALITY TEST ANSWERS</h3>
    <table>
        <tr>
            <td width="100">Name</td>
            <td width="20">:</td>
            <td>{{ $personal->full_name }}</td>
        </tr>
        <tr>
            <td>Position</td>
            <td>:</td>
            <td>{{ $personal->position }}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>:</td>
            <td>{{ $personal->user->disc_date ? date('d/m/Y', strtotime($personal->user->disc_date)) : '' }}</td>
        </tr>
    </table>
    <hr>
    @php
        $range = range(1, 24);
        $chunk = array_chunk($range, 8);
    @endphp
    <div style="display: flex;">
        @foreach ($chunk as $c)
            <div style="width:200px;">
                <table>
                    <tr>
                        <th width="20"></th>
                        <th width="52">Most</th>
                        <th width="52">Least</th>
                    </tr>
                    @foreach ($c as $r)
                        <tr>
                            <td>{{ $r }}. </td>
                            <td style="text-align: center;">
                                {{ isset($datas[$r]) && isset($datas[$r]['similar']) ? $datas[$r]['similar'] : '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ isset($datas[$r]) && isset($datas[$r]['notsimilar']) ? $datas[$r]['notsimilar'] : '' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
</body>
<script>
    document.getElementById("print").addEventListener("click", function() {
        window.print()
    });

    document.getElementById("close").addEventListener("click", function() {
        window.close()
    });
</script>

</html>
