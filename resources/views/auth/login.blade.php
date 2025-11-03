<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <div class="container">
    <form class="register-box" method="POST" action="{{ route('login') }}">
      @csrf
      <button type="button" class="close-btn">&times;</button>
      <h2>Login</h2>

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

      <div class="options">
        <label><input type="checkbox" name="remember"> Remember me</label>
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
</body>
</html>
