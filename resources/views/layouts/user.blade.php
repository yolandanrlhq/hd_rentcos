<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'HD RENTCOS')</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/rootUser.css') }}">
@yield('extra-css')
</head>
<body>

  @yield('content')

  <script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       HAMBURGER MENU
    ========================== */
    const burger = document.getElementById('burger');
    const navLinks = document.querySelector('.nav-links');
    const searchBox = document.querySelector('.search-box');
    const icons = document.querySelector('.icons');
    const loginBtn = document.querySelector('.login-btn');

    if (burger) {
        burger.addEventListener('click', function () {
            navLinks.classList.toggle('active');
            searchBox.classList.toggle('active');
            icons.classList.toggle('active');
            loginBtn?.classList.toggle('active');
            burger.classList.toggle('toggle');
        });
    }

    /* =========================
       PROFILE DROPDOWN (ASLI PUNYAMU)
    ========================== */
    const profileBtn = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profileMenu.style.display =
                profileMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function (e) {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.style.display = 'none';
            }
        });
    }

});
</script>

</body>
</html>
