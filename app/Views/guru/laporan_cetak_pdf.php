<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan CyberGuard</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        h1 { margin: 0 0 5px 0; font-size: 18px; text-transform: uppercase; }
        p { margin: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; text-transform: uppercase; font-size: 10px; }
        @media print { @page { size: landscape; } button { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Laporan Rekapitulasi CyberGuard</h1>
        <p>Aplikasi Pencegahan Cyberbullying & Pemantauan Kesejahteraan Siswa</p>
        <p>Tanggal Cetak: <?= date('d F Y') ?></p>
    </div>
    
    <button onclick="window.print()" style="margin-bottom:20px; padding: 10px; background:blue; color:white; border:none; cursor:pointer;">Cetak / Simpan ke PDF Sekarang</button>

    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($data[0] ?? []) as $header): ?>
                    <th><?= esc($header) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <?php foreach ($row as $col): ?>
                        <td><?= esc($col) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>