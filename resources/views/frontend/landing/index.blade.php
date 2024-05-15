<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KEDAI MDP</title>
    <link rel="stylesheet" href="{{ asset('assets/css/landingStyles.css') }}">
</head>

<body>
    <header>
        <div class="logo-container">
            <h1><img src="{{ asset('menu_images/logo_kedai_mdp.jpg') }}" alt="Kedai Mdp"></h1>
        </div>
        <nav>
            <button id="logoutButton" class="nav-button">LOGOUT</button>
        </nav>
    </header>
    <main>
        <section class="content">
            <div class="text-container">
                <h1>Belanja Ga Pake Ribet, Tinggal Klik, Beres!</h1>
                <p>Ada menu apa aja sih di kedai kami? Ayo periksa sekarang juga!</p>
                <button id="buyNowButton">BELI SEKARANG</button>

            </div>
            <div class="image-container">
                <img src="{{ asset('menu_images/1715667118_nasi_goreng.jpg') }}" alt="Delicious food">
            </div>
        </section>
    </main>
    <script src="script.js"></script>

    <script>
        document.getElementById("logoutButton").addEventListener("click", function() {
            // Redirect to logout route
            window.location.href = "/login";
        });

        document.getElementById("buyNowButton").addEventListener("click", function() {
            // Redirect to dashboard_user/index.blade.php
            window.location.href = "{{ route('frontend.dashboard_user.index') }}";
        });
    </script>
</body>

</html>
