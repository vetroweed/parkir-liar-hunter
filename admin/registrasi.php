<div class="bg-white rounded-lg shadow p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h3 class="text-2xl font-semibold text-red-600 mb-4 md:mb-0">Masyarakat</h3>
        <button onclick="openModal('add-modal')"
            class="flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
            <i class="fas fa-plus mr-2"></i> Tambah Masyarakat
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="example" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM masyarakat ORDER BY nik ASC");

                while ($r = mysqli_fetch_assoc($query)):
                    ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $no++; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nik']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nama']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['username']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['telp']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <button onclick="openModal('edit-modal-<?= $r['nik'] ?>')"
                                class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <a href="index.php?p=regis_hapus&nik=<?= $r['nik'] ?>"
                                onclick="return confirm('Anda Yakin Ingin Menghapus?')"
                                class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div id="edit-modal-<?= $r['nik'] ?>" class="fixed inset-0 z-50 hidden overflow-y-auto">
                        <div
                            class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>

                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Masyarakat</h3>
                                    <form method="POST" class="space-y-4">
                                        <div>
                                            <label for="nik-<?= $r['nik'] ?>"
                                                class="block text-sm font-medium text-gray-700">NIK</label>
                                            <input type="number" id="nik-<?= $r['nik'] ?>" name="nik"
                                                value="<?= htmlspecialchars($r['nik']); ?>"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="nama-<?= $r['nik'] ?>"
                                                class="block text-sm font-medium text-gray-700">Nama</label>
                                            <input type="text" id="nama-<?= $r['nik'] ?>" name="nama"
                                                value="<?= htmlspecialchars($r['nama']); ?>"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="username-<?= $r['nik'] ?>"
                                                class="block text-sm font-medium text-gray-700">Username</label>
                                            <input type="text" id="username-<?= $r['nik'] ?>" name="username"
                                                value="<?= htmlspecialchars($r['username']); ?>"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="telp-<?= $r['nik'] ?>"
                                                class="block text-sm font-medium text-gray-700">Telp</label>
                                            <input type="number" id="telp-<?= $r['nik'] ?>" name="telp"
                                                value="<?= htmlspecialchars($r['telp']); ?>"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <input type="hidden" name="old_nik" value="<?= $r['nik']; ?>">
                                        <div class="flex justify-end space-x-3">
                                            <button type="button" onclick="closeModal('edit-modal-<?= $r['nik'] ?>')"
                                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Batal
                                            </button>
                                            <button type="submit" name="Update"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['Update']) && $_POST['old_nik'] == $r['nik']) {
                                        $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
                                        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
                                        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
                                        $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
                                        $old_nik = mysqli_real_escape_string($koneksi, $_POST['old_nik']);

                                        $update = mysqli_query($koneksi, "UPDATE masyarakat SET nik='$nik', nama='$nama', username='$username', telp='$telp' WHERE nik='$old_nik'");

                                        if ($update) {
                                            echo "<script>
                                                alert('Data Tersimpan');
                                                window.location.href = 'index.php?p=registrasi';
                                              </script>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div id="add-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Masyarakat</h3>
                <form method="POST" class="space-y-4">
                    <div>
                        <label for="add-nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="number" id="add-nik" name="nik" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="add-nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="add-nama" name="nama" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="add-username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="add-username" name="username" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="add-password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="add-password" name="password" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="add-telp" class="block text-sm font-medium text-gray-700">Telp</label>
                        <input type="number" id="add-telp" name="telp" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('add-modal')"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit" name="simpan"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan
                        </button>
                    </div>
                </form>

                <?php
                if (isset($_POST['simpan'])) {
                    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
                    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
                    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
                    $password = md5($_POST['password']);
                    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);

                    $query = mysqli_query($koneksi, "INSERT INTO masyarakat VALUES ('$nik', '$nama', '$username', '$password', '$telp')");

                    if ($query) {
                        echo "<script>
                                alert('Data Tersimpan');
                                window.location.href = 'index.php?p=registrasi';
                              </script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>