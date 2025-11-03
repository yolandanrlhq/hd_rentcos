<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <div class="container">
    <form class="register-box" method="POST" action="{{ route('register') }}">
      @csrf
      <button type="button" class="close-btn">&times;</button>
      <h2>Register</h2>

      <!-- Nama -->
      <div class="input-group">
        <span class="icon">👤</span>
        <input type="text" name="name" placeholder="Full Name" required>
      </div>

      <!-- Email -->
      <div class="input-group">
        <span class="icon">📧</span>
        <input type="email" name="email" placeholder="Email" required>
      </div>

      <!-- Password -->
      <div class="input-group">
        <span class="icon">🔒</span>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <!-- Konfirmasi Password -->
      <div class="input-group">
        <span class="icon">🔒</span>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
      </div>

      <button type="submit" class="register-btn">Register</button>

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
</body>
</html>
