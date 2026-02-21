<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdvancedSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            // ==========================================
            // DEBIAN / LINUX ADVANCED
            // ==========================================
            [
                'title' => 'Otomatisasi SSL Certificate dengan Certbot (Let\'s Encrypt)',
                'slug' => Str::slug('Otomatisasi SSL Certificate dengan Certbot Lets Encrypt'),
                'category' => 'Debian Server',
                'author' => 'Web Dev Ops',
                'read_time' => 5,
                'excerpt' => 'Tidak perlu beli SSL jutaan rupiah! Install dan perbarui Gembok Hijau (HTTPS) otomatis menggunakan bot resmi Let\'s Encrypt.',
                'content' => "<h3>1. Instalasi Certbot (Nginx)</h3>\n<pre><code class=\"language-bash\"># Install paket bot dan plugin Nginx\napt install certbot python3-certbot-nginx -y</code></pre>\n<h3>2. Generate SSL Otomatis dan Modifikasi Config Server</h3>\n<p>Certbot sangat sakti! Dia tidak hanya meminta file sertifikat dari awan Let's Encrypt, tapi dia juga secara otomatis MEMBUKA config <code>server_block</code> Nginx Anda dan memodifikasinya menjadi port 443!</p>\n<pre><code class=\"language-bash\"># -d artinya menyebutkan alamat domain yang mau dibikinkan SSL\n# Bot akan menanyakan email valid Anda untuk peringatan kadaluarsa (3 Bulan)\ncertbot --nginx -d smk1.sch.id -d www.smk1.sch.id</code></pre>\n<h3>3. Pembaruan Otomatis (Cron Renewal)</h3>\n<p>Sertifikat Let's Encrypt hanya berlaku 90 Hari. Untungnya, Certbot otomatis menaruh Job di <code>/etc/cron.d/certbot</code>. Tapi untuk jaga-jaga, ini perintah dry-run test perpanjangannya:</p>\n<pre><code class=\"language-bash\">certbot renew --dry-run</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Manajemen Memory & Swap Linux',
                'slug' => Str::slug('Manajemen Memory dan Swap Linux'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 6,
                'excerpt' => 'Server Sering Hang gara-gara Out Of Memory (OOM)? Belajar membuat Virtual RAM dari sisa Harddisk (Swap File) tanpa perlu restart atau ganti partis!!',
                'content' => "<h3>1. Membuat File Mentah Dummy (Sebagai RAM Bohongan)</h3>\n<pre><code class=\"language-bash\"># Membuat sebuah file sebesar 2GB penuh dengan angka Nol (Blank)\ndd if=/dev/zero of=/swapfile bs=1M count=2048\n\n# Ubah izin file agar tidak bisa diubah user biasa (Sangat Penting untuk RAM)\nchmod 600 /swapfile</code></pre>\n<h3>2. Format File Jadi Format Memori (mkswap)</h3>\n<pre><code class=\"language-bash\"># Memberi cap/format bahwa file ini adalah File Sistem Swap Virtual!\nmkswap /swapfile\n\n# Memasukkan RAM Virtual secara live menimpa RAM Fisik Real tanpa REBOOT!\nswapon /swapfile\n\n# Cek hasilnya lewat:\nfree -m</code></pre>\n<h3>3. Melakukan Permanen (FSTAB)</h3>\n<p>Agar RAM tiban ini nggak ilang kalau Server di restart, lempar baris text ini ke <code>/etc/fstab</code>:</p>\n<pre><code class=\"language-bash\">echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Konfigurasi Network File System (NFS Server)',
                'slug' => Str::slug('Konfigurasi Network File System NFS Server'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 7,
                'excerpt' => 'Cara Mount / Tancap disk dari server seberang ke komputer Linux kita secara transparan. (Alternatif Samba khusus ekosistem UNIX/Linux).',
                'content' => "<h3>1. Konfigurasi Server Induk (Penyedia Storage)</h3>\n<pre><code class=\"language-bash\">apt install nfs-kernel-server -y\n\n# Buat folder dan ubah permissionnya agar bebas dimainkan Client jaringan!\nmkdir -p /var/nfs_storage\nchown nobody:nogroup /var/nfs_storage\nchmod 777 /var/nfs_storage</code></pre>\n<h3>2. Daftarkan Folder untuk Dijual / Diekspor</h3>\n<p>Edit file rahasia <code>/etc/exports</code>:</p>\n<pre><code class=\"language-bash\"># Baris ini mepersilahkan Jaringan Net 192.168.10.x untuk bisa menulis (rw)\n# sync = segera catat di disk, no_root_squash = pertahankan UID\n/var/nfs_storage 192.168.10.0/24(rw,sync,no_root_squash)</code></pre>\n<h3>3. Menangkap Storage (NFS Client Server)</h3>\n<p>Di server milik teman yg bertugas numpang disk jarak jauh:</p>\n<pre><code class=\"language-bash\">apt install nfs-common -y\n# Hubungkan Folder Jauh milik Server A (192.168.10.1) ke folder Kosong PC kita!\nmount 192.168.10.1:/var/nfs_storage /mnt/storage_jauh\n\n# Buka folder mnt dan rasakan sensasi menyimpan file ditaruh di komputer orang!\ncd /mnt/storage_jauh </code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // DATABASE ARCHITECTURE & HIGH AVAILABILITY
            // ==========================================
            [
                'title' => 'Replikasi MySQL/MariaDB (Master-Slave)',
                'slug' => Str::slug('Replikasi MySQL MariaDB Master Slave'),
                'category' => 'Database',
                'author' => 'Database Architect',
                'read_time' => 12,
                'excerpt' => 'Selamatkan database sebelum terbakar! Copy semua data SQL Real-Time otomatis dari Server Aplikasi (Master) ke Server Backup (Slave).',
                'content' => "<h3>1. Konsep Utama Master -> Slave</h3>\n<p>Kita akan memiliki 2 Server SQL (192.168.1.1 sbg Master & 1.2 sbg Slave). Master mencatat segala query Insert/Update kedalam buku Binary Log (Bin-Log). Server Slave (Budak) secara terus-menerus membaca log tersebut lalu menerapkannya persis di dalam tubuhnya sendiri.</p>\n<h3>2. Konfigurasi Server Utama (The Master)</h3>\n<pre><code class=\"language-ini\"># Pada file 50-server.cnf di MariaDB, Anda ubah:\nbind-address = 0.0.0.0\n# Nyalakan Catatan Harian (Bin-Log) dan beri Nama server 1.\nlog_bin = /var/log/mysql/mysql-bin.log\nserver-id = 1</code></pre>\n<p>Setelah di-restart, masuk MySQL CLI buat Akun khusus yg dipakai sang Budak untuk ngeremote:</p>\n<pre><code class=\"language-sql\">CREATE USER 'replikator'@'192.168.1.2' IDENTIFIED BY 'rahasia12';\nGRANT REPLICATION SLAVE ON *.* TO 'replikator'@'192.168.1.2';\nFLUSH PRIVILEGES;</code></pre>\n<h3>3. Perintah Eksekusi Untuk Server Pembantu (The Slave)</h3>\n<pre><code class=\"language-sql\"># Pada File cnf server Slave, pastikan barisan \"server-id = 2\". \n# Di Terminal MariaDB Slave eksekusi Perintah Sakti ini:\nCHANGE MASTER TO\nMASTER_HOST='192.168.1.1',\nMASTER_USER='replikator',\nMASTER_PASSWORD='rahasia12',\nMASTER_LOG_FILE='mysql-bin.000001',\nMASTER_LOG_POS=328; -- (Ambil dari nilai file log pas SHOW MASTER STATUS di Server 1 Tadi)\n\n-- NYALAKAN MESIN BUBUTNYA!\nSTART SLAVE;</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // ==========================================
            // WINDOWS SERVER INTERMEDIATE
            // ==========================================
            [
                'title' => 'Windows Server: IIS (Internet Information Services) Basic Config',
                'slug' => Str::slug('Windows Server IIS Basic Config'),
                'category' => 'Windows Server',
                'author' => 'Web Administrator',
                'read_time' => 6,
                'excerpt' => 'Bosan Memakai Apache/Nginx Linux? Instalasi framework Web Server andalan Microsoft (IIS) pada Windows Server 2022.',
                'content' => "<h3>1. Instalasi Layanan IIS Web-Server</h3>\n<pre><code class=\"language-powershell\"># Buka PowerShell sebagai Administrator!\nInstall-WindowsFeature -name Web-Server -IncludeManagementTools</code></pre>\n<h3>2. Struktur Direktori dan Penggantian Laman Utama</h3>\n<p>Semua Website berbasis IIS akan di-host secara Default (Public WWW-root) di jalur bawaannya: <code>C:\\inetpub\\wwwroot\\</code>.<br>Silahkan ubah isi dari file <code>iisstart.htm</code> sesuai dengan HTML statis web anda, dan Web Server sudah bisa dilirik di Internet melalui Port 80!</p>\n<h3>3. Menambah IP Virtual Host (Binding Domain Baru)</h3>\n<pre><code class=\"language-powershell\"># Contoh Kasus Web Sistem Informasi Akademik yang ditempel di IIS pada port 80 Spesifik Domain:\nNew-WebSite -Name \"PortalSiswa\" -Port 80 -HostHeader \"portal.sekolahku.id\" -PhysicalPath \"c:\\WebsiteSiswa\"</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'WDS (Windows Deployment Services) - Instal Ulang OS Massal via Kabel LAN',
                'slug' => Str::slug('Windows Deployment Services PXE Boot'),
                'category' => 'Windows Server',
                'author' => 'IT Infrastructure Specialist',
                'read_time' => 11,
                'excerpt' => 'Tidak perlu lagi colok Flashdisk Bootable keliling 40 komputer Lab! Lakukan Re-Install OS Windows X dari Jaringan lokal menggunakan fitur sakti PXE/WDS.',
                'content' => "<h3>1. Prasyarat Mutlak Sebuah Server WDS</h3>\n<p>Server WDS HANYA BISA BEKERJA jika dalam LAN anda sudah beroperasi peran Active Directory (DC) dan Server Pemberi IP Otomatis (DHCP). WDS sifatnya cuma menyuntikkan (Inject PXE) di paket IP yang dibawa DHCP.</p>\n<h3>2. Instalasi Active Deployment</h3>\n<pre><code class=\"language-powershell\">Install-WindowsFeature -Name WDS -IncludeManagementTools</code></pre>\n<h3>3. Mempersiapkan File .WIM dan .BOOT Master</h3>\n<p>Setelah WDS MMC Graphical Tool terbuka:<br>\n- Posisikan DVD/ISO Master OS Windows 10/11 kedalam Server.<br>\n- Dalam WDS: Masukkan file dari dalam Folder Disc DVD \"Sources -> <code>install.wim</code>\" sebagai image <b>(Install Image)</b>.<br>\n- Disusul masukkan Source \"Sources -> <code>boot.wim</code>\" untuk proses Pra-Layar Biru installer! <b>(Boot Image)</b></p>\n<h3>4. PXE Boot Jaringan (Selesai!)</h3>\n<p>Sekarang matikan komputer kosong baru punya Bos Anda. Colok ke Hub Intranet anda. Nyalakan, dan tekan <b>F12 (Bios Network Boot)</b>! PC Kosong melompong itu akan merequest Alamat IP dan secara instan mendownload ISO installer langsung dari Kabel Tembaga tanpa Flashdisk!!!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // NETWORKING (MIKROTIK, CISCO)
            // ==========================================
            [
                'title' => 'MikroTik VRRP (Virtual Router Redundancy Protocol)',
                'slug' => Str::slug('Mikrotik VRRP Virtual Router Redundancy Protocol'),
                'category' => 'Networking',
                'author' => 'Network Engineer',
                'read_time' => 8,
                'excerpt' => 'Cara merancang Router Backup yang Mengambil Alih Jaringan Otomatis saat Router Master Anda Meledak atau Hang.',
                'content' => "<h3>1. Konsep Gateway Bayangan (Virtual IP)</h3>\n<p>Router A (Master) dan Router B (Backup) disambungkan ke Switch LAN dengan 1 IP Palsu/Virtual yang sama (Misal: 192.168.1.1). Komputer client akan mengeset Gateway ke IP Palsu ini! Router A yang sesungguhnya yang meladeni.</p>\n<h3>2. Konfigurasi Mikrotik A (Sang Raja R1)</h3>\n<pre><code class=\"language-bash\"># Membuat Wujud Terowongan Fisik VRRP pada Colokan ke Switch\n/interface vrrp add interface=ether2_LAN name=vrrp_backup vrid=10 priority=254\n\n# Memasukan IP Bayangan/Bersama kedalam Ether Virtual tadi\n/ip address add address=192.168.1.1/24 interface=vrrp_backup</code></pre>\n<h3>3. Konfigurasi Mikrotik B (Pangeran R2)</h3>\n<pre><code class=\"language-bash\"># Mensetting R2 Namun dengan Nilai Priority KALAH (Default Prioritas Mikrotik = 100)\n# (Artinya R2 akan MENGALAH tidak melempar IP, selama Raja dengan level 254 masih bernafas!)\n/interface vrrp add interface=ether2_LAN name=vrrp_backup vrid=10 priority=100\n/ip address add address=192.168.1.1/24 interface=vrrp_backup</code></pre>\n<p>Jika R1 Mati Lampu, R2 menyadari ketidakhadiran paket Hello dan segera bangkit menerbitkan IP Bayangannya untuk mengambil alih lalu-lintas 1 Gedung! Client pun gak sadar ada pergantian Shift Router Boss!!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Otomatisasi Pindah Jalur Dual-WAN dengan Netwatch MikroTik',
                'slug' => Str::slug('Otomatisasi Failover Dual WAN dengan Netwatch Mikrotik'),
                'category' => 'Networking',
                'author' => 'Router Script Programmer',
                'read_time' => 7,
                'excerpt' => 'Membuat skrip Fail-Over yang dipicu (trigerred) saat sebuah IP Ping Tujuan terputus.',
                'content' => "<h3>Pentingnya Netwatch Tool</h3>\n<p>Terkadang Internet Biznet kabel optiknya putus di Jalan Tol, TETAPI Modemm Router/ONT-nya merespon kabel Ethernetnya masih tercolok up di mikrotik! Trik Check-Gateway Ping kadang meleset, karenanya <b>Netwatch Pengecek Koneksi Riil ke DNS Google (8.8.8.8)</b> sangat diperlukan!</p>\n<h3>Konfigurasi Eksekusi Tipe Trigger Mikrotik!</h3>\n<pre><code class=\"language-bash\">/tool netwatch\n# Parameter utama, Jika ping IP ini (Google Internet) gagal/Timeout, Lakukan skrip Down!!\nadd host=8.8.8.8 interval=10s timeout=2s \\\ndown-script=\"/ip route disable [find comment=\\\"Internet-Biznet\\\"] ; /ip route enable [find comment=\\\"Internet-Telkom\\\"]\" \\\nup-script=\"/ip route enable [find comment=\\\"Internet-Biznet\\\"] ; /ip route disable [find comment=\\\"Internet-Telkom\\\"]\"\n</code></pre>\n<p>Penjelasan: Jika Internet Putus/Putus (Status: Down), Matikan tabel rute Biznet, dan Hidupkan tabel Rute Jalur Kedua milik Telkom IndiHome. Dan Saat Internet (Status Up Kembali Nyala), Kembalikan tabel asli Telkom dimatikan, Biznet di nyalakan!! Sesimpel itu!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cisco Routing OSPF & EIGRP (The Dynamic Protocols)',
                'slug' => Str::slug('Cisco Routing OSPF dan EIGRP'),
                'category' => 'Networking',
                'author' => 'Cisco Certified Admin',
                'read_time' => 9,
                'excerpt' => 'Implementasi tabel EIGRP Cisco (Algoritma DUAL) dan Single-Area OSPF di CLI Router Packet Tracer nyata!',
                'content' => "<h3>1. Konsep Dynamic Router Cisco</h3>\n<p>Pusing entry Static Route Network Tujuan secara manual pada Cisco-2911 ratusan Gedung? Persilahkan Router itu sendiri yang mengumumkan network lokalnya dengan Dynamic Protocol!</p>\n<h3>2. Konfigurasi R1 EIGRP (Ekslusif Protocol Cisco)</h3>\n<pre><code class=\"language-bash\"># Masuk Terminal dan Ketik AS Number Protocol EIGRP seragam antar tetangga wilayah\nrouter eigrp 10\n# Network 1 = Mendaftarkan jalur Colokan LAN Client kita kedalam bursa transfer\nnetwork 192.168.10.0 0.0.0.255\n# Network 2 = Mendaftarkan jalur Colokan Seri (Serial WAN/Se0/0) yang menempel dengan Router Seberang R2\nnetwork 10.10.10.0 0.0.0.3\nno auto-summary\nexit</code></pre>\n<h3>3. Kenapa Pakai Wildcard Mask, bukan Subnet Mask?</h3>\n<p>Di OSPF/EIGRP Cisco, netmask (<code>255.255.255.0</code>) DILARANG / tidak digunakan. Yang kita pakai adalah Invers Mask (Angka terbalik), Nilai Mutlak Subnet /32 (<code>255.255.255.255</code>) <b>dikurangi Nilai Subnet anda (<code>255.255.255.0</code>) = Wildcard Mask Valid: <code>0.0.0.255</code></b>!!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Traffic Shaping (QoS) Menggunakan Mikrotik HTB',
                'slug' => Str::slug('Traffic Shaping QoS Menggunakan Mikrotik HTB'),
                'category' => 'Networking',
                'author' => 'Broadband Engineer',
                'read_time' => 9,
                'excerpt' => 'Hierarchical Token Bucket (HTB) Memastikan lalu-lintas VIP (Game Online/Server) lewat duluan ditengah sesaknya Download IDM! Tree Hirarki sempurna!',
                'content' => "<h3>1. Prasyarat Stempel Marking Mangle</h3>\n<p>Sebelum kita pisah antrian dengan Hierarki Bandwidth, Anda harus membuat 2 connection-mark + 2 packet-mark! Satuan packet pertama distempel <b>(paket_Game)</b> Dan paket kedua sisanya dinamakan <b>(paket_Biasa)</b>!</p>\n<h3>2. Merancang Pohon Kasta Quality of Sevice Puncak (Parent)</h3>\n<pre><code class=\"language-bash\">/queue tree\n# Membuat Bandwith Teratas (Aliran PDAM Pusat Maksimal 20 Megabit) untuk Global (Bapak)\nadd name=\"Total-ISP\" parent=global max-limit=20M</code></pre>\n<h3>3. Merancang Limitasi Aturan Cabang Daun (Child / HTB Level 2)</h3>\n<pre><code class=\"language-bash\"># Sub-Game meminjam bandwith milik (Total-ISP).\n# Priority=1 berarti (VIP) Kasta Paling Dewa! Jila bandwidth disedot abis ama sub-Umum, Mikrotik akan SECARA PAKSA merampasnya dan memberikannya kepada Si GAME!!!\nadd name=\"Sub-Game\" parent=\"Total-ISP\" packet-mark=\"paket_Game\" limit-at=3M max-limit=20M priority=1\n\n# Sub-Umum (Trafik IDM/Facebook).\n# Priority=8 berarti Kasta Rakyat Jelata, Terendah. Dapet Ampas sisa dari Si Game\nadd name=\"Sub-Umum\" parent=\"Total-ISP\" packet-mark=\"paket_Biasa\" limit-at=5M max-limit=20M priority=8</code></pre>\n<p>Dengan teknik Prioritas Kasta di Atas, dijamin orang yang maen Dota (paket_Game) meskipun traffic di seret 20M Oleh Downloader IDM di kamar sebelah, Ping Dota tetap akan berada pada level Hijau! <b>Limit-at</b> berfungsi menyediakan jaminan minimal 3Mbps absolut!!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // SECURITY ENGINEERING (SIEM & RADIUS & PROXY)
            // ==========================================
            [
                'title' => 'Instalasi FreeRADIUS Server Otentikasi Terpusat Linux',
                'slug' => Str::slug('Instalasi FreeRADIUS Server Autentikasi Terpusat'),
                'category' => 'Security',
                'author' => 'Security Engineer',
                'read_time' => 5,
                'excerpt' => 'Lelah bikin user Wifi di Mikrotik satu per satu? Pakai FreeRADIUS Linux terpusat yang bisa nge-handle ratusan Mikrotik sedunia sekaligus dengan format database MariaDB.',
                'content' => "<h3>1. Instalasi Basis Server</h3>\n<pre><code class=\"language-bash\"># Menarik Komponen Database SQL, Konektor Php, dan Perangkat Lunak Inti Radius \napt install freeradius freeradius-mysql freeradius-utils -y</code></pre>\n<h3>2. Mendaftarkan NAS (Network Access Server / Klien Target)</h3>\n<p>Agar Router Mikrotik (192.168.10.1) memiliki Akses sah mengirim Pertanyaan User+Password ke Server Debian, daftarkan <b>IP Mikrotik tersebut</b> ke dalam berkas rahasia klien radius: <code>/etc/freeradius/3.0/clients.conf</code>:</p>\n<pre><code class=\"language-bash\">client mikrotik-sekolah {\n    ipaddr = 192.168.10.100\n    # Shared Secret adalah Password Gembok API Koneksi antara Router Nas vs Radius\n    secret = radiusrahasia123\n}</code></pre>\n<h3>3. Daftarkan User Dummy CLI (Testing Local)</h3>\n<p>Edit file <code>/etc/freeradius/3.0/users</code>, un-comment bagian contoh dan buat:</p>\n<pre><code class=\"language-bash\">bambang Cleartext-Password := \"rahasia\"\n    # Atribut balasan (Memaksa Mikrotik yang merequest bambang untuk ngasih IP spesifik)\n    Framed-IP-Address = 192.168.10.77</code></pre>\n<p>Coba uji pengetesan loopback lewat Terminal Linux: <code>radtest bambang rahasia localhost 0 testing123</code>. Jika Access-Accept, Server SIAP membalas request otentikasi 802.1X milik Switch dan WiFi Enterprise sedunia!!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Keamanan Ekstra Layanan Email: SpamAssassin & ClamAV',
                'slug' => Str::slug('Keamanan Ekstra Layanan Email SpamAssassin ClamAV'),
                'category' => 'Security',
                'author' => 'System Administrator',
                'read_time' => 8,
                'excerpt' => 'Menyaring ribuan Email Masuk Postfix dari lampiran Eksekusi Trojan/Virus berbahaya lewat ClamAV dan Detektor Spam AI SpamAssassin Milter.',
                'content' => "<h3>1. Memasang Anti Virus Raksasa ClamAV Open Source</h3>\n<pre><code class=\"language-bash\"># Clamav akan duduk di layer OS menanti perintah pemeriksaan file.\napt install clamav clamav-daemon amavisd-new -y</code></pre>\n<h3>2. Instalasi Penghancur Spam Filter Assassin</h3>\n<pre><code class=\"language-bash\"># SpamAssassin bertindak sebagai filter skor algoritma string bahasa!\napt install spamassassin spamc -y</code></pre>\n<h3>3. Konfigurasi AMaVis (Sang Jembatan Postfix Ke Antivirus)</h3>\n<p>Anda tidak bisa langsung menyolokkan Postfix (Server penerima surat asli) ke Antivirus. Anda butuh penengah, yaitu <b>Amavis</b>. Di dalam Config master pintu Postfix <code>/etc/postfix/master.cf</code> kita tulis filter penerimaan TCP smtp:</p>\n<pre><code class=\"language-bash\"># Menyuruh postfix (Mail Server) MEM-FORWARD PAKSA semua Teks Surat Baru menuju Port 10024 ke Mulut Si Amavis untuk Di scan Virus!!\nsmtp      inet  n       -       y       -       -       smtpd\n          -o content_filter=smtp-amavis:[127.0.0.1]:10024\n\n# Membuka Pintu Belakang Postfix Port 10025 agar Amavis setelah selesai Scan Virus SUKSES, bisa Menyuntikannya KEMBALI pesannya ke Sistem Email Maildir user!\nsmtp-amavis unix -      -       n       -       2       smtp</code></pre>\n<p>Setiap karyawan Menerima Email Ekstensi `.RAR` berisikan Ransomeware dari penipu publik, Server ini <b>Sebelum</b> menaruh file itu di Kotak Masuk Inbox Client, Langsung mengahancurkannya dan membalas pengirim bahwa emailnya Ditolak!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mengeksekusi Network Benchmarking (Uji Jaringan Iperf3)',
                'slug' => Str::slug('Network Benchmarking Uji Jaringan Iperf3'),
                'category' => 'Networking',
                'author' => 'System Tester',
                'read_time' => 3,
                'excerpt' => 'Apakah Kabel LAN / Wireless WiFi Access Point Teman Anda BOHONG mengklaim 1 Gigabit? Mari kita Uji coba throughput jaringan mentahnya pakai aplikasi Terminal Iperf!',
                'content' => "<h3>1. Menyalakan Iperf di Mode Server (Penerima Bola)</h3>\n<p>Instal <code>apt install iperf3 -y</code> di PC 1. Setelah itu, pastikan PC ini menjadi Terminal Penerang Uji Coba.</p>\n<pre><code class=\"language-bash\"># -s = Server Mode (Menyalakan port listening di background)\niperf3 -s</code></pre>\n<h3>2. Eksekusi Test dari PC Laptop Lawan (Pengirim Bola Tembakan Maxed!)</h3>\n<p>Misal IP Server tadi adalah 192.168.1.100</p>\n<pre><code class=\"language-bash\"># -c : Client mode (Kirim 100% traffic secara paksa berturut turut)\n# -t 20 : Hajar kabel selama Durasi 20 Detik Full Load Bandwidth Test Transfer Bit TCP!!\niperf3 -c 192.168.1.100 -t 20</code></pre>\n<p>Tunggu Outputnya! Pada hasil bagian akhir anda akan mengetahui JIKA Sinyal Radio WiFi anda jelek, dia hanya akan menampilkan <b>40 Mbits/Sec</b>. Jauh dari Kecepatan Tertulis Iklan 300 Mbps yang di banggakan Box-nya!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Proxy Delay Pools (Squid QoS Limitation)',
                'slug' => Str::slug('Proxy Delay Pools Squid QoS Limitation'),
                'category' => 'Security',
                'author' => 'System Administrator',
                'read_time' => 10,
                'excerpt' => 'Membatasi Karyawan yang doyan Download Resolusi HD Youtube? Limit kecepatan Spesifik ekstensi (.MP4) menggunakan proxy squid, tanpa Limit traffic Web lain!',
                'content' => "<h3>1. Definisi Masalah Web Proxy</h3>\n<p>Router Mikrotik membatasi Bandwith Total ke User. Namun SQUID Proxy men-Spesifikasi pembatasan berdasar URL, Berdasar Extensi Web (Download file .MP4/ .ISO). Kita Membangun Kolam (Delay Pool) berlapis pada file <code>/etc/squid/squid.conf</code></p>\n<h3>2. Membuat Parameter Limitasi</h3>\n<pre><code class=\"language-bash\"># 1. Mendefenisikan Ekstensi file Rakus Ukuran\nacl rakus_dl url_regex -i \\.mp4\$ \\.avi\$ \\.mkv\$ \\.iso\$\n\n# 2. Mendefinisikan Tipe Kolam (Hanya ada 1 Kelas Aturan Total)\ndelay_pools 1\ndelay_class 1 1\n\n# 3. Parameterisasi Besaran Ember & Kran Pembatas (Delay Parameter)\n# Kolam 1 : Memiliki Batas ember Total= 50 Juta Bita. Dengan Kran Limit= 10 Ribu Byte (10 KB/s)\ndelay_parameters 1 10000/50000000\n\n# 4. Kapan kolam kelas 1 ini tereksekusi menjerat korban?\n# Jawab: Jika ada Traffic Proxy Client yang minta tipe exten dari regex Variabel 'rakus_dl'\ndelay_access 1 allow rakus_dl</code></pre>\n<p>Akibatnya, Seluruh Client Yang membuka Detik.com / Gmail akan wus wus 1 Gigabit Ngebut. Muncullah Karyawan A Menembak server download film bajakan IndoXX1 '.Mp4'. Proxy akan mengizinkan request download tersebut, Namun SERVER PROXY mencekik/merespon Pipa Pengembalian paket MP4 nya kedalam Limit kecepatan menyedihkan 10 Kilobyte per detik yang bikin orang menyerah! Masterpiece!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // DEVOPS TOOLS / IAC / CONTAINERS Lanjut
            // ==========================================
            [
                'title' => 'Infrastructure as Code (IaC) Dasar dengan Terraform',
                'slug' => Str::slug('Infrastructure as Code Dasar dengan Terraform'),
                'category' => 'DevOps',
                'author' => 'DevOps Engineer',
                'read_time' => 8,
                'excerpt' => 'Tidak lagi Klak-klik Web Beli Panel AWS Server! Buat infrastrukturnya dari Bahasa Programming Deklaratif Terraform berwujud File Ext .TF !',
                'content' => "<h3>1. Menulis Masa Depan Awan Server (File main.tf)</h3>\n<pre><code class=\"language-bash\"># Kita definisikan Siapa Penyedia Provider Komputasi Awannya? \nprovider \"aws\" {\n  region = \"us-east-1\"\n  # IAM Key Akun Bank AWS Anda / Key Public Rahasia\n  access_key = \"my-access-key\"\n  secret_key = \"my-secret-key\"\n}</code></pre>\n<h3>2. Mendefinisikan Objek Pembelian Resource VM</h3>\n<pre><code class=\"language-bash\"># Meminta Terraform untuk Memesan Komputer di Amazon \"aws_instance\" (Alias Nama Variable : web_aws_kita)\nresource \"aws_instance\" \"web_aws_kita\" {\n  # Kode OS Mesin Tipe Ubuntu 20\n  ami           = \"ami-0c55b159cbfafe1f0\"\n  # Spesifikasi Intel CPU Dan Ram tipe gratis Free-Tier AWS (t2-micro)\n  instance_type = \"t2.micro\"\n\n  tags = {\n    Name = \"ServerDewaBuatanTerraform\"\n  }\n}</code></pre>\n<h3>3. EKSEKUSI PENEMBAKKAN MAGIC!</h3>\n<pre><code class=\"language-bash\"># 1. Mendownload Driver Aws Ke Terraform Lokal (.init)\nterraform init\n\n# 2. Mengkalkulasi / Menelaah Script di masa depan jika di ekskuesi harganya berapa dll (.plan)\nterraform plan\n\n# 3. JREEENGGG!!! Mengeksekusi API Post Server AWS, Dalam 2 Menit Mesin 1Gbps Anda Telah Menyala Di New York via konsol (Auto Provision)! (.apply)\nterraform apply -auto-approve</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pengenalan Podman: Alternatif Docker Rootless (Keamanan Tinggi)',
                'slug' => Str::slug('Pengenalan Podman Alternatif Docker Rootless'),
                'category' => 'DevOps',
                'author' => 'DevSecOps',
                'read_time' => 7,
                'excerpt' => 'Docker Engine berjalan sebagai Root Daemon yang rentan Exploit. Podman buatan RedHat 100% kompatibel sintaks tapi berjalan aman Tanpa Daemon Induk (Tanpa Root)!',
                'content' => "<h3>1. Kekurangan Paradigma Docker Deamon</h3>\n<p>Docker Engine dikendalikan service perizinan <code>root</code> dari OS <code>/var/run/docker.sock</code>. Jika Anda menjalankan WebServer Nginx sebagai Container dan web itu diretas, Hacker bisa Lari menembus kontainer dan mengambil <i>Total Privilages Root Linux Server Asli</i> Anda. RedHat mengganti sistem ini dengan PODMAN!</p>\n<h3>2. Instalasi dan Mengganti Gaya</h3>\n<pre><code class=\"language-bash\">apt install podman -y\n\n# Anda Bisa menipu skrip program lama anda dengan Meng-Elish nama podman menjadi docker!!\nalias docker=podman\n</code></pre>\n<h3>3. Tembakan Keamanan Run Tanpa Sudo!</h3>\n<pre><code class=\"language-bash\"># Jika di docker anda perlu \"sudo docker run\", di podman Anda BOLEH menjalankanya dari ID User Miskin Biasa (non-root)!\npodman run -d --name web_ku_aman -p 8080:80 nginx:alpine</code></pre>\n<p>Container tersebut diisolasi spesifik dengan batas User UID biasa (Rootless mode namespace). Hacker meretasnya? Ia hanya mendapat hak CGroup Level miskin! Tidak pernah akan bisa merusak OS Root Utama!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
