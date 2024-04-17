document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.navbar-toggler');
    var instances = M.Navbar.init(elems, {
      hover: false
    });
  });
