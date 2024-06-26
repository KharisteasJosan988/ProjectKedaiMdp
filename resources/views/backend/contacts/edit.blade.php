<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Contact Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet"/>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{route('admin.dashboard.index')}}">
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
                    <a class="nav-link" href="{{route('menu.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-cutlery"></i></div>
                        Menu
                    </a>
                    <a class="nav-link" href="{{route('cart.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                        Keranjang
                    </a>
                    <a class="nav-link" href="{{route('galeri.index')}}">
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
                <h1 class="mt-4">Edit Contact</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Admin</li>
                </ol>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <textarea id="konten" name="konten">{{ $contact->konten }}</textarea>
                        @error('konten')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="mt-3 btn btn-primary">Simpan</button>
                    <a href="{{ route('contact.index') }}" class="mt-3 btn btn-secondary">Kembali</a>
                </form>
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

<script>
    ClassicEditor
        .create(document.querySelector('#konten'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    function tampilkanReview(gambar, idPreview)
</script>
</body>

</html>
