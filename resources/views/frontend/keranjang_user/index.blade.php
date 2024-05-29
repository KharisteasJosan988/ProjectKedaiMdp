<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang - Kedai Mdp</title>
    <link rel="stylesheet" href="{{ asset('assets/css/userCartStyles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                        <tr id="row_{{ $item->id }}">
                            <td>{{ $item->menu->nama }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>
                                Rp {{ number_format($item->subtotal, 0) }}
                                <form action="{{ route('item.delete', $item->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="btn-container">
                <form action="{{ route('checkout') }}" method="POST" style="display: inline;">
                    @csrf
                    <div class="payment-method">
                        <label for="payment-method">Metode Pembayaran : </label>
                        <select name="payment_method" id="payment-method" class="custom-select">
                            <option value="QRIS">QRIS</option>
                            <option value="CASH">CASH</option>
                        </select>
                    </div>
                    <div class="total-harga" id="total-price">Total Harga: Rp {{ number_format($totalPrice, 0) }}</div>
                    <a href="{{ route('frontend.menu_user.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn-bayar">Bayar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            window.csrfToken = csrfToken;
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        function deleteItem(id) {
            fetch(`{{ route('item.delete', ':id') }}`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                if (data.message) {
                    // Hapus baris tabel dari DOM
                    document.getElementById('row_' + id).remove();
                    // Update total harga (kurangi subtotal yang dihapus)
                    updateTotalPrice(-data.subtotal); // Ubah tanda positif menjadi negatif
                    // Tampilkan pesan sukses menggunakan Swal
                    Swal.fire('Sukses!', 'Item berhasil dihapus.', 'success');
                } else {
                    Swal.fire('Gagal!', 'Tidak dapat menghapus item.', 'error');
                }
            }).catch(error => {
                console.error('Error occurred:', error); // Log for debugging
                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus item.', 'error');
            });
        }


        function updateTotalPrice() {
            // Ambil semua subtotal yang tersisa di keranjang
            const subtotalElements = document.querySelectorAll('.cart-table tbody tr td:nth-child(3)');
            let currentTotal = 0;
            subtotalElements.forEach(element => {
                // Ambil nilai subtotal dan hapus 'Rp ' serta tanda koma
                const subtotal = parseFloat(element.textContent.replace('Rp ', '').replace(/,/g, ''));
                // Tambahkan ke total harga saat ini
                currentTotal += subtotal;
            });
            // Ubah teks total harga dengan format mata uang yang sesuai
            const totalPriceElement = document.getElementById('total-price');
            totalPriceElement.textContent = 'Total Harga: Rp ' + currentTotal.toLocaleString('id-ID');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bayarButton = document.querySelector('.btn-bayar');

            bayarButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const paymentMethod = document.getElementById('payment-method').value;
                const totalHarga = document.getElementById('total-price').innerText;

                if (paymentMethod === 'CASH') {
                    Swal.fire({
                        title: 'BAYARNYA LANGSUNG KE KASIR YAA',
                        icon: 'success'
                    });
                } else if (paymentMethod === 'QRIS') {
                    Swal.fire({
                        title: "SILAKAN MELAKUKAN PEMBAYARAN",
                        html: `${totalHarga}<br><br>TUNJUKKAN BUKTI PEMBAYARAN KE KASIR`,
                        imageUrl: "{{ asset('assets/img/qris.png') }}",
                        imageWidth: 400,
                        imageHeight: 400,
                        imageAlt: "QRIS"
                    });
                }
            });
        });
    </script>

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
