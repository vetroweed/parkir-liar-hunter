<div class="bg-white rounded-lg shadow p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h3 class="text-2xl font-semibold text-red-600 mb-4 md:mb-0">User</h3>
        <button onclick="openModal('add-user-modal')"
            class="flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
            <i class="fas fa-plus mr-2"></i> Tambah User
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="example" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telephone
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM petugas ORDER BY nama_petugas ASC");

                while ($r = mysqli_fetch_assoc($tampil)):
                    $levelClass = $r['level'] == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800';
                    ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $no++; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nama_petugas']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['username']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['telp_petugas']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full <?= $levelClass ?>">
                                <?= ucfirst($r['level']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <button onclick="openModal('edit-user-<?= $r['id_petugas'] ?>')"
                                class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <a href="index.php?p=user_hapus&id_petugas=<?= $r['id_petugas'] ?>"
                                onclick="return confirm('Anda Yakin Ingin Menghapus?')"
                                class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </td>
                    </tr>

                    <!-- Edit User Modal -->
                    <div id="edit-user-<?= $r['id_petugas'] ?>" class="fixed inset-0 z-50 hidden overflow-y-auto">
                        <div
                            class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>

                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit User</h3>
                                    <form method="POST" class="space-y-4">
                                        <input type="hidden" name="id_petugas" value="<?= $r['id_petugas']; ?>">

                                        <div>
                                            <label for="nama-<?= $r['id_petugas'] ?>"
                                                class="block text-sm font-medium text-gray-700">Nama</label>
                                            <input type="text" id="nama-<?= $r['id_petugas'] ?>" name="nama"
                                                value="<?= htmlspecialchars($r['nama_petugas']); ?>"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                        </div>

                                        <div>
                                            <label for="username-<?= $r['id_petugas'] ?>"
                                                class="block text-sm font-medium text-gray-700">Username</label>
                                            <input type="text" id="username-<?= $r['id_petugas'] ?>" name="username"
                                                value="<?= htmlspecialchars($r['username']); ?>"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                        </div>

                                        <div>
                                            <label for="telp-<?= $r['id_petugas'] ?>"
                                                class="block text-sm font-medium text-gray-700">Telephone</label>
                                            <input type="tel" id="telp-<?= $r['id_petugas'] ?>" name="telp"
                                                value="<?= htmlspecialchars($r['telp_petugas']); ?>"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Level</label>
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center">
                                                    <input id="admin-<?= $r['id_petugas'] ?>" name="level" type="radio"
                                                        value="admin"
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                        <?= $r['level'] == 'admin' ? 'checked' : '' ?>>
                                                    <label for="admin-<?= $r['id_petugas'] ?>"
                                                        class="ml-2 block text-sm text-gray-700">Admin</label>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="flex justify-end space-x-3">
                                            <button type="button" onclick="closeModal('edit-user-<?= $r['id_petugas'] ?>')"
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
                                    if (isset($_POST['Update'])) {
                                        $update = mysqli_query($koneksi, "UPDATE petugas SET 
                                        nama_petugas='" . $_POST['nama'] . "',
                                        username='" . $_POST['username'] . "',
                                        telp_petugas='" . $_POST['telp'] . "',
                                        level='" . $_POST['level'] . "' 
                                        WHERE id_petugas='" . $_POST['id_petugas'] . "'");

                                        if ($update) {
                                            echo "<script>
                                            alert('Data di Update');
                                            window.location.href = 'index.php?p=user';
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

<!-- Add User Modal -->
<div id="add-user-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah User</h3>
                <form method="POST" class="space-y-4">
                    <div>
                        <label for="add-nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="add-nama" name="nama"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="add-username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="add-username" name="username"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="add-password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="add-password" name="password"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="add-telp" class="block text-sm font-medium text-gray-700">Telephone</label>
                        <input type="tel" id="add-telp" name="telp"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="add-level" class="block text-sm font-medium text-gray-700">Level</label>
                        <select id="add-level" name="level"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="" disabled selected>Pilih Level</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('add-user-modal')"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit" name="input"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan
                        </button>
                    </div>
                </form>

                <?php
                if (isset($_POST['input'])) {
                    $password = md5($_POST['password']); // Kembalikan ke MD5
                
                    $query = mysqli_query($koneksi, "INSERT INTO petugas VALUES (
                        NULL,
                        '" . $_POST['nama'] . "',
                        '" . $_POST['username'] . "',
                        '" . $password . "',
                        '" . $_POST['telp'] . "',
                        '" . $_POST['level'] . "'
                    )");

                    if ($query) {
                        echo "<script>
                            alert('Data Ditambahkan');
                            window.location.href = 'index.php?p=user';
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

    // Initialize DataTables
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>