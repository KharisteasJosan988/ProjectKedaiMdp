<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - KEDAI MDP</title>
    <link rel="stylesheet" href="{{ asset('assets/css/UserMenuStyles.css') }}">
</head>

<body>
    <header>
        <nav>
            <div class="left">
                <img src="{{ asset('assets/img/logo-kedai-mdp.svg') }}" alt="Kedai Mdp" width="120" height="100">
            </div>
            <div class="center">
                <ul>
                    <li><a href="{{ route('frontend.dashboard_user.index') }}">Dashboard</a></li>
                    <li><a href="{{ route('frontend.menu_user.index') }}">Menu</a></li>
                    <li><a href="{{route('frontend.cart_user.index')}}">Keranjang</a></li>
                </ul>
            </div>
            <div class="right">
                <a href="{{ route('auth.logout') }}">Log Out</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="dashboard">
            <h1>Menu</h1>
            <div class="menu-favorit">
                @foreach ($menus as $menu)
                    <div class="card">
                        <img src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama }}">
                        <h2>{{ $menu->nama }}</h2>
                        <p>Rp {{ number_format($menu->harga, 0) }}</p>
                        <div class="quantity">
                            <label for="quantity_{{ $menu->id }}">Jumlah:</label>
                            <input type="number" id="quantity_{{ $menu->id }}"
                                name="quantity_{{ $menu->id }}" class="quantity-input"
                                data-id="{{ $menu->id }}" data-name="{{ $menu->nama }}"
                                data-price="{{ $menu->harga }}" min="0" max="10" value="0">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="total-section" id="total-section" style="display: none;" onclick="redirectToCart()">
                <h2>Total</h2>
                <div id="total-items"></div>
                <p id="total-price"></p>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>Kedai Mdp</p>
            <p>Jl. Ukrim No.23, Cupuwatu I, Purwomartani,<br>
                Kec. Kalasan, Kabupaten Sleman,<br>
                Daerah Istimewa Yogyakarta 55571</p>
            <p>Contact</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const totalSection = document.getElementById('total-section');
            const totalItems = document.getElementById('total-items');
            const totalPrice = document.getElementById('total-price');

            const updateTotal = () => {
                let items = [];
                let totalQuantity = 0;
                let totalPriceValue = 0;

                quantityInputs.forEach(input => {
                    const quantity = parseInt(input.value);
                    const name = input.getAttribute('data-name');
                    const price = parseInt(input.getAttribute('data-price'));

                    if (quantity > 0) {
                        items.push(`${name}: ${quantity}`);
                        totalQuantity += quantity;
                        totalPriceValue += quantity * price;
                    }
                });

                if (totalQuantity > 0) {
                    totalItems.innerHTML = `${totalQuantity} ITEM<br>` + items.join('<br>');
                    totalPrice.innerHTML = `Rp ${totalPriceValue.toLocaleString()}`;
                    totalSection.style.display = 'block';
                } else {
                    totalSection.style.display = 'none';
                }
            };

            quantityInputs.forEach(input => {
                input.addEventListener('input', updateTotal);
            });
        });

        function redirectToCart() {
            window.location.href = "{{route('frontend.cart_user.index')}}";
        }
    </script>
</body>

</html>
