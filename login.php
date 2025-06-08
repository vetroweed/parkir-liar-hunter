<?php if (!isset($_SESSION)) session_start(); ?>

<div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md mx-auto">
    <div class="flex justify-center mb-4">
        <img src="img/logo1.png" alt="Logo Aplikasi" class="h-24 w-62">
    </div>

    <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login Hunters</h2>

    <form method="POST" novalidate>
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input id="username" name="username" type="text" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
        </div>
        <div class="mb-2 relative">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" name="password" type="password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 pr-10">
            <button type="button" onclick="togglePassword()"
                class="absolute right-2 top-9 text-gray-500 hover:text-primary text-sm">
                👁️
            </button>
        </div>

        <button type="submit" name="login"
            class="w-full bg-primary hover:bg-green-600 text-white font-semibold py-2 rounded-md mt-4">
            Login
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Belum punya akun?
        <button onclick="openModal('add-modal')" class="text-blue-600 hover:underline">Daftar di sini.</button>
    </p>
</div>

<!-- Modal Pendaftaran -->
<div id="add-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 transition-opacity" onclick="closeModal('add-modal')"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 z-10 w-full max-w-lg relative">
            <h3 class="text-xl font-semibold mb-4">Registrasi sebagai Masyarakat</h3>
            <form method="POST" class="space-y-4">
                <input type="number" name="nik" placeholder="NIK" required class="input-field">
                <input type="text" name="nama" placeholder="Nama" required class="input-field">
                <input type="text" name="username" placeholder="Username" required class="input-field">
                <input type="password" name="password" placeholder="Password" required class="input-field">
                <input type="number" name="telp" placeholder="Telp" required class="input-field">

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('add-modal')" class="btn-secondary">Batal</button>
                    <button type="submit" name="simpan" class="btn-primary">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .input-field {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.375rem;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: black;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
    }
</style>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function togglePassword() {
        const pwd = document.getElementById("password");
        pwd.type = (pwd.type === "password") ? "text" : "password";
    }
</script>

<?php
// Handle Registrasi
if (isset($_POST['simpan'])) {
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);

    $query = mysqli_query($koneksi, "INSERT INTO masyarakat(nik, nama, username, password, telp) VALUES ('$nik', '$nama', '$username', '$password', '$telp')");

    if ($query) {
        echo "<script>alert('Data berhasil disimpan. Silakan login.'); location.href='index.php?p=login';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data.');</script>";
    }
}
?>
