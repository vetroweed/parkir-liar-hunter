<?php
include '../conn/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir Liar Hunter</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 24px;
        }

        .header p {
            color: #7f8c8d;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th {
            background-color: #3498db;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #7f8c8d;
        }

        .status-ditolak {
            color: #f00000;
            font-weight: bold;
        }

        .status-proses {
            color: #3498db;
            font-weight: bold;
        }

        .status-selesai {
            color: #27ae60;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN LAYANAN PENGADUAN PARKIR LIAR HUNTER</h1>
        <p>Dinas Terkait - <?php echo date('d F Y'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK Pelapor</th>
                <th>Nama Pelapor</th>
                <th>Nama Petugas</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Ditanggapi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM pengaduan 
                INNER JOIN masyarakat ON pengaduan.nik=masyarakat.nik 
                INNER JOIN tanggapan ON tanggapan.id_pengaduan=pengaduan.id_pengaduan 
                INNER JOIN petugas ON tanggapan.id_petugas=petugas.id_petugas 
                ORDER BY tgl_pengaduan DESC");

            while ($r = mysqli_fetch_assoc($query)) {
                $statusClass = '';
                if ($r['status'] == 'ditolak')
                    $statusClass = 'status-ditolak';
                if ($r['status'] == 'proses')
                    $statusClass = 'status-proses';
                if ($r['status'] == 'selesai')
                    $statusClass = 'status-selesai';
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $r['nik']; ?></td>
                    <td><?php echo ucwords(strtolower($r['nama'])); ?></td>
                    <td><?php echo ucwords(strtolower($r['nama_petugas'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($r['tgl_pengaduan'])); ?></td>
                    <td><?php echo $r['tgl_tanggapan'] ? date('d/m/Y', strtotime($r['tgl_tanggapan'])) : '-'; ?></td>
                    <td class="<?php echo $statusClass; ?>">
                        <?php echo ucfirst($r['status']); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: <?php echo date('d F Y H:i:s'); ?></p>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>