@extends('layouts.admin')

@section('title', 'Pencarian Kostum')

@section('content')
<div class="container">
    {{-- Sidebar --}}
    @include('admin.sections.sidebar')

    {{-- Konten utama --}}
    <div class="main">
        <h1>Pencarian Kostum</h1>

        <!-- Form untuk pencarian kostum -->
        <form id="command-form" method="get">
            <label for="command">Masukkan perintah kostum (naruto, sasuke, sakura):</label><br>
            <input type="text" id="command" name="command" placeholder="Masukkan perintah..." required><br><br>
            <input type="submit" value="Kirim Perintah">
        </form>

        <hr>

        <!-- Tombol kontrol LED -->
        <button class="control-btn" data-command="naruto">Nyalakan LED Merah (Naruto)</button>
        <button class="control-btn" data-command="sasuke">Nyalakan LED Kuning (Sasuke)</button>
        <button class="control-btn" data-command="sakura">Nyalakan LED Hijau (Sakura)</button>

        <!-- Tampilkan respons dari ESP32 -->
        <p id="response"></p>

        <br>
        <a href="/">Kembali ke halaman utama</a>
    </div>
</div>

<script>
    // Menangani pengiriman perintah melalui tombol
    document.querySelectorAll('.control-btn').forEach(button => {
        button.addEventListener('click', function() {
            const command = this.getAttribute('data-command');
            sendCommand(command);
        });
    });

    // Fungsi untuk mengirim perintah ke server
    function sendCommand(command) {
        fetch(`/control-led/${command}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').innerText = 'Response dari ESP32: ' + data.response;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
@endsection
