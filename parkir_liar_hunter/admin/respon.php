<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-semibold text-red-600 mb-6">Telah di Validasi</h3>

    <div class="overflow-x-auto">
        <table id="example" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Ditanggapi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php 
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM pengaduan 
                                                INNER JOIN masyarakat ON pengaduan.nik=masyarakat.nik 
                                                INNER JOIN tanggapan ON pengaduan.id_pengaduan=tanggapan.id_pengaduan 
                                                INNER JOIN petugas ON tanggapan.id_petugas=petugas.id_petugas 
                                                ORDER BY tanggapan.id_pengaduan DESC");
                
                while ($r = mysqli_fetch_assoc($query)) : 
                    $statusClass = $r['status'] == 'selesai' ? 'bg-green-100 text-green-800' :
                        ($r['status'] == 'proses' ? 'bg-yellow-100 text-yellow-800' : 
                        ($r['status'] == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'));
                ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $no++; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nik']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nama']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nama_petugas']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $r['tgl_pengaduan']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $r['tgl_tanggapan']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full <?= $statusClass ?>"><?= $r['status']; ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                        <button onclick="openModal('modal-<?= $r['id_tanggapan'] ?>')" 
                                class="text-blue-600 hover:text-primary-900">
                    <i class="fas fa-info-circle"></i> Detail
                        </button>
                        <a href="index.php?p=tanggapan_hapus&id_tanggapan=<?= $r['id_tanggapan'] ?>" 
                           onclick="return confirm('Anda Yakin Ingin Menghapus?')"
                           class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash-alt"></i> Hapus
                        </a>
                    </td>
                </tr>

                <!-- Modal -->
                <div id="modal-<?= $r['id_tanggapan'] ?>" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-blue-600 mb-4">Detail Respon</h3>
                                <div class="space-y-3">
                                    <p><span class="font-semibold">NIK:</span> <?= htmlspecialchars($r['nik']); ?></p>
                                    <p><span class="font-semibold">Dari:</span> <?= htmlspecialchars($r['nama']); ?></p>
                                    <p><span class="font-semibold">Petugas:</span> <?= htmlspecialchars($r['nama_petugas']); ?></p>
                                    <p><span class="font-semibold">Tanggal Masuk:</span> <?= $r['tgl_pengaduan']; ?></p>
                                    <p><span class="font-semibold">Tanggal Ditanggapi:</span> <?= $r['tgl_tanggapan']; ?></p>
                                    
                                    <div>
                                        <span class="font-semibold">Foto:</span>
                                        <?php if($r['foto'] == "kosong" || empty($r['foto'])): ?>
                                            <img src="../img/noImage.png" width="150" class="mt-2 border rounded">
                                        <?php else: ?>
                                            <img width="150" src="../img/<?= htmlspecialchars($r['foto']); ?>" class="mt-2 border rounded">
                                        <?php endif; ?>
                                    </div>
                                    <p><span class="font-semibold">Lokasi: </span><?php echo htmlspecialchars($r['lokasi'] ?? '-'); ?></p>
                                    <?php if (!empty($r['lokasi'])): ?>
                                            <div>
                                                <iframe width="100%" height="200" frameborder="0" scrolling="no"
                                                    marginheight="0" marginwidth="0"
                                                    src="https://maps.google.com/maps?q=<?php echo urlencode($r['lokasi']); ?>&output=embed">
                                                </iframe>
                                            <?php endif; ?>
                                    <div>
                                        <span class="font-semibold">Pesan:</span>
                                        <p class="mt-1 p-2 bg-gray-50 rounded"><?= htmlspecialchars($r['isi_laporan']); ?></p>
                                    </div>
                                    
                                    <div>
                                        <span class="font-semibold">Respon:</span>
                                        <p class="mt-1 p-2 bg-gray-50 rounded"><?= htmlspecialchars($r['tanggapan']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" onclick="closeModal('modal-<?= $r['id_tanggapan'] ?>')" 
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
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
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>