<div class="iot-wrapper">

    <!-- ================= LED CONTROL ================= -->
    <div class="card iot-card">
        <h2 class="title">🔦 Pencarian Kostum / LED Control</h2>

        <form id="command-form" class="search-box">
            <input type="text" id="command" placeholder="Contoh: naruto, sasuke, sakura" required>
            <button type="submit">Kirim</button>
        </form>

        <!-- ========== TOMBOL KONTROL LED ========== -->
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
    // ================= FORM TEXT INPUT =================
    const form = document.getElementById("command-form");
    const result = document.getElementById("searchResult");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const cmd = document.getElementById("command").value.toLowerCase();
        sendCommand(cmd);  // gunakan fungsi tombol
    });

    // ================= FUNGSI TOMBOL =================
    function sendCommand(cmd) {
        fetch(`/control-led/${cmd}`)
            .then(res => res.json())
            .then(data => {
                result.innerText = data.response;
            })
            .catch(err => {
                result.innerText = "Gagal menghubungi ESP32!";
                console.error(err);
            });
    }

    // ================= RFID LISTENING =================
    setInterval(() => {
        fetch("/rfid-scan")
            .then(res => res.json())
            .then(data => {
                if (data.tag && data.kostum) {
                    document.getElementById("rfidStatus").innerText = "RFID Terdeteksi!";
                    document.getElementById("rfidResult").innerText = data.kostum;
                } else {
                    document.getElementById("rfidStatus").innerText = "RFID belum discan...";
                    document.getElementById("rfidResult").innerText = "";
                }
            })
            .catch(err => {
                console.error("Gagal fetch RFID:", err);
            });
    }, 1500);
</script>
