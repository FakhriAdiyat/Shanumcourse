<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
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
        .details {
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .details p {
            margin: 5px 0;
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
            width: 100%;
            box-sizing: border-box;
        }
        .btn:hover {
            background-color: #d40813;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Konfirmasi Pembayaran</h1>
        <div class="details">
            <p><strong>Paket:</strong> <?php echo htmlspecialchars($_POST['package']); ?></p>
            <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($_POST['payment_method']); ?></p>
            <p><strong>Total:</strong> Rp 54.000/bulan</p>
        </div>
        <a href="process_payment.php" class="btn">Mulai Keanggotaan</a>
    </div>
</body>
</html>
