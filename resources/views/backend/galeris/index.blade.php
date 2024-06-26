<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Galeri Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet"/>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard.index') }}">
        <img src="{{ asset('assets/img/logo-kedai-mdp.svg') }}" alt="Kedai Mdp Logo">Kedai Mdp
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-lg order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/auth/logout">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link" href="{{ route('menu.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-cutlery"></i></div>
                        Menu
                    </a>
                    <a class="nav-link" href="{{route('cart.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                        Keranjang
                    </a>
                    <a class="nav-link" href="{{ route('galeri.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-image"></i></div>
                        Galeri
                    </a>
                    <a class="nav-link" href="{{ route('contact.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                        Contact
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Admin
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Galeri</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Admin</li>
                </ol>
                <form action="{{ route('galeri.formTambah') }}" method="GET">
                    <button class="btn btn-info" type="submit">
                        <i class="fas fa-plus"></i>
                        Tambah Galeri
                    </button>
                </form>

                <div class="mt-4">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Di sini Anda akan menampilkan data galeri -->
                        @foreach ($galeri as $index => $item)
                            <tr id="row_{{ $item->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td><img src="{{ asset($item->gambar) }}" alt="{{ $item->deskripsi }}"
                                         width="100"></td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <a href="{{ route('galeri.formUbah', ['id' => $item->id]) }}"
                                       class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('galeri.hapus', $item->id) }}" method="POST"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $item->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
        <footer class="py-4 bg-success mt-auto">
            <div class="container-fluid px-4">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <div class="text-white">
                            Kedai Mdp
                        </div>
                    </div>
                    <div class="col-9 d-flex align-items-center justify-content-end">
                        <div class="text-white">
                            Jl. Ukrim No.23, Cupuwatu I, Purwomartani,
                            <br>Kec. Kalasan, Kabupaten Sleman,
                            <br>Daerah Istimewa Yogyakarta 55571
                        </div>
                        <div class="col-6 d-flex align-items-center justify-content-end">
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/datatables-simple-demo.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });

    document.addEventListener('DOMContentLoaded', function () {
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
                deleteGaleri(id);
            }
        });
    }

    function deleteGaleri(id) {
        fetch(`{{ route('galeri.hapus', ':id') }}`.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                document.getElementById('row_' + id).remove();
                Swal.fire('Sukses!', 'Galeri berhasil dihapus.', 'success');
            } else {
                console.error('Gagal menghapus galeri');
                Swal.fire('Gagal!', 'Tidak dapat menghapus menu.', 'error');
            }
        }).catch(error => {
            console.error('Terjadi kesalahan:', error);
            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus galeri.', 'error');
        });
    }
</script>

<script>
    function tampilkanPreview(input, idPreview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + idPreview).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>

</html>
