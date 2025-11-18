<div class="iot-wrapper">

    <!-- ================= LED SEARCH ================= -->
    <div class="card iot-card">
        <h2 class="title">🔦 Pencarian Kostum</h2>

        <form id="command-form" class="search-box">
            <input type="text" id="command" placeholder="Contoh: naruto, sasuke, sakura" required>
            <button type="submit">Kirim</button>
        </form>

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
    // ================= SEND COMMAND =================
    const form = document.getElementById("command-form");
    const result = document.getElementById("searchResult");

    form.addEventListener("submit", function(e){
        e.preventDefault();

        const cmd = document.getElementById("command").value.toLowerCase();

        fetch(`/control-led/${cmd}`)
            .then(res => res.json())
            .then(data => {
                result.innerText = data.response;
            });
    });

    // ================= RFID LISTENING =================
    setInterval(() => {
        fetch("/rfid-scan")
            .then(res => res.json())
            .then(data => {
                if(data.tag){
                    document.getElementById("rfidStatus").innerText = "RFID Terdeteksi!";
                    document.getElementById("rfidResult").innerText = data.kostum;
                }
            });
    }, 1500);
</script>
