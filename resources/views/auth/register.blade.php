<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <form class="register-box" method="POST" action="{{ route('register') }}">
      @csrf
      <button type="button" class="close-btn">&times;</button>
      <h2>Register</h2>

      <!-- Nama -->
      <div class="input-group">
        <input type="text" name="name" placeholder="Full Name" required>
      </div>

      <!-- Email -->
      <div class="input-group">

        <input type="email" name="email" placeholder="Email" required>
      </div>

       <!-- Password -->
        <div class="input-group password-group">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class="fa-solid fa-eye toggle-password" data-target="password"></i>
        </div>

        <!-- Konfirmasi Password -->
        <div class="input-group password-group">
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
        <i class="fa-solid fa-eye toggle-password" data-target="password_confirmation"></i>
        </div>

      {{-- <button type="submit" class="register-btn">Register</button> --}}

      <p class="bottom-text">
        Already have an account? <a href="{{ url('/login') }}">Login</a>
      </p>

      <!-- Pesan error -->
      @if ($errors->any())
        <p style="color:red; text-align:center; margin-top:10px;">
          {{ $errors->first() }}
        </p>
      @endif
    </form>
  </div>
  <script>
  document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', () => {
      const targetId = icon.getAttribute('data-target');
      const input = document.getElementById(targetId);

      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  });
</script>

</body>
</html>
