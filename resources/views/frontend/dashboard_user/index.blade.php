<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KEDAI MDP</title>
    <link rel="stylesheet" href="{{ asset('assets/css/userDashboardStyles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="left">
                <img src="assets/img/logo-kedai-mdp.svg" alt="Kedai Mdp" width="120" height="100">
            </div>
            <div class="center">
                <ul>
                    <li><a href="{{ route('frontend.dashboard_user.index') }}">Dashboard</a></li>
                    <li><a href="{{ route('frontend.menu_user.index') }}">Menu</a></li>
                    <li><a href="{{ route('frontend.cart_user.index') }}">Keranjang</a></li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li><a href="{{ route('auth.logout') }}">Log Out</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section class="dashboard">
            <h1>Dashboard</h1>
            <h2>MENU FAVORIT</h2>
            <div class="menu-favorit">
                <div class="card">
                    <img src="images/nasi_goreng.jpg" alt="Nasi Goreng">
                    <h2>Nasi Goreng</h2>
                </div>
                <div class="card">
                    <img src="menu_images/1714908948_nasi_ayam.jpg" alt="Nasi Ayam">
                    <h2>Nasi Ayam</h2>
                </div>
                <div class="card">
                    <img src="menu_images/1715661615_magelangan.jpg" alt="Magelangan">
                    <h2>Magelangan</h2>
                </div>
            </div>
            <div class="location">
                <h2>Penasaran dengan tempat kedainya? Mau tau tempatnya dimana?</h2>
                <p>Alamat kedai kita ada disini ya...</p>
                <p>Jl. Ukrim No.23, Cupuwatu I, Purwomartani,<br>
                    Kec. Kalasan, Kabupaten Sleman,<br>
                    Daerah Istimewa Yogyakarta 55571</p>
                <img src="{{ asset('assets/img/map_kedai_mdp.png') }}" alt="Map">
            </div>
            <div class="galeri">
                <h2>Galeri</h2>
                <div class="galeri-images">
                    @foreach ($galeri as $item)
                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->deskripsi }}">
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>Kedai Mdp</p>
            <p>Jl. Ukrim No.23, Cupuwatu I, Purwomartani,<br>
                Kec. Kalasan, Kabupaten Sleman,<br>
                Daerah Istimewa Yogyakarta 55571</p>
            <p id="contactTrigger" style="cursor: pointer; color: blue;">Contact</p>
        </div>
    </footer>

    <!-- Pop-up modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Informasi Kontak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="contactInfo"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactButton = document.getElementById('contactTrigger');
            const contactInfoContainer = document.getElementById('contactInfo');

            contactButton.addEventListener('click', function() {
                fetch("{{ route('contact.info') }}")
                    .then(response => response.json())
                    .then(data => {
                        contactInfoContainer.innerHTML = data.konten;
                        // Show the modal
                        var contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
                        contactModal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching contact info:', error);
                        contactInfoContainer.innerHTML = 'Error fetching contact info.';
                    });
            });
        });
    </script>

</body>

</html>
