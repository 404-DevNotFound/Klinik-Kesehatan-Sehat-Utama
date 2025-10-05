<?php
// Ambil parameter dari query string
$section = $_GET['section'] ?? '';
$spesialis = $_GET['spesialis'] ?? '';
$nama = $_GET['nama'] ?? '';
$email = $_GET['email'] ?? '';
$layanan = $_GET['layanan'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Klinik Kesehatan Sehat Utama</title>
    <link rel="icon" type="image/png" sizes="16x16" href="media/Logo.png" />
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Klinik Sehat Utama <span>Medical Center</span></h1>
        <nav>
            <ul>
                <li><a href="index.php?section=tentang#tentang">Tentang Kami</a></li>
                <li><a href="index.php?section=layanan#layanan">Layanan</a></li>
                <li><a href="index.php?section=dokter#dokter">Dokter</a></li>
                <li><a href="index.php?section=testimoni#testimoni">Testimoni</a></li>
                <li><a href="index.php?section=faq#faq">FAQ</a></li>
                <li><a href="index.php?section=kontak#kontak">Kontak</a></li>
                <li><a href="login.php">Login</a></li>
                <button id="darkModeBtn">Dark Mode</button>
            </ul>
        </nav>
    </header>

    <!-- Hero -->
    <section>
        <h2>Pelayanan Kesehatan Humanis & Profesional 24 Jam</h2>
        <p>Temukan dokter spesialis dan jadwalkan pertemuan dengan mudah.</p>
        
        <?php if ($spesialis): ?>
            <div style="background: #4CAF50; color: white; padding: 15px; margin: 20px 0; border-radius: 5px;">
                ✓ Anda mencari jadwal untuk: <strong><?php echo htmlspecialchars($spesialis); ?></strong>
            </div>
        <?php endif; ?>
        
        <form method="GET" action="index.php">
            <label for="spesialis">Pilih Spesialis:</label>
            <select id="spesialis" name="spesialis">
                <option value="anak" <?php echo $spesialis === 'anak' ? 'selected' : ''; ?>>Spesialis Anak</option>
                <option value="penyakit-dalam" <?php echo $spesialis === 'penyakit-dalam' ? 'selected' : ''; ?>>Penyakit Dalam</option>
                <option value="jantung" <?php echo $spesialis === 'jantung' ? 'selected' : ''; ?>>Jantung</option>
                <option value="mata" <?php echo $spesialis === 'mata' ? 'selected' : ''; ?>>Mata</option>
            </select>
            <button type="submit">Cari Jadwal</button>
        </form>
    </section>

    <main>
        <!-- Tentang Kami -->
        <section id="tentang">
            <h2>Tentang Kami</h2>
            <p>
                Sejak tahun 1990, Klinik Sehat memberikan layanan promotif, preventif,
                kuratif, dan rehabilitatif dengan standar kesehatan terbaik.
            </p>
        </section>

        <!-- Layanan -->
        <section id="layanan">
            <h2>Layanan Unggulan</h2>
            <article>
                <h3>Eye Center</h3>
                <p>Pemeriksaan dan perawatan mata lengkap dengan teknologi modern.</p>
            </article>
            <article>
                <h3>Cardiac Center</h3>
                <p>Layanan jantung & pembuluh darah menyeluruh.</p>
            </article>
            <article>
                <h3>Medical Checkup</h3>
                <p>Paket kesehatan menyeluruh untuk berbagai usia.</p>
            </article>
            <article>
                <h3>Apotek</h3>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Reprehenderit, voluptas.
                </p>
            </article>
            <article>
                <h3>Klinik anak</h3>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias,
                    ea.
                </p>
            </article>
        </section>

        <!-- Dokter -->
        <section id="dokter">
            <h2>Dokter Kami</h2>
            <article>
                <img src="media/Doctorcewek.jpg" alt="Dokter Andi" width="200" />
                <h3>dr. Ani, Sp.A</h3>
                <p>Spesialis Anak - Senin, Rabu, Jumat</p>
            </article>
            <article>
                <img src="media/Doctorcowok.jpg" alt="Dokter Budi" width="200" />
                <h3>dr. Delon, Sp.PD</h3>
                <p>Penyakit Dalam - Selasa, Kamis, Sabtu</p>
            </article>
        </section>

        <!-- Testimoni Pasien -->
        <section id="testimoni">
            <h2>Testimoni Pasien</h2>
            <blockquote>
                <p>
                    "Pelayanan sangat ramah dan profesional. Saya merasa aman dan nyaman
                    selama pemeriksaan."
                </p>
                <cite>- Siti, Pasien</cite>
            </blockquote>
            <blockquote>
                <p>
                    "Dokter menjelaskan kondisi saya dengan sangat detail. Sangat
                    membantu!"
                </p>
                <cite>- Budi, Pasien</cite>
            </blockquote>
        </section>

        <!-- FAQ -->
        <section id="faq">
            <h2>Pertanyaan Umum (FAQ)</h2>
            <article>
                <h3>Apakah klinik buka 24 jam?</h3>
                <p>Ya, Klinik Sehat melayani pasien 24 jam setiap hari.</p>
            </article>
            <article>
                <h3>Bagaimana cara membuat janji temu?</h3>
                <p>
                    Anda bisa menggunakan formulir pendaftaran online atau menghubungi
                    nomor telepon klinik.
                </p>
            </article>
        </section>

        <!-- Formulir Pendaftaran Online -->
        <section id="pendaftaran">
            <h2>Pendaftaran Online</h2>
            
            <?php if ($nama && $email && $layanan): ?>
                <div style="background: #4CAF50; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                    <strong>✓ Pendaftaran Berhasil!</strong><br>
                    Nama: <?php echo htmlspecialchars($nama); ?><br>
                    Email: <?php echo htmlspecialchars($email); ?><br>
                    Layanan: <?php echo htmlspecialchars($layanan); ?>
                </div>
            <?php endif; ?>
            
            <form method="GET" action="index.php">
                <input type="hidden" name="section" value="pendaftaran" />
                
                <label for="nama">Nama Lengkap:</label><br />
                <input type="text" id="nama" name="nama" required /><br /><br />

                <label for="email">Email:</label><br />
                <input type="email" id="email" name="email" required /><br /><br />

                <label for="telp">Nomor Telepon:</label><br />
                <input type="tel" id="telp" name="telp" /><br /><br />

                <label for="layanan">Layanan yang dipilih:</label><br />
                <select id="layanan" name="layanan" required>
                    <option value="mcu">Medical Checkup</option>
                    <option value="mata">Pemeriksaan Mata</option>
                    <option value="jantung">Pemeriksaan Jantung</option>
                </select><br /><br />

                <button type="submit">Daftar Sekarang</button>
            </form>
        </section>

        <!-- Artikel / Promo -->
        <aside>
            <h2>Promo & Artikel</h2>
            <article>
                <h3>Promo Medical Check Up</h3>
                <p>Dapatkan diskon 20% untuk paket MCU selama bulan ini.</p>
            </article>
            <article>
                <h3>Artikel: Tips Menjaga Jantung Sehat</h3>
                <p>Pola hidup sehat dapat mengurangi risiko penyakit jantung.</p>
            </article>
        </aside>
    </main>

    <!-- Kontak -->
    <section id="kontak">
        <h2>Kontak & Lokasi</h2>
        <address>
            Jl. Sehat No. 123, Jakarta<br />
            Telepon: (021) 1234567<br />
            Email: info@kliniksehat.id
        </address>
        <div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.628086604245!2d117.14540362358093!3d-0.5152024934331141!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67ff207a9e76d%3A0x39a1cf7dbcd100e0!2sKlinik%20%26%20Apotek%20GP%20Sehat%20(%20dr.%20Dewi%20Muzzayyanti)!5e0!3m2!1sid!2sid!4v1757741833688!5m2!1sid!2sid"
                width="600"
                height="450"
                style="border: 0"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 RichardDanteGunawan(2409106061). All Rights Reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>