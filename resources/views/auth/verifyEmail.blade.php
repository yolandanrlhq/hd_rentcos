<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/verifyEmail.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="verify-container">
    <h1>Verifikasi Email</h1>
    <p>
        Terima kasih sudah mendaftar.
        Silakan cek email kamu dan klik link verifikasi sebelum melanjutkan.
    </p>

    @if (session('message'))
        <div class="alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">
            Kirim Ulang Link Verifikasi
        </button>
    </form>
</div>

</body>
</html>
