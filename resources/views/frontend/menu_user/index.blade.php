<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - KEDAI MDP</title>
    <link rel="stylesheet" href="{{ asset('assets/css/UserMenuStyles.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include Sweet Alert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <section class="dashboard">
            <h1>Menu</h1>
            <div class="menu-favorit">
                @foreach ($menus as $menu)
                    <div class="card">
                        <img src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama }}">
                        <h2>{{ $menu->nama }}</h2>
                        <p>Rp {{ number_format($menu->harga, 0) }}</p>
                        <div class="quantity">
                            <label for="quantity">Jumlah:</label>
                            <input type="number" data-idmenu="{{ $menu->id }}" class="quantitymenu" min="0"
                                max="10" value="{{ session('cart.' . $menu->id . '.qty', 0) }}">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="total-section" id="total-section" style="display: none;" onclick="redirectToCart()">
                <h2>Total</h2>
                <div id="total-items"></div>
                <p id="total-price"></p>
                <button class="btn-lihat-keranjang">Lihat Keranjang</button>
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

    <script>
        $(document).ready(function() {
            const cart = @json(session()->get('cart', []));

            // Set the quantity fields based on session cart
            $(".quantitymenu").each(function() {
                const idmenu = $(this).data('idmenu');
                if (cart[idmenu]) {
                    $(this).val(cart[idmenu].qty);
                }
            });

            $(".quantitymenu").change(function() {
                var qty = $(this).val();
                var idmenu = $(this).data("idmenu");

                var url = window.location.origin + "/keranjang/chart?idmenu=" + idmenu + "&qty=" + qty;

                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(data, status) {
                        if (status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Ditambahkan ke keranjang'
                            });
                        }
                    }
                });
            });
        });
    </script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const totalSection = document.getElementById('total-section');
            const totalItems = document.getElementById('total-items');
            const totalPrice = document.getElementById('total-price');
            let totalOrderPrice = 0; // Variable to store the total order price
            let selectedMenus = []; // Variable to store selected menu items

            const updateTotal = () => {
                let items = [];
                let totalQuantity = 0;
                totalOrderPrice = 0;
                selectedMenus = []; // Reset the selected menus array

                quantityInputs.forEach(input => {
                    const quantity = parseInt(input.value);
                    const id = input.getAttribute('data-id');
                    const name = input.getAttribute('data-name');
                    const price = parseInt(input.getAttribute('data-price'));

                    if (quantity > 0) {
                        items.push(`${name}: ${quantity}`);
                        totalQuantity += quantity;
                        totalOrderPrice += quantity * price;

                        // Add the selected menu item to the selectedMenus array
                        selectedMenus.push({
                            id: id,
                            name: name,
                            price: price,
                            quantity: quantity
                        });
                    }
                });

                if (totalQuantity > 0) {
                    totalItems.innerHTML = `${totalQuantity} ITEM<br>` + items.join('<br>');
                    totalPrice.innerHTML = `Rp ${totalOrderPrice.toLocaleString()}`;
                    totalSection.style.display = 'block';

                    // Store the selected menus in localStorage
                    localStorage.setItem('selectedMenus', JSON.stringify(selectedMenus));
                } else {
                    totalSection.style.display = 'none';
                    localStorage.removeItem('selectedMenus'); // Clear localStorage if no items are selected
                }
            };

            quantityInputs.forEach(input => {
                input.addEventListener('input', updateTotal);
            });
        });

        function redirectToCart() {
            // Redirect to the cart page
            window.location.href = "{{ route('frontend.cart_user.index') }}";
        }
    </script> --}}
</body>

</html>
