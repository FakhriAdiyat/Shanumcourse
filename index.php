<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shanum Course Kursus Online</title>
    <link rel="stylesheet" href="public/css/landingpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <header class="main-header">
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="public/img/sc.png" alt="Logo MyApp" width="150">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public/about.php"><i class="fas fa-info-circle"></i> About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public/services.php"><i class="fas fa-cogs"></i> Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public/contact.php"><i class="fas fa-envelope"></i> Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="public/register.php"><i class="fas fa-user-plus"></i> Register</a>
                        </li>
                    </ul>
                    <!-- <form class="d-flex search-form" action="search.php" method="GET">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search..." aria-label="Search" required>
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form> -->
                </div>
            </div>
        </nav>
        <div class="hero-section">
            <h1>Welcome to Shanum Course</h1>
            <p>Ayo Terhubung Dengan Seluruh Dunia Dengan Belajar Bahasa Inggris!</p><br>
            <a href="public/register.php" class="btn-primary">Get Started</a>
        </div>
    </header>

        <section class="container">
            <div class="slider-wrapper">
                <div class="slider">
                    <img id="slide-1" src="public/img/image-1.jpg" alt="kid reading a book" />
                    <img id="slide-2" src="public/img/image-2.jpg" alt="kid studying" />
                    <img id="slide-3" src="public/img/image-3.jpg" alt="kid lifting a book" />
                </div>
                <div class="slider-nav">
                    <a href="#slide-1"></a>
                    <a href="#slide-2"></a>
                    <a href="#slide-3"></a>
                </div>
            </div>
        </section>
    
        <section class="recommended-section">
            <h2>Sangat Direkomendasikan Untuk:</h2>
            <ul>
                <li><img src="public/img/gambar-ilustrasi-siswa.png" alt="Icon Pelajar">Anak yang ingin mempelajari dasar-dasar bahasa Inggris dengan cara yang menyenangkan</li>
                <li><img src="public/img/orang tua.jpg" alt="Icon Orang Tua">Orang tua yang ingin memberikan bekal bahasa Inggris untuk anak-anak mereka</li>
            </ul>
        </section>
    
        <section class="reviews-section">
            <h2>Ulasan</h2>
            <div class="review">
                <img src="public/img/rv1.jpg" alt="Reviewer 1">
                <div class="rating">
            ★★★★☆
        </div>
                <p>"Platform ini benar-benar membantu anak saya meningkatkan kemampuan bahasa Inggris dengan cepat!"</p>
                <span>- Anita</span>
            </div>
            <div class="review">
                <img src="public/img/rv2.jpg" alt="Reviewer 2">
                <div class="rating">
            ★★★★★
        </div>
                <p>"Sangat mudah digunakan, dan fitur manajemen pengguna sangat berguna."</p>
                <span>- Budi</span>
            </div>
            <div class="review">
                <img src="public/img/rv3.jpg" alt="Reviewer 3">
                <div class="rating">
            ★★★★☆
        </div>
                <p>"Program ini membuat belajar bahasa Inggris menjadi menyenangkan dan efektif!"</p>
                <span>- Carli</span>
            </div>
        </section>
    
        <section class="benefits-section">
            <h2>Keuntungan Menggunakan Shanum Course</h2>
            <ul>
                <li><img src="public/img/24.png" alt="Icon Akses 24/7"><strong>Akses 24/7:</strong>Belajar kapan saja dan di mana saja</li>
                <li><img src="public/img/qt.png" alt="Icon Konten Berkualitas"><strong>Konten Berkualitas:</strong> Materi yang disusun oleh para ahli</li>
                <li><img src="public/img/rp.png" alt="Icon Harga Terjangkau"><strong>Harga Terjangkau:</strong> Dapatkan pembelajaran dengan harga kompetitif</li>
                <li><img src="public/img/dpe.png" alt="Icon Dukungan Pelanggan"><strong>Dukungan Pelanggan:</strong> Tim kami siap membantu Anda kapan saja</li>
            </ul>
        </section>

        <section class="image-banner">
            <img src="public/img/banner.jpg" alt="Banner Image" class="center-banner">
        </section>

        <footer class="main-footer">
            <div class="footer-content">
                <div class="contact-info">
                    <p><i class="fas fa-phone"></i> Contact us:</p>
                    <p>support@shanumcourse.com | +62 899-XXX-XXXX</p><br>
                </div>
                <div class="footer-text">
                    <p>© 2024 Shanum Course Team. All rights reserved.</p>
                </div>
            </div>

            <div class="social-icons">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-linkedin-in"></i>
                <i class="fab fa-dribbble"></i>
            </div>

            <img src="public/img/footer.gif" alt="Footer GIF">
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
