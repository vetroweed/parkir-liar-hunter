<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <!-- Tulis Laporan -->
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-red-600 mb-4">Tulis Laporan</h2>
    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label for="laporan" class="block text-sm font-medium text-gray-700 mb-1">Isi Laporan</label>
        <textarea id="laporan" name="laporan" rows="4"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
          placeholder="Tulis Laporan Anda"></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
        <div class="mt-1 flex items-center">
          <input type="file" name="foto" class="py-2 px-3 border border-gray-300 rounded-md text-sm">
        </div>
        <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, JPEG (Maks. 100KB)</p>
      </div>
      <div>
        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kejadian</label>
        <input type="text" id="lokasi" name="lokasi" 
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
          placeholder="Masukkan lokasi kejadian">
      </div>
      <div>
        <button type="button" onclick="getCurrentLocation()" 
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 mb-2">
          <i class="fas fa-map-marker-alt mr-2"></i> Gunakan Lokasi Saat Ini
        </button>
        <div id="locationStatus" class="text-sm text-gray-500"></div>
      </div>
      <div>
        <button type="submit" name="kirim"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Kirim Laporan
        </button>
      </div>
    </form>
  </div>

  <!-- Daftar Laporan -->
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
      <h2 class="text-xl font-semibold text-red-600 mb-4">Daftar Laporan</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php
            $no = 1;
            $nik = mysqli_real_escape_string($koneksi, $_SESSION['data']['nik']);
            $pengaduan = mysqli_query($koneksi, "SELECT * FROM pengaduan 
              INNER JOIN masyarakat ON pengaduan.nik=masyarakat.nik 
              LEFT JOIN tanggapan ON pengaduan.id_pengaduan=tanggapan.id_pengaduan 
              WHERE pengaduan.nik='$nik' 
              ORDER BY pengaduan.id_pengaduan DESC");

            while ($r = mysqli_fetch_assoc($pengaduan)) {
              $statusClass = $r['status'] == 'selesai' ? 'bg-green-100 text-green-800' :
                        ($r['status'] == 'proses' ? 'bg-yellow-100 text-yellow-800' : 
                        ($r['status'] == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'));
              ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $no++; ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($r['nik']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($r['nama']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($r['tgl_pengaduan']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($r['lokasi'] ?? '-'); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClass; ?>">
                    <?php echo htmlspecialchars(ucfirst($r['status'])); ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <button onclick="openModal('modal-<?php echo $r['id_pengaduan']; ?>')"
                    class="text-primary-600 hover:text-primary-900">
                    <i class="fas fa-info-circle"></i> Detail
                  </button>
                  <a href="index.php?p=pengaduan_hapus&id_pengaduan=<?php echo $r['id_pengaduan']; ?>"
                    onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash-alt"></i> Hapus
                  </a>
                </td>
              </tr>

              <!-- Modal -->
              <div id="modal-<?php echo $r['id_pengaduan']; ?>" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                  <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                  </div>
                  <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                  <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Detail Laporan</h3>
                      <div class="space-y-4">
                        <div>
                          <p class="text-sm text-gray-500">NIK: <?php echo htmlspecialchars($r['nik']); ?></p>
                          <p class="text-sm text-gray-500">Dari: <?php echo htmlspecialchars($r['nama']); ?></p>
                          <?php if (!empty($r['nama_petugas'])): ?>
                            <p class="text-sm text-gray-500">Petugas: <?php echo htmlspecialchars($r['nama_petugas']); ?></p>
                          <?php endif; ?>
                          <p class="text-sm text-gray-500">Tanggal Masuk: <?php echo htmlspecialchars($r['tgl_pengaduan']); ?></p>
                          <p class="text-sm text-gray-500">Lokasi: <?php echo htmlspecialchars($r['lokasi'] ?? '-'); ?></p>
                          <?php if (!empty($r['tgl_tanggapan'])): ?>
                            <p class="text-sm text-gray-500">Tanggal Ditanggapi: <?php echo htmlspecialchars($r['tgl_tanggapan']); ?></p>
                          <?php endif; ?>
                        </div>
                        <?php if (!empty($r['lokasi'])): ?>
                          <div>
                            <iframe 
                              width="100%" 
                              height="200" 
                              frameborder="0" 
                              scrolling="no" 
                              marginheight="0" 
                              marginwidth="0" 
                              src="https://maps.google.com/maps?q=<?php echo urlencode($r['lokasi']); ?>&output=embed">
                            </iframe>
                          </div>
                        <?php endif; ?>
                        <div>
                          <?php if ($r['foto'] == "kosong" || empty($r['foto'])): ?>
                            <img src="../img/noImage.png" width="200" class="rounded-md border border-gray-200">
                          <?php else: ?>
                            <img width="200" src="../img/<?php echo htmlspecialchars($r['foto']); ?>"
                              class="rounded-md border border-gray-200">
                          <?php endif; ?>
                        </div>
                        <div>
                          <p class="font-medium">Isi Laporan:</p>
                          <p class="text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($r['isi_laporan'])); ?></p>
                        </div>
                        <?php if (!empty($r['tanggapan'])): ?>
                          <div>
                            <p class="font-medium">Tanggapan:</p>
                            <p class="text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($r['tanggapan'])); ?></p>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                      <button type="button" onclick="closeModal('modal-<?php echo $r['id_pengaduan']; ?>')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['kirim'])) {
  $nik = $_SESSION['data']['nik'];
  $tgl = date('Y-m-d');
  $laporan = mysqli_real_escape_string($koneksi, trim($_POST['laporan']));
  $lokasi = mysqli_real_escape_string($koneksi, trim($_POST['lokasi'] ?? ''));

  // Validasi input kosong
  if (empty($laporan)) {
    echo "<script>alert('Isi laporan tidak boleh kosong')</script>";
    echo "<script>location='index.php';</script>";
    exit();
  }

  // Proses upload gambar jika ada
  if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === 0) {
    $foto = $_FILES['foto']['name'];
    $source = $_FILES['foto']['tmp_name'];
    $folder = '../img/';
    $listeks = ['jpg', 'jpeg', 'png'];
    $pecah = explode('.', $foto);
    $eks = strtolower(end($pecah));
    $size = $_FILES['foto']['size'];
    $namaBaru = date('dmYHis') . '.' . $eks;

    if (in_array($eks, $listeks)) {
      if ($size <= 100000) { // max 100KB
        if (move_uploaded_file($source, $folder . $namaBaru)) {
          $query = mysqli_query($koneksi, "INSERT INTO pengaduan VALUES (
            NULL, '$tgl', '$nik', '$laporan', '$namaBaru', '$lokasi', 'proses')");

          if ($query) {
            echo "<script>alert('Pengaduan berhasil dikirim dan akan segera diproses'); location='index.php';</script>";
            exit();
          } else {
            echo "<script>alert('Gagal menyimpan data laporan')</script>";
          }
        } else {
          echo "<script>alert('Gagal mengunggah gambar')</script>";
        }
      } else {
        echo "<script>alert('Ukuran file maksimal 100KB')</script>";
      }
    } else {
      echo "<script>alert('Format file harus JPG, JPEG, atau PNG')</script>";
    }
  } else {
    // Jika tidak ada gambar, masukkan nilai default 'kosong'
    $query = mysqli_query($koneksi, "INSERT INTO pengaduan VALUES (
      NULL, '$tgl', '$nik', '$laporan', 'kosong', '$lokasi', 'proses')");

    if ($query) {
      echo "<script>alert('Pengaduan berhasil dikirim dan akan segera diproses'); location='index.php';</script>";
      exit();
    } else {
      echo "<script>alert('Gagal menyimpan laporan')</script>";
    }
  }
}
?>


<script>
  function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
  }

  function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
  }

  function getCurrentLocation() {
    const locationInput = document.getElementById('lokasi');
    const locationStatus = document.getElementById('locationStatus');
    
    locationStatus.textContent = "Mendapatkan lokasi...";
    
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;
          
          // Use Nominatim API to reverse geocode
          fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
            .then(response => response.json())
            .then(data => {
              const address = data.display_name || `${latitude}, ${longitude}`;
              locationInput.value = address;
              locationStatus.textContent = "Lokasi berhasil diperoleh";
            })
            .catch(error => {
              locationInput.value = `${latitude}, ${longitude}`;
              locationStatus.textContent = "Lokasi koordinat diperoleh (alamat tidak ditemukan)";
              console.error("Error getting address:", error);
            });
        },
        (error) => {
          locationStatus.textContent = "Gagal mendapatkan lokasi: " + error.message;
          console.error("Geolocation error:", error);
        }
      );
    } else {
      locationStatus.textContent = "Geolocation tidak didukung oleh browser Anda";
    }
  }
</script>