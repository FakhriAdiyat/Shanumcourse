<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 1.8rem;
        }
        .payment-method {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .payment-method p {
            margin: 0;
            font-size: 1rem;
        }
        .btn {
            display: inline-block;
            background-color: #e50914;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 1rem;
        }
        .btn:hover {
            background-color: #d40813;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pilih Metode Pembayaran</h1>
        <form action="payment_confirmation.php" method="POST">
            <!-- Paket yang dipilih dikirimkan melalui input hidden -->
            <input type="hidden" name="package" value="<?php echo htmlspecialchars($_POST['package']); ?>">

            <div class="payment-method">
                <p>OVO</p>
                <input type="radio" name="payment_method" value="ovo" required>
            </div>
            <div class="payment-method">
                <p>GoPay</p>
                <input type="radio" name="payment_method" value="gopay" required>
            </div>
            <div class="payment-method">
                <p>DANA</p>
                <input type="radio" name="payment_method" value="dana" required>
            </div>
            <div class="payment-method">
                <p>ShopeePay</p>
                <input type="radio" name="payment_method" value="shopeepay" required>
            </div>
            <button type="submit" class="btn">Konfirmasi Pembayaran</button>
        </form>
    </div>
</body>
</html>
