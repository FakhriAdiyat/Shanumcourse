<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran - Dana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-4">Metode Pembayaran</h3>
        <form action="process_payment.php" method="POST" enctype="multipart/form-data">
            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
            </div>

            <!-- Pilih Provinsi -->
            <div class="mb-3">
                <label for="province" class="form-label">Provinsi</label>
                <select class="form-select" id="province" name="province" required>
                    <option value="">Pilih Provinsi</option>
                    <option value="Jawa Tengah">Jawa Tengah</option>
                    <option value="Jawa Timur">Jawa Timur</option>
                    <option value="Jawa Barat">Jawa Barat</option>
                    <option value="DKI Jakarta">DKI Jakarta</option>
                    <option value="Bali">Bali</option>
                    <!-- Tambahkan opsi lainnya -->
                </select>
            </div>

            <!-- Pilihan Metode Pembayaran -->
            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <ul class="nav nav-tabs" id="paymentTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dana-tab" data-bs-toggle="tab" data-bs-target="#dana" type="button" role="tab" aria-controls="dana" aria-selected="true">
                            E-Wallet Dana
                        </button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="paymentTabContent">
                    <!-- Dana Form -->
                    <div class="tab-pane fade show active" id="dana" role="tabpanel" aria-labelledby="dana-tab">
                        <div class="mb-3">
                            <label for="dana_phone" class="form-label">Nomor Telepon Dana</label>
                            <input type="text" class="form-control" id="dana_phone" name="dana_phone" placeholder="Masukkan nomor telepon Dana" required>
                        </div>
                        <p class="text-muted">Pastikan nomor Dana Anda sudah terhubung dengan saldo yang cukup.</p>
                    </div>
                </div>
            </div>

            <!-- Dana Account Number for Transfer -->
            <div class="mb-3">
                <label for="dana_account_number" class="form-label">Nomor Dana untuk Transfer</label>
                <input type="text" class="form-control" id="dana_account_number" name="dana_account_number" value="081234567890" readonly>
                <p class="text-muted">Transfer pembayaran berlangganan ke nomor Dana ini.</p>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="mb-3">
                <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*,application/pdf" required>
                <p class="text-muted">Unggah bukti pembayaran berupa gambar atau file PDF.</p>
            </div>

            <!-- Total Harga -->
            <div class="mb-3">
                <h5>Total Hari Ini: <span class="text-success">Rp 1.293.375</span></h5>
            </div>

            <!-- Submit Button -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="agree" required>
                <label class="form-check-label" for="agree">
                    Saya setuju dengan syarat dan ketentuan.
                </label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Lanjutkan Pembayaran</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
