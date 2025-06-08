<div class="bg-white rounded-lg shadow p-6">
	<h3 class="text-2xl font-semibold text-red-600 mb-6">Dashboard</h3>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
		<!-- Total Reports Card -->
		<div class="bg-blue-500 rounded-lg shadow-md overflow-hidden">
			<div class="p-6 text-white">
				<?php
				$query = mysqli_query($koneksi, "SELECT * FROM pengaduan");
				$totalReports = mysqli_num_rows($query);
				?>
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm font-medium">Total Laporan</p>
						<h3 class="text-2xl font-bold"><?= $totalReports ?: 0; ?></h3>
					</div>
					<i class="fas fa-file-alt text-3xl opacity-50"></i>
				</div>
				<div class="mt-4">
					<a href="index.php?p=pengaduan" class="text-xs font-medium hover:underline">Lihat Semua →</a>
				</div>
			</div>
		</div>
		<div class="bg-yellow-500 rounded-lg shadow-md overflow-hidden">
			<div class="p-6 text-white">
				<?php
				$query = mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE status='proses'");
				$progressReports = mysqli_num_rows($query);
				?>
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm font-medium">Dalam Proses</p>
						<h3 class="text-2xl font-bold"><?= $progressReports ?: 0; ?></h3>
					</div>
					<i class="fas fa-spinner text-3xl opacity-50"></i>
				</div>
				<div class="mt-4">
					<a href="index.php?p=respon" class="text-xs font-medium hover:underline">Tanggapi Sekarang →</a>
				</div>
			</div>
		</div>
		<!-- Completed Reports Card -->
		<div class="bg-teal-500 rounded-lg shadow-md overflow-hidden">
			<div class="p-6 text-white">
				<?php
				$query = mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE status='selesai'");
				$completedReports = mysqli_num_rows($query);
				?>
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm font-medium">Laporan Selesai</p>
						<h3 class="text-2xl font-bold"><?= $completedReports ?: 0; ?></h3>
					</div>
					<i class="fas fa-check-circle text-3xl opacity-50"></i>
				</div>
				<div class="mt-4">
					<a href="index.php?p=pengaduan" class="text-xs font-medium hover:underline">Lihat Detail →</a>
				</div>
			</div>
		</div>

		<div class="bg-red-500 rounded-lg shadow-md overflow-hidden">
			<div class="p-6 text-white">
				<?php
				$query = mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE status='ditolak'");
				$completedReports2 = mysqli_num_rows($query);
				?>
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm font-medium">Laporan Ditolak</p>
						<h3 class="text-2xl font-bold"><?= $completedReports2 ?: 0; ?></h3>
					</div>
					<i class="fas fa-times-circle text-3xl opacity-50"></i>
				</div>
				<div class="mt-4">
					<a href="index.php?p=pengaduan" class="text-xs font-medium hover:underline">Lihat Detail →</a>
				</div>
			</div>
		</div>
		<!-- In Progress Reports Card -->


	</div>


	<!-- Recent Reports Section -->
	<div class="bg-white rounded-lg shadow p-6 mb-8">
		<div class="flex justify-between items-center mb-4">
			<h4 class="text-lg font-semibold text-gray-800">Laporan Terbaru</h4>
			<a href="index.php?p=pengaduan" class="text-sm text-blue-500 hover:underline">Lihat Semua</a>
		</div>

		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Tanggal</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Status</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					<?php
					$no = 1;
					$query = mysqli_query($koneksi, "SELECT p.*, m.nama 
                                                    FROM pengaduan p 
                                                    INNER JOIN masyarakat m ON p.nik = m.nik 
                                                    ORDER BY p.tgl_pengaduan DESC 
                                                    LIMIT 5");

					while ($r = mysqli_fetch_assoc($query)):
						$statusClass = $r['status'] == 'selesai' ? 'bg-green-100 text-green-800' :
							($r['status'] == 'proses' ? 'bg-yellow-100 text-yellow-800' :
								($r['status'] == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'));
						?>
						<tr class="hover:bg-gray-50">
							<td class="px-6 py-4 whitespace-nowrap"><?= $no++; ?></td>
							<td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nik']); ?></td>
							<td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['nama']); ?></td>
							<td class="px-6 py-4 whitespace-nowrap"><?= $r['tgl_pengaduan']; ?></td>
							<td class="px-6 py-4 whitespace-nowrap">
								<span class="px-2 py-1 text-xs rounded-full <?= $statusClass ?>">
									<?= ucfirst($r['status']); ?>
								</span>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Statistics Chart Section -->
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
		<!-- Monthly Reports Chart -->
		<div class="bg-white rounded-lg shadow p-6">
			<h4 class="text-lg font-semibold text-gray-800 mb-4">Laporan Bulan Ini</h4>
			<div class="h-64">
				<?php
				// Get current month and year
				$currentMonth = date('m');
				$currentYear = date('Y');

				// Query to get reports count for each day in current month
				$query = mysqli_query($koneksi, "SELECT DAY(tgl_pengaduan) as day, COUNT(*) as count 
                                                FROM pengaduan 
                                                WHERE MONTH(tgl_pengaduan) = $currentMonth 
                                                AND YEAR(tgl_pengaduan) = $currentYear 
                                                GROUP BY DAY(tgl_pengaduan)");

				$reportData = array_fill(1, date('t'), 0); // Initialize array with 0s for each day
				
				while ($row = mysqli_fetch_assoc($query)) {
					$reportData[$row['day']] = $row['count'];
				}
				?>
				<canvas id="monthlyReportsChart"></canvas>
			</div>
		</div>

		<!-- Status Distribution Chart -->
		<div class="bg-white rounded-lg shadow p-6">
			<h4 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Status Laporan</h4>
			<div class="h-64">
				<?php
				$query = mysqli_query($koneksi, "SELECT status, COUNT(*) as count FROM pengaduan GROUP BY status");
				$statusData = [];
				$statusLabels = [];
				$statusColors = [];

				while ($row = mysqli_fetch_assoc($query)) {
					$statusLabels[] = ucfirst($row['status']);
					$statusData[] = $row['count'];

					// Set colors based on status
					if ($row['status'] == 'selesai') {
						$statusColors[] = '#4ade80'; // green
					} elseif ($row['status'] == 'proses') {
						$statusColors[] = '#fbbf24'; // yellow
					} else {
						$statusColors[] = '#FF0000'; // gray
					}
				}
				?>
				<canvas id="statusDistributionChart"></canvas>
			</div>
		</div>
	</div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	// Monthly Reports Chart
	const monthlyCtx = document.getElementById('monthlyReportsChart').getContext('2d');
	const monthlyChart = new Chart(monthlyCtx, {
		type: 'bar',
		data: {
			labels: <?= json_encode(range(1, date('t'))); ?>,
			datasets: [{
				label: 'Jumlah Laporan',
				data: <?= json_encode(array_values($reportData)); ?>,
				backgroundColor: 'rgba(249, 115, 22, 0.7)', // orange
				borderColor: 'rgba(249, 115, 22, 1)',
				borderWidth: 1
			}]
		},
		options: {
			responsive: true,
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						stepSize: 1
					}
				}
			}
		}
	});

	// Status Distribution Chart
	const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
	const statusChart = new Chart(statusCtx, {
		type: 'doughnut',
		data: {
			labels: <?= json_encode($statusLabels); ?>,
			datasets: [{
				data: <?= json_encode($statusData); ?>,
				backgroundColor: <?= json_encode($statusColors); ?>,
				borderWidth: 1
			}]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'bottom',
				}
			}
		}
	});
</script>