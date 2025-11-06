<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Yumna's Zoo!</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.png" type="image/png"> </head>
    <audio autoplay loop muted id="background-audio">
    <source src="audio/zoo-sounds.mp3" type="audio/mpeg">
    Browser Anda tidak mendukung elemen audio.
</audio>

<button id="toggle-sound-btn" class="btn" style="position: fixed; top: 20px; right: 20px; z-index: 100;">
    🔊 Aktifkan Suara
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var audio = document.getElementById('background-audio');
    var toggleBtn = document.getElementById('toggle-sound-btn');

    audio.addEventListener('error', function() {
        console.error("Gagal memuat file audio. Cek path: audio/zoo-sounds.mp3");
        toggleBtn.textContent = "Audio Gagal";
        toggleBtn.disabled = true;
    });

    audio.play().catch(e => console.log("Autoplay (muted) siap."));

    toggleBtn.addEventListener('click', function() {
        if (audio.muted) {
            audio.muted = false;
            toggleBtn.textContent = "🔈 Matikan Suara";
        } else {
            audio.muted = true;
            toggleBtn.textContent = "🔊 Aktifkan Suara";
        }
    });
});
</script>

    <div class="container" style="text-align: center;">
        <h2>🐘🦁🐻 Selamat Datang di Yumna's Zoo!</h2>
        <p>Sistem ini mengelola hewan menggunakan prinsip OOP yang terhubung ke database.</p>
        <p>Silakan registrasi untuk melihat hewan-hewan di setiap zona.</p>
        
        <a href="register.php" class="btn btn-primary" style="margin-top: 20px;">Mulai Registrasi</a>
        
        <div class="nav" style="margin-top: 30px;">
            <a href="daftar_pengunjung.php">Lihat Daftar Pengunjung</a>
        </div>
    </div>
</body>
</html>