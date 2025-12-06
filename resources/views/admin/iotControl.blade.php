@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/iotControl.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <div class="main-content">
        <div class="iot-wrapper">

            <!-- ================= LED CONTROL ================= -->
            <div class="card iot-card">
                <h2 class="title">🔦 Pencarian Kostum / LED Control</h2>

                <form id="command-form" class="search-box">
                    <input type="text" id="command" placeholder="Contoh: naruto, sasuke, sakura" required>
                    <button type="submit">Kirim</button>
                </form>

                <div class="button-wrapper" style="margin-top: 15px;">
                    <button onclick="sendCommand('naruto')">Naruto</button>
                    <button onclick="sendCommand('sasuke')">Sasuke</button>
                    <button onclick="sendCommand('sakura')">Sakura</button>
                    <button onclick="sendCommand('off')" style="background:red; color:white;">Matikan LED</button>
                </div>

                <div id="searchResult" class="result-text">Menunggu perintah...</div>
            </div>

            <!-- ================= RFID IDENTIFICATION ================= -->
            <div class="card iot-card">
                <h2 class="title">📡 RFID Identifikasi Kostum</h2>

                <div class="rfid-box">
                    <div class="rfid-reader-icon">📶</div>
                    <p id="rfidStatus">RFID belum discan...</p>
                </div>

                <div id="rfidResult" class="rfid-result"></div>
            </div>

        </div>

        <script>
            const form = document.getElementById("command-form");
            const result = document.getElementById("searchResult");

            form.addEventListener("submit", function (e) {
                e.preventDefault();
                const cmd = document.getElementById("command").value.toLowerCase();
                sendCommand(cmd);
            });

            function sendCommand(cmd) {
                fetch(`/control-led/${cmd}`)
                    .then(res => res.json())
                    .then(data => result.innerText = data.response)
                    .catch(() => result.innerText = "Gagal menghubungi ESP32!");
            }

            let rfidPolling = true;

            async function checkRFID() {
                if (!rfidPolling) return;

                const controller = new AbortController();
                const timeout = setTimeout(() => controller.abort(), 2000); // stop kalau 2 detik tidak ada respon

                fetch("/rfid-scan", { signal: controller.signal })
                    .then(res => res.json())
                    .then(data => {
                        if (data.tag && data.kostum) {
                            document.getElementById("rfidStatus").innerText = "RFID Terdeteksi!";
                            document.getElementById("rfidResult").innerText = data.kostum;
                            rfidPolling = false; // stop polling setelah dapat tag
                        } else {
                            document.getElementById("rfidStatus").innerText = "RFID belum discan...";
                            document.getElementById("rfidResult").innerText = "";
                        }
                    })
                    .catch(() => {
                        console.warn("RFID timeout / gagal");
                    })
                    .finally(() => {
                        clearTimeout(timeout);
                        if (rfidPolling) setTimeout(checkRFID, 2000); // ulang hanya jika masih polling
                    });
            }

            checkRFID(); // mulai polling
        </script>
    </div>
</div>
@endsection
