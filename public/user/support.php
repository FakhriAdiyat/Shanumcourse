<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: url('./../img/sp.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }
        header {
            background-color: rgba(0, 123, 255, 0.8);
            position: relative;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header img.logo {
            width: 100px;
            height: auto;
        }
        header nav {
            margin: 0;
        }
        header nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            position: relative;
        }
        header nav a:hover::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -3px;
            height: 2px;
            background-color: white;
            animation: underline-hover 0.3s ease-in-out forwards;
        }
        @keyframes underline-hover {
            from {
                width: 0;
                left: 50%;
            }
            to {
                width: 100%;
                left: 0;
            }
        }
        footer {
            background-color: rgba(0, 123, 255, 0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1rem;
        }
        footer img {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <header class="text-white">
        <img src="./../img/sc.png" alt="Logo" class="logo">
        <h1 class="mb-0">Hubungi Dukungan</h1>
        <nav>
            <a href="./../dashboard_user.php"><i class="fas fa-home"></i> Home</a>
        </nav>
    </header>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Formulir Dukungan</h2>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"> <?= $error ?> </div>
                        <?php endif; ?>

                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"> <?= $success ?> </div>
                        <?php endif; ?>

                        <form action="support.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan:</label>
                                <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-white">
        <div>
            <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
            <p>Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        </div>
        <img src="./../img/footer2.gif" alt="Footer GIF">
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
