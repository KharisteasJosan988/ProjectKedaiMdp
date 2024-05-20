<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Kedai Mdp</title>
    <link rel="stylesheet" href="{{ asset('assets/css/userCartStyles.css') }}">
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
                    <li><a href="{{ route('frontend.cart_user.index') }}">Keranjang</a></li>
                </ul>
            </div>
            <div class="right">
                <a href="{{ route('auth.logout') }}">Log Out</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="cart-container">
            <h1>Keranjang</h1>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Nama Menu</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item['nama_menu'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>Rp {{ number_format($item['harga'], 0) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">Total</td>
                        <td>Rp {{ number_format($totalPrice, 0) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="btn-container">
                <form action="{{ route('checkout') }}" method="POST" style="display: inline;">
                    @csrf
                    <div class="payment-method">
                        <label for="payment-method">Metode Pembayaran</label>
                        <select name="payment_method" id="payment-method">
                            <option value="QRIS">QRIS</option>
                            <option value="CASH">CASH</option>
                        </select>
                    </div>
                    <div id="total-price">Total Harga: Rp {{ number_format($totalPrice, 0) }}</div>
                    <!-- Menampilkan total harga -->
                    <a href="{{ route('frontend.menu_user.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn-pay">Bayar</button>
                </form>
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
</body>

</html>
