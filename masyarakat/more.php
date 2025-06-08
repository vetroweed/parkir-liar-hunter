<div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
  <?php
  if (isset($_GET['apa']) && $_GET['apa'] == "pengaduan") {
    $id_pengaduan = mysqli_real_escape_string($koneksi, $_GET['id_pengaduan']);
    $query = mysqli_query($koneksi, "SELECT * FROM pengaduan 
              INNER JOIN masyarakat ON pengaduan.nik=masyarakat.nik 
              WHERE id_pengaduan='$id_pengaduan'");

    if (mysqli_num_rows($query) > 0) {
      $r = mysqli_fetch_assoc($query);
      ?>
      <h2 class="text-xl font-semibold mb-4">Detail Laporan</h2>
      <div class="space-y-4">
        <p class="text-sm text-gray-600"><span class="font-medium">Dilaporkan pada:</span>
          <?php echo htmlspecialchars($r['tgl_pengaduan']); ?></p>

        <div>
          <?php if ($r['foto'] == "kosong" || empty($r['foto'])) { ?>
            <img src="../img/noImage.png" width="200" class="rounded-md border border-gray-200">
          <?php } else { ?>
            <img width="200" src="../img/<?php echo htmlspecialchars($r['foto']); ?>"
              class="rounded-md border border-gray-200">
          <?php } ?>
        </div>

        <div>
          <p class="font-medium">Isi Laporan:</p>
          <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($r['isi_laporan'])); ?></p>
        </div>

        <div>
          <span class="px-2 py-1 text-xs font-semibold rounded-full 
          <?php echo $r['status'] == 'selesai' ? 'bg-green-100 text-green-800' :
            ($r['status'] == 'proses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'); ?>">
            Status: <?php echo htmlspecialchars(ucfirst($r['status'])); ?>
          </span>
        </div>
      </div>

    <?php
    } else {
      echo "<p class='text-red-500'>Data tidak ditemukan</p>";
    }
  } elseif (isset($_GET['apa']) && $_GET['apa'] == "tanggapan") {
    $id_pengaduan = mysqli_real_escape_string($koneksi, $_GET['id_pengaduan']);
    $query = mysqli_query($koneksi, "SELECT * FROM pengaduan 
              INNER JOIN masyarakat ON pengaduan.nik=masyarakat.nik 
              INNER JOIN tanggapan ON pengaduan.id_pengaduan=tanggapan.id_pengaduan 
              INNER JOIN petugas ON tanggapan.id_petugas=petugas.id_petugas 
              WHERE tanggapan.id_pengaduan='$id_pengaduan'");

    if (mysqli_num_rows($query) > 0) {
      $r = mysqli_fetch_assoc($query);
      ?>
      <h2 class="text-xl font-semibold mb-4">Detail Tanggapan</h2>
      <div class="space-y-4">
        <p class="font-medium">Petugas: <?php echo htmlspecialchars($r['nama_petugas']); ?></p>
        <p class="text-sm text-gray-600"><span class="font-medium">Ditanggapi pada:</span>
          <?php echo htmlspecialchars($r['tgl_tanggapan']); ?></p>

        <div>
          <?php if ($r['foto'] == "kosong" || empty($r['foto'])) { ?>
            <img src="../img/noImage.png" width="200" class="rounded-md border border-gray-200">
          <?php } else { ?>
            <img width="200" src="../img/<?php echo htmlspecialchars($r['foto']); ?>"
              class="rounded-md border border-gray-200">
          <?php } ?>
        </div>

        <div>
          <p class="font-medium">Isi Laporan:</p>
          <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($r['isi_laporan'])); ?></p>
        </div>

        <div>
          <p class="font-medium">Tanggapan:</p>
          <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($r['tanggapan'])); ?></p>
        </div>

        <div>
          <span class="px-2 py-1 text-xs font-semibold rounded-full 
          <?php echo $r['status'] == 'selesai' ? 'bg-green-100 text-green-800' :
            ($r['status'] == 'proses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'); ?>">
            Status: <?php echo htmlspecialchars(ucfirst($r['status'])); ?>
          </span>
        </div>
      </div>
    <?php
    } else {
      echo "<p class='text-red-500'>Data tidak ditemukan</p>";
    }
  }
  ?>

  <div class="mt-6">
    <a href="index.php?p=dashboard"
      class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
      Kembali ke Dashboard
    </a>
  </div>
</div>