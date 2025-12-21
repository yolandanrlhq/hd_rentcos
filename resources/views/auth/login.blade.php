<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <form class="register-box" method="POST" action="{{ route('login') }}">
      @csrf
      <button type="button" class="close-btn">&times;</button>
      <h2>Login</h2>

      <!-- Email -->
      <div class="input-group">
        <input type="email" name="email" placeholder="Email" required>
      </div>

      <!-- Password -->
    <div class="input-group password-group">
    <input type="password" name="password" id="password" placeholder="Password" required>
    <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
    </div>

      <div class="options">
        {{-- <label><input type="checkbox" name="remember"> Remember me</label> --}}
        <a href="#">Forgot Password</a>
      </div>

      <!-- Tombol submit -->
      <button type="submit" class="register-btn">Login</button>

      <p class="bottom-text">
        Don’t have an account? <a href="{{ url('/register') }}">Register</a>
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
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePassword.classList.remove('fa-eye');
        togglePassword.classList.add('fa-eye-slash');
        } else {
        passwordInput.type = 'password';
        togglePassword.classList.remove('fa-eye-slash');
        togglePassword.classList.add('fa-eye');
        }
    });
    </script>

</body>
</html>
