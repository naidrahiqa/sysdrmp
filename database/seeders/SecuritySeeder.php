<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SecuritySeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Server Hardening: Iptables Firewall & Fail2Ban',
                'slug' => Str::slug('Server Hardening Iptables Firewall dan Fail2Ban'),
                'category' => 'Security',
                'author' => 'Cybersecurity Analyst',
                'read_time' => 10,
                'excerpt' => 'Lindungi server dari gempuran serangan Bruteforce dan DDOS. Belajar menerapkan rule Iptables tingkat lanjut dan daemon Fail2Ban.',
                'content' => "<h3>1. Mengunci Pintu dengan Iptables</h3>\n<pre><code class=\"language-bash\"># 1. Izinkan koneksi loopback (localhost ping dirinya sendiri)\niptables -A INPUT -i lo -j ACCEPT\n\n# Membolehkan koneksi ESTABLISHED (Koneksi yg sedang jalan tidak diputus)\niptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT\n\n# 2. Buka port SSH dan HTTP Web ke dunia internet\niptables -A INPUT -p tcp --dport 22 -j ACCEPT\niptables -A INPUT -p tcp --dport 80 -j ACCEPT\n\n# 3. MENGGANTI default policy yg asalnya \"TERIMA SEMUA\" menjadi \"TOLAK SEMUA (DROP)\"\n# AWAS: Cuma lakukan ini setelah Port 22 SSH dibuka di atas! Kalau ngga, anda ter-kick dari remote server sendiri!\niptables -P INPUT DROP</code></pre>\n<h3>2. Mencegah Bruteforce dengan Fail2Ban</h3>\n<pre><code class=\"language-bash\"># Menginstal agen pemantau percobaan password gagal terus menerus.\napt install fail2ban -y</code></pre>\n<h3>3. Konfigurasi Fail2Ban (Jail)</h3>\n<pre><code class=\"language-ini\"># Ubah rule SSHD di file nano /etc/fail2ban/jail.local\n[sshd]\nenabled = true # Hidupkan penjagaan pada ssh\nport    = ssh\n# Toleransi 3 kali salah ketik password\nmaxretry = 3\n# Hukuman pemblokiran selama 3600 detik (1 Jam internet hacker tsb diblock iptables!)\nbantime = 3600\n# Riwayat perhitungan rekam jejak selama 10 Menit\nfindtime = 600</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Intrusion Detection System (IDS) dengan Snort',
                'slug' => Str::slug('Intrusion Detection System IDS dengan Snort'),
                'category' => 'Security',
                'author' => 'Security Engineer',
                'read_time' => 11,
                'excerpt' => 'Menjadi mata-mata jaringan Anda sendiri. Analisis lalu lintas jaringan secara real-time dan deteksi serangan.',
                'content' => "<h3>1. Instalasi Snort di Debian</h3>\n<pre><code class=\"language-bash\">apt update\n# Snort bertindak sebagai Anjing Penjaga yg membaca ribuan pattern/signature malware TCP paket di kabel jaringan\napt install snort -y</code></pre>\n<h3>2. Menulis Custom Rule Snort</h3>\n<p>Buka file custom rule: <code>nano /etc/snort/rules/local.rules</code>.</p>\n<pre><code class=\"language-bash\"># Struktur Rule: Action | Protocol | Source IP | Source Port -> Dest IP | Dest Port | (Options)\n# - Alert = Menghasilkan bunyi/log peringatan\n# - icmp = protokol Ping / Traceroute\n# - any any = dari seluruh alamat IP penyerang bebas, port bebas di dunia\n# - -> \$HOME_NET = Tembakan ke arah Jaringan Lokal Kita (Korban)\n# - msg:\"...\" = Teks yang akan dicetak di layar Console Admin SOC!\nalert icmp any any -> \$HOME_NET any (msg:\"Terdeteksi Ping ICMP Echo!\"; sid:1000001; rev:1;)</code></pre>\n<h3>3. Mode Deteksi (Testing Live)</h3>\n<pre><code class=\"language-bash\"># -A console = Mencetak hasil penciuman Snort ke dalam terminal layar hitam\n# -q = Quiet, ngga cerewet nyetak loading bar\n# -c conf = Memberitahu letak konfigurasinya\n# -i enp0s8 = Kartu jaringan mana yang mau didengarkan / di sniff kabelnya\nsnort -A console -q -c /etc/snort/snort.conf -i enp0s8</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Manajemen User Hotspot & RADIUS Server (Mikrotik User Manager)',
                'slug' => Str::slug('Manajemen User Hotspot RADIUS Server User Manager'),
                'category' => 'Networking',
                'author' => 'Network Engineer',
                'read_time' => 8,
                'excerpt' => 'Membuat Vocer Wifi Warkop! Setup Captive Portal Hotspot dan integrasi autenrikasi RADIUS V7.',
                'content' => "<h3>1. Captive Portal (Hotspot) Dasar</h3>\n<pre><code class=\"language-bash\"># Setup penyajian halaman Login Interaktif Walled-Garden sebelum dapat akses keluar\n/ip hotspot setup</code></pre>\n<h3>2. Instalasi User Manager v7</h3>\n<p>Di Mikrotik v7, Userman merupakan package tambahan <i>(Extra Packages)</i>. Download <code>user-manager.npk</code> dari mikrotik.com, lalu Reboot Router untuk menginstallnya.</p>\n<h3>3. Integrasi Mikrotik Router dengan RADIUS LOKAL</h3>\n<pre><code class=\"language-bash\"># Kita menyuruh Router (Tukang Pintu) untuk bertanya (Otentikasi) ke server radius yg ada di dalam dirinya sendiri (127.0.0.1)\n/radius\nadd address=127.0.0.1 secret=rahasia123 service=hotspot\n\n# Kita menyuruh Profile Hotspot Halaman Login agar MENGGUNAKAN fitur RADIUS eksternal jika uservocer ngga ada di database asli router\n/ip hotspot profile\nset [ find default=yes ] use-radius=yes radius-interim-update=5m</code></pre>\n<h3>4. Konfigurasi User Manager V7 Terbaru</h3>\n<pre><code class=\"language-bash\"># Mensetting agar database radius di mikrotik ini melayani mikrotik ini sendiri (127.0.0.1)\n/user-manager router\nadd name=Lokal password=rahasia123 address=127.0.0.1\n\n# Membuat Vocer dengan Durasi 30 Hari menggunakan 1 Baris Command!\n/user-manager user\nadd name=VocerMurah10 password=123 group=default\n/user-manager user-profile\nadd user=VocerMurah10 profile=profile-30-Hari</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dasar Cloud Computing: Deploy AWS EC2 (Amazon Web Service)',
                'slug' => Str::slug('Dasar Cloud Computing Deploy AWS EC2 Server'),
                'category' => 'Cloud',
                'author' => 'Cloud Practitioner',
                'read_time' => 6,
                'excerpt' => 'Tinggalkan On-Premise! Menyewa spesifikasi Server 1 Terabyte RAM di AWS London dalam waktu 3 menit via Elastic Compute Cloud (EC2).',
                'content' => "<h3>1. Apa itu AWS EC2?</h3>\n<p>EC2 (Elastic Compute Cloud) adalah tulang punggung internet dunia. Dari Netflix hingga NASA memakai layanan VPS ini. Anda bisa mengaktifkan, menghapus, dan membayar Server Spesifikasi Super berdasarkan biaya 'Per-Jam'.</p>\n<h3>2. Pembuatan Key Pair (Satu-satunya Kunci)</h3>\n<p>Saat akan membuat instance server baru di Region US-East (N. Virginia), AWS tidak akan menanyakan Password. Melainkan, Anda diwajibkan membuat <b>Key Pair (file .pem / .ppk)</b> untuk diremote via SSH. Jangan sampai hilang!</p>\n<h3>3. Setup Security Groups (Firewall Awan)</h3>\n<pre><code class=\"language-yaml\"># Security Group AWS bertindak sebelum trafik TCP mencapai Router vOS (Virtual OS) Debian/Ubuntu kita.\n# Wajib Daftarkan Inbound Rules:\n- Tipe: SSH, Port: 22, Source: 0.0.0.0/0 (Hanya untuk Remote Awal Pembangunan)\n- Tipe: HTTP, Port: 80, Source: Anywhere/IPv4 (Agar Web Server terbaca dunia)</code></pre>\n<h3>4. Connect ke Server!</h3>\n<pre><code class=\"language-bash\"># Modifikasi file Key Pair agar tidak terlalu public permissionsnya\nchmod 400 MyAwsKey.pem\n# Masuk ke root Server sewaan AWS dari terminal laptop dirumah mu!\nssh -i \"MyAwsKey.pem\" ubuntu@ec2-132-15-22-19.compute-1.amazonaws.com</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Otomatisasi Backup Data menggunakan Cron Job (Linux)',
                'slug' => Str::slug('Otomatisasi Backup Data menggunakan Cron Job Linux'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 4,
                'excerpt' => 'Cara menyuruh server Linux menjalankan script mencadangkan database dan folder web setiap jam 03:00 Pagi secara berkala dengan daemon Cron.',
                'content' => "<h3>1. File Shell Script Pencadangan</h3>\n<pre><code class=\"language-bash\"># Buatlah script backup rahasia di folder root\nnano /root/backup-web.sh\n\n#!/bin/bash\n# Format penamaan file ZIP ditambahkan tanggal hari ini biar tidak tertimpa backup lama\nTGL=\$(date +%d-%m-%Y)\n# Mengarsipkan folder \/var\/www\/html menjadi web-tgl-bln-thn.tar.gz\ntar -czvf /backup-storage/web-\$TGL.tar.gz /var/www/html\n# Mengarsipkan database SQL utuh memakai perintah dumpfile\nmysqldump -u root -pyangrahasia my_database > /backup-storage/db-\$TGL.sql</code></pre>\n<h3>2. Jangan Lupa di +X! (Executeable)</h3>\n<pre><code class=\"language-bash\">chmod +x /root/backup-web.sh</code></pre>\n<h3>3. Memasukkan Tugas di Crontab</h3>\n<p>Cron adalah pengatur waktu default di semua mesin Linux/Unix sedunia.</p>\n<pre><code class=\"language-bash\">crontab -e\n\n# Format Cron: [Menit] [Jam] [Tanggal] [Bulan] [Hari/Senin-Miggu]\n# Aturan ini berarti:\n# Pada Menit ke 00, pada Jam ke 3, setiap Hari, Jadwal periksa script backup.sh lalu jalankan pada Background!\n00 03 * * * /root/backup-web.sh >/dev/null 2>&1</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
