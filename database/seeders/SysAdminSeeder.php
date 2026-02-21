<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SysAdminSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            // ==========================================
            // LINUX SYSTEM ARCHITECTURE & PERFORMANCE
            // ==========================================
            [
                'title' => 'Manajemen Proses Linux (htop, ps, kill)',
                'slug' => Str::slug('Manajemen Proses Linux htop ps kill'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 5,
                'excerpt' => 'Pelajari cara melacak performa CPU, menemukan service yang memakan RAM (Zombie Process), dan mematikan aplikasi secara paksa.',
                'content' => "<h3>1. Menggali Informasi dengan `ps` (Process Status)</h3>\n<pre><code class=\"language-bash\"># Menampilkan seluruh proses yang berjalan di latar belakang secara detail (User, PID, CPU%, Memory%)\nps aux\n\n# Memfilter pencarian hanya untuk melihat proses Apache2\nps aux | grep apache2</code></pre>\n<h3>2. Monitoring Real-time dengan `htop`</h3>\n<pre><code class=\"language-bash\"># Htop adalah versi modern dan berwarna dari perintah `top` klasik\napt install htop -y\nhtop\n# Anda bisa menekan tombol F9 di dalam htop untuk memilih proses dan membunuhnya (SIGKILL)</code></pre>\n<h3>3. Membunuh Proses Paksa (Kill)</h3>\n<pre><code class=\"language-bash\"># Jika Anda mengetahui nomor PID prosesnya (Misal 1045):\n# Sinyal -9 adalah SIGKILL (Bunuh instan tanpa menunggu proses menyimpan data)\nkill -9 1045\n\n# Membunuh massal menggunakan nama program (Cocok untuk menghabisi cluster aplikasi hang)\nkillall -9 nginx</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Menguasai File Archiving (Tar & Gzip)',
                'slug' => Str::slug('Menguasai File Archiving Tar Gzip'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 4,
                'excerpt' => 'Cara mengompres ribuan file website menjadi satu paket berukuran kecil untuk efisiensi transfer internet.',
                'content' => "<h3>1. Membuat Arsip Tarball Terkompresi</h3>\n<pre><code class=\"language-bash\"># -c : Create (Buat arsip baru)\n# -z : Menggunakan algoritma kompresi GZIP (Untuk memperkecil ukuran drastis)\n# -v : Verbose (Tampilkan daftar file saat proses pemaketan berjalan)\n# -f : File name (Tentukan nama arsip outputnya)\ntar -czvf website_backup.tar.gz /var/www/html/</code></pre>\n<h3>2. Mengekstrak Arsip</h3>\n<pre><code class=\"language-bash\"># -x : eXtract (Membongkar arsip)\n# -C : Change Directory (Tujuan ekstraksi dilempar ke folder spesifik)\ntar -xzvf website_backup.tar.gz -C /home/siswa/</code></pre>\n<h3>3. Melihat Isi Tanpa Membongkar</h3>\n<pre><code class=\"language-bash\"># -t : list (Menjadikan terminal sebagai penampil isi daftar file di dalam tarball)\ntar -tvf website_backup.tar.gz</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Monitoring Jaringan Lokal dengan Nmap',
                'slug' => Str::slug('Monitoring Jaringan Lokal dengan Nmap'),
                'category' => 'Security',
                'author' => 'Cybersecurity Analyst',
                'read_time' => 7,
                'excerpt' => 'Gunakan Nmap (Network Mapper) untuk mengaudit keamanan, mencari port yang terbuka, dan mendeteksi OS target.',
                'content' => "<h3>1. Instalasi Nmap</h3>\n<pre><code class=\"language-bash\">apt install nmap -y</code></pre>\n<h3>2. Scanning Port Dasar dan Aggressive</h3>\n<pre><code class=\"language-bash\"># Pemindaian standar (Hanya melihat port 1000 teratas yang terbuka)\nnmap 192.168.10.1\n\n# Mode Agresif (-A):\n# Menyalakan pendeteksi versi OS (OS detection), deteksi versi software/service yang jalan, dan script vulnerability dasar\nnmap -A 192.168.10.1</code></pre>\n<h3>3. Menemukan Perangkat yang Hidup (Ping Sweep)</h3>\n<pre><code class=\"language-bash\"># Daripada memindai port, fitur -sn HANYA mengirimkan paket Ping ICMP ke seluruh blok subnet (/24) untuk mencari kompi/HP yang tersambung wifi\nnmap -sn 192.168.10.0/24</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Manajemen Log System (Rsyslog & Journalctl)',
                'slug' => Str::slug('Manajemen Log System Rsyslog Journalctl'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 6,
                'excerpt' => 'Cara mencari penyebab Error (Troubleshooting) server yang Crash dengan membaca rekam jejak sistem.',
                'content' => "<h3>1. Melihat Log Tradisional (Tail)</h3>\n<pre><code class=\"language-bash\"># Kebanyakan aplikasi menulis buku laporannya di folder /var/log\n# Perintah `tail -f` (Follow) akan memantau baris terbawah file auth.log secara Real-Time\n# Sangat berguna untuk mendeteksi percobaan bruteforce secara live\ntail -f /var/log/auth.log\n\n# Melihat log Error pada web server Apache\ntail -n 50 /var/log/apache2/error.log  # (Menampilkan 50 baris terakhir)</code></pre>\n<h3>2. Diagnostik Modern dengan Journalctl</h3>\n<p>Di Debian 10+ / Systemd, semua log diurus secara tersentralisasi oleh journald.</p>\n<pre><code class=\"language-bash\"># Melihat pesan peringatan Booting OS / Kernel\njournalctl -k\n\n# Melihat kenapa service NGINX kemarin Gagal Start (Crash)\n# -u artinya Unit spesifik, -e artinya langsung scroll ke halaman bawah (End)\njournalctl -u nginx -e\n\n# Melihat log kejadian yang HANYA terjadi pada hari ini\njournalctl --since today</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // ==========================================
            // ADVANCED NETWORKING (MIKROTIK & CISCO)
            // ==========================================
            [
                'title' => 'Cisco Dasar: Setup Switch, VLAN & VTP (VLAN Trunking Protocol)',
                'slug' => Str::slug('Cisco Dasar Setup Switch VLAN VTP'),
                'category' => 'Networking',
                'author' => 'Cisco Network Admin',
                'read_time' => 9,
                'excerpt' => 'Mengenal Cisco IOS CLI. Mengonfigurasi VLAN dan mendistribusikannya otomatis ke puluhan Switch bawahan menggunakan VTP.',
                'content' => "<h3>1. Pengenalan Cisco CLI</h3>\n<p>Switch Cisco perlu di-konsol pakai kabel biru. Memiliki tingkatan mode: User (`>`), Privileged (`#`), dan Global Configuration (`(config)#`).</p>\n<pre><code class=\"language-bash\"># Masuk ke mode dewa (Privileged)\nenable\n# Masuk ke mode perombakan (Global Config)\nconfigure terminal\n\n# Memberikan nama perangkat\nhostname Switch-GedungA</code></pre>\n<h3>2. Membuat VLAN Manual (Di Switch Core)</h3>\n<pre><code class=\"language-bash\">vlan 10\n name GURU\nvlan 20\n name SISWA\nexit</code></pre>\n<h3>3. Konfigurasi VTP (VLAN Trunking Protocol)</h3>\n<p>Agar kita <b>TIDAK PERLU repot membuat ulang VLAN 10 dan 20 di 5 buah Switch lantai yang berbeda</b>, Cisco punya trik Sinkronisasi Database Otomatis bernama VTP!</p>\n<pre><code class=\"language-bash\"># PADA SWITCH CORE (SERVER UTAMA)\nvtp mode server\nvtp domain sekolahku.id\nvtp password rahasia\n\n# PADA SWITCH LANTAI (CLIENT/PENERIMA)\nvtp mode client\nvtp domain sekolahku.id\nvtp password rahasia</code></pre>\n<p>Asalkan jalur kabel penghubung antar Switch diset <code>switchport mode trunk</code>, maka Switch Client akan <b>TERHIPNOTIS</b> dan meng-copy total database Vlan milik Core secara otomatis detik itu juga!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'MikroTik BGP (Border Gateway Protocol) Dasar',
                'slug' => Str::slug('MikroTik BGP Border Gateway Protocol Dasar'),
                'category' => 'Networking',
                'author' => 'Network Architect',
                'read_time' => 11,
                'excerpt' => 'Protokol jalan raya Internet Dunia! Pengenalan cara bertukar tabel IP raksasa antar perusahaan dengan BGP di Mikrotik RouterOS.',
                'content' => "<h3>Apa Itu BGP?</h3>\n<p>Jika OSPF dipakai di dalam 1 lingkungan kampus (Interior Protocol), maka BGP dipakai untuk menyambungkan Kampus Anda dengan Jaringan Google, Facebook, dan Provider Telkom (Exterior Protocol). Internet tidak akan jalan tanpa BGP!</p>\n<h3>Konfigurasi eBGP Peer v7 (External BGP)</h3>\n<p>Anda mewakili AS (Autonomous System / Nomor Plat Perusahaan) 65001. Lawan anda (ISP) AS 65002.</p>\n<pre><code class=\"language-bash\"># Mengeset AS Number perusahaan Anda sendiri di Router\n/routing bgp template\nset default as=65001 router-id=10.10.10.1\n\n# Membuat Titik Sambungan (Peering) ke Router ISP tetangga (AS 65002)\n/routing bgp connection\nadd name=to-ISP remote.address=10.10.10.2 .as=65002 local.role=ebgp</code></pre>\n<h3>Meng-Advertise (Mengumumkan IP) Network Anda</h3>\n<pre><code class=\"language-bash\"># Memberitahu Dunia (Google, tetangga, dll) bahwa \"Hei, IP Publik 202.1.1.0/24 ini adalah MILIK SAYA! Lewat sini kalau mau ke Website Ini!\"\n/routing bgp network\nadd network=202.1.1.0/24</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Load Balancing Mikrotik Metode PCC (Per Connection Classifier)',
                'slug' => Str::slug('Load Balancing Mikrotik Metode PCC'),
                'category' => 'Networking',
                'author' => 'Network Engineer',
                'read_time' => 12,
                'excerpt' => 'Punya 2 Jalur Internet (Telkom & Biznet)? Gabungkan tegangannya agar ngebut secara adil (Load Balance) menggunakan metode Mangle PCC.',
                'content' => "<h3>Masalah Multi-WAN</h3>\n<p>Router hanya setia pada 1 Gateway (ISP utama). ISP 2 akan nganggur. Kita harus memaksa Router MENCEKIK setiap koneksi yang lewat, lalu melempar koneksi Ganjil ke ISP 1, koneksi Genap ke ISP 2.</p>\n<h3>1. Policy Routing Mangle (Otaknya PCC)</h3>\n<pre><code class=\"language-bash\">/ip firewall mangle\n# Menerima traffik dari Jaringan Lokal untuk dinilai\nadd chain=prerouting in-interface=LAN action=accept dst-address-list=LOKAL_IP\n\n# RUMUS PCC ALGORITMA: Membagi arus berdasarkan perpaduan IP Pengirim dan Tujuan (src-address-dst-address)\n# \"2/0\" artinya dari 2 buah jalur ISP, ini untuk rute nomor Urut 0 (Jalur Pertama)\nadd chain=prerouting in-interface=LAN connection-mark=no-mark action=mark-connection new-connection-mark=ISP1_conn per-connection-classifier=src-address-dst-address:2/0\n\n# \"2/1\" artinya dari 2 buah ISP, ini rute nomor Urut 1 (Jalur Kedua)\nadd chain=prerouting in-interface=LAN connection-mark=no-mark action=mark-connection new-connection-mark=ISP2_conn per-connection-classifier=src-address-dst-address:2/1\n\n# Menyematkan Routing Mark (Tanda Rute)\nadd chain=prerouting in-interface=LAN connection-mark=ISP1_conn action=mark-routing new-routing-mark=ke_ISP_1\nadd chain=prerouting in-interface=LAN connection-mark=ISP2_conn action=mark-routing new-routing-mark=ke_ISP_2</code></pre>\n<h3>2. Eksekusi Pembelokan (Routing Rules)</h3>\n<pre><code class=\"language-bash\">/ip route\n# Jika sebuah paket memiliki tanda Stempel 'ke_ISP_1', lemparkan secara Diktaktor lewat Pintu 10.10.10.1\nadd dst-address=0.0.0.0/0 gateway=10.10.10.1 routing-mark=ke_ISP_1 check-gateway=ping\n\n# Jika Stempelnya 'ke_ISP_2', belokan paksa lewat Pintu Biznet 20.20.20.1\nadd dst-address=0.0.0.0/0 gateway=20.20.20.1 routing-mark=ke_ISP_2 check-gateway=ping</code></pre>\n<p>Kehandalan (Failover) akan terjamin. Jika kabel ISP 1 putus tergigit tikus, gateway ping akan putus, dan routing otomatis lumpuh/pindah semua ke ISP 2.</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // DOCKER MASTERCLASS & VM
            // ==========================================
            [
                'title' => 'Docker Image Creation: Menulis Dockerfile',
                'slug' => Str::slug('Docker Image Creation Menulis Dockerfile'),
                'category' => 'Debian Server',
                'author' => 'DevOps Engineer',
                'read_time' => 8,
                'excerpt' => 'Berhenti menggunakan Image orang lain dari Docker Hub. Buatlah sistem Docker kustom (Custom Image) sendiri yang berisi aplikasi Node.js/Python milik anda.',
                'content' => "<h3>1. Struktur File (Aplikasi Node.JS Simpel)</h3>\n<p>Di folder project Anda, buat file bernama <code>Dockerfile</code> tanpa ekstensi apapun.</p>\n<pre><code class=\"language-dockerfile\"># 1. Mendefinisikan Base Image OS (Sistem pondasi awal kita ambil OS Node Alpine yang ringan, under 50mb!)\nFROM node:18-alpine\n\n# 2. Mendeklarasikan direktori mana yang mau kita kerjai di dalam container docker virtual nanti\nWORKDIR /usr/src/app\n\n# 3. Mengcopy file package.json (Dependency) dari folder laptop asli KEDALAM image container\nCOPY package.json ./\n\n# 4. Menjalankan perintah instalasi modul di dalam rahim Container\nRUN npm install\n\n# 5. Mengcopy sisa kode source programming (index.js, router) kedalam Container\nCOPY . .\n\n# 6. Membuka lubang pernafasan (Port Expose) agar app bisa terbaca\nEXPOSE 3000\n\n# 7. Mantra terakhir: Perintah pamungkas saat Container di jalankan\nCMD [ \"node\", \"index.js\" ]</code></pre>\n<h3>2. Proses Build (Memasak Image)</h3>\n<pre><code class=\"language-bash\"># Mengeksekusi resep Dockerfile di folder saat ini (.) dan memberi Nama Tag Image nya (-t)\ndocker build -t aplikasiku-presensi:v1.0 .</code></pre>\n<h3>3. Menjalankan Base Image Baru Milik Sendiri!</h3>\n<pre><code class=\"language-bash\">docker run -d -p 80:3000 aplikasiku-presensi:v1.0</code></pre>\n<p>Boom! Image ini sepenuhnya portabel dan bisa di export ke Flashdisk lalu di jalankan di Server manapun di seluruh dunia tanpa harus memikirkan versi OS nya!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Manajemen Virtual Machine Linux via KVM/QEMU CLI',
                'slug' => Str::slug('Manajemen VM Linux via KVM QEMU CLI'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 10,
                'excerpt' => 'Virtualisasi murni (Bare-metal level) murni dari hitam putih terminal terminal Shell. Install VM guest tanpa GUI Proxmox!',
                'content' => "<h3>1. Instalasi Mesin Inti KVM (Kernel-Based Virtual VM)</h3>\n<pre><code class=\"language-bash\"># Libvirt adalah daemon penjaga komunikasi virtualisasi yang sangat handal\napt install qemu-kvm libvirt-daemon-system libvirt-clients bridge-utils virtinst -y</code></pre>\n<h3>2. Menciptakan VM Lewat 1 Perintah Terminal Sakti</h3>\n<pre><code class=\"language-bash\"># Perintah `virt-install` digunakan untuk proses provision.\n# Bayangkan anda sedang menyetel spesifikasi RAM di VirtualBox, namun ini bentuk Teks!\nvirt-install \\\n  --name WebServer-Ubuntu \\\n  --ram 2048 \\\n  --vcpus 2 \\\n  --disk path=/var/lib/libvirt/images/web-ubuntu.qcow2,size=20 \\\n  --os-variant ubuntu20.04 \\\n  --network network=default \\\n  --graphics none \\\n  --console pty,target_type=serial \\\n  --location 'http://archive.ubuntu.com/ubuntu/dists/focal/main/installer-amd64/' \\\n  --extra-args 'console=ttyS0,115200n8 serial'</code></pre>\n<p>Begitu dienter, OS Installer Ubuntu Text-Mode akan muncul <b>secara ajaib</b> langsung di tengah-tengah Bash Terminal linux anda, memanfaatkan port COM1 Serial bawaan dari engine `--extra-args`!!</p>\n<h3>3. Pengelolaan Keseharian VM Dasar (virsh)</h3>\n<pre><code class=\"language-bash\">virsh list --all          # Melihat semua VM baik yg nyala maupun mati\nvirsh start WebServer     # Menghidupkan Paksa VM\nvirsh shutdown WebServer  # Mematikan aman\nvirsh destroy WebServer   # Mencabut kabel power paksa pada VM (Hard Reset)</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // WINDOWS SERVER LAYER & ACTIVE DIRECTORY
            // ==========================================
            [
                'title' => 'Windows Server: DFS (Distributed File System) Namespace & Replikasi',
                'slug' => Str::slug('Windows Server DFS Namespace dan Replication'),
                'category' => 'Windows Server',
                'author' => 'IT Infrastructure Specialist',
                'read_time' => 9,
                'excerpt' => 'Punya 3 file server di 3 kota berbeda? Satukan dalam 1 path seragam (Namespace) dan sinkronisasikan isinya (Replication/Rsync versi Windows).',
                'content' => "<h3>1. Kasus dan Tujuan Trik Singkat</h3>\n<p>Ada server `\\\\SERVER-MKT` di Makassar dan `\\\\SERVER-JKT` di Jakarta. Karyawan yang mutasi kota pusing karena nama Folder Sharing-nya beda-beda. Dengan <b>DFS Namespace</b>, kita buat 1 alamat palsu virtual universal: `\\\\perusahaan.local\\DataBersama` yang mewakili keduanya. Jika klien asal Makassar mengaksesnya, ia otomatis diarahkan ke `\\\\SERVER-MKT`!!</p>\n<h3>2. Instalasi Fitur Khusus DFS</h3>\n<pre><code class=\"language-powershell\"># Eksekusi role install \nInstall-WindowsFeature -Name FS-DFS-Namespace, FS-DFS-Replication -IncludeManagementTools</code></pre>\n<h3>3. Membuat Namespace Akar (Virtual Root)</h3>\n<pre><code class=\"language-powershell\"># Kita menunjuk SERVER-DC agar melayani akses direktori root terpusat yang bernama 'DataKorporat'\nNew-DfsnRoot -Path \"\\\\perusahaan.local\\DataKorporat\" -TargetPath \"\\\\SERVER-DC\\FolderDfsRoot\" -Type DomainV2</code></pre>\n<h3>4. Add Folder Link (Mapping)</h3>\n<pre><code class=\"language-powershell\"># Menautkan file server asli (Backend Jakarta dan Makassar) kedalam jalur semu namespace\nNew-DfsnFolder -Path \"\\\\perusahaan.local\\DataKorporat\\Marketing\"\nNew-DfsnFolderTarget -Path \"\\\\perusahaan.local\\DataKorporat\\Marketing\" -TargetPath \"\\\\SERVER-JKT\\DataMkt_Asli\"\nNew-DfsnFolderTarget -Path \"\\\\perusahaan.local\\DataKorporat\\Marketing\" -TargetPath \"\\\\SERVER-MKT\\DataMkt_Asli\"</code></pre>\n<p>Lalu aktifkan *DFS Replication Group* agar data di dalam folder `SERVER-JKT` akan senantiasa di copy ke `SERVER-MKT` dibalik layar!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'GPO (Group Policy) Lanjut: Pemetaan Network Drive Otomatis',
                'slug' => Str::slug('GPO Lanjut Pemetaan Network Drive Otomatis'),
                'category' => 'Windows Server',
                'author' => 'System Administrator',
                'read_time' => 5,
                'excerpt' => 'Mengapa karyawan sering telpon IT? "Mas, drive Z:// saya hilang!". Hapus kebiasaan map drive manual. Paksa sinkronisasi memakai GPO Drive Maps.',
                'content' => "<h3>1. Konsep Utama GPO Map Drive</h3>\n<p>Setiap Karyawan bagian HRD saat menghidupkan dan masuk ke layar OS Windows 10, secara Ghaib Folder Share HRD <code>\\\\DC-Server\\Data_HRD</code> akan menyala sebagai partisi <b>(Z:)</b> terpasang otomatis di My Computer mereka!</p>\n<h3>2. Konfigurasi Pada Group Policy Editor</h3>\n<p>Buat Policy di OU HRD. Lalu telusuri jalan hirarki ini (INI BUKAN POLICY, INI PREFERENCES!):</p>\n<ul>\n<li><code>User Configuration</code> > <code>Preferences</code> > <code>Windows Settings</code> > <code>Drive Maps</code></li>\n<li>Klik Kanan Layar Kosong -> <b>New > Mapped Drive</b></li>\n</ul>\n<h3>3. Inject Data Mapped Drive</h3>\n<pre><code class=\"language-yaml\"># Properti Jendela Drive Map:\nAction      : Replace          # Artinya menimpa Drive Z walau ada yang menyangkut\nLocation    : \\\\DC-SERVER\\Data_HRD  # Titik Asal Sharing Asli di Server\nReconnect   : [V] Dicawang     # Mode Persistent walau direstart PC nya tetap nempel\nLabel as    : Ruang Data HRD   # Nama kosmetik di My Computernya Client\nUse Letter  : Z                # Tancapkan sebagai partisi disk 'Z:'</code></pre>\n<p>Dan *Voila!* Anda tidak perlu lagi masuk remote Teamviewer keliling unit PC Karyawan hanya untuk menahan malu klik kanan 'Map Network Drive' seperti orang manual. Best Practices di Industri Korporat multinasional!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // FULL STACK DEVOPS / DB ADMIN
            // ==========================================
            [
                'title' => 'MySQL / MariaDB Dasar: Manajemen User dan Hak Akses',
                'slug' => Str::slug('MySQL MariaDB Dasar Manajemen User dan Hak Akses'),
                'category' => 'Database',
                'author' => 'Database Administrator',
                'read_time' => 7,
                'excerpt' => 'Membangun pertahanan SQL! Cara membuat kredensial Database User baru, menunjuk password, dan melimitasi hak akses (Privileges).',
                'content' => "<h3>1. Instalasi dan Masuk Engine</h3>\n<pre><code class=\"language-bash\">apt install mariadb-server -y\n# Mengamankan Instalasi (Menyetel sandi ROOT DBMS dan membersihkan user anonim berbahaya)\nmariadb-secure-installation\n\n# Masuk ke terminal query engine (Tanda prompt akan berubah jadi `MariaDB >`)\nmysql -u root -p</code></pre>\n<h3>2. Menciptakan User Baru dan Spesifikasi Origin</h3>\n<pre><code class=\"language-sql\">-- User DevJunior hanya boleh konek dari localhost (Terminal yang sama)\nCREATE USER 'devjunior'@'localhost' IDENTIFIED BY 'sandiAman12';\n\n-- User RemoteAdmin (Bos Besar) diizinkan meremote DB jarak jauh dari komputer IP berapapun (%)\nCREATE USER 'remoteadmin'@'%' IDENTIFIED BY 'sandiMasterX!19';</code></pre>\n<h3>3. Manajemen Privileges (Hak Istimewa) GRANT & REVOKE</h3>\n<p>Jangan pernah asal membagikan akses `ALL PRIVILEGES` mematikan!</p>\n<pre><code class=\"language-sql\">-- DevJunior hanya bisa MELIHAT Data dan NAMBAHKAN data di tabel Karyawan pada database HRIS.\n-- Tapi TIDAK BOLEH MENGHAPUS / DELETE drop table!\nGRANT SELECT, INSERT ON db_hris.tbl_karyawan TO 'devjunior'@'localhost';\n\n-- Hak akses Bos Besar memegang kekuasaan dewa penuh (*.* Semua Databae, Semua Tabel)\nGRANT ALL PRIVILEGES ON *.* TO 'remoteadmin'@'%' WITH GRANT OPTION;\n\n-- Menerapkan pembaharuan izin di RAM database.\nFLUSH PRIVILEGES;</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Continuous Integration / Continuous Deployment (CI/CD) via GitLab',
                'slug' => Str::slug('CI CD via GitLab'),
                'category' => 'DevOps',
                'author' => 'DevOps Engineer',
                'read_time' => 10,
                'excerpt' => 'Percepat Rilis Software Perusahaan. Automasi pengetesan kode App dan mengirimkannya ke Production Server secara gaib setiap kita melakukan Git Push.',
                'content' => "<h3>1. Apa itu Proses CI/CD pipeline?</h3>\n<p>Dulu, programmer harus copy file zip FTP ke VPS. Sekarang dengan CI (Continuous Integration), Gitlab akan otomatis mengetes script (misal menjalankan PHPUnit Test) ketika ada revisi <code>git push</code>. Dan dengan CD (Continuous Deployment), Gitlab akan otomatis membangun kontainer dan men-deploy nya ke Server AWS secara otomatis tanpa campur tangan orang!</p>\n<h3>2. Menyebar Runner Daemon</h3>\n<p>Server GitLab pusat tidak mengeksekusi script. Anda butuh 'Budak' di Server Production OS yaitu <b>GitLab Runner</b>.</p>\n<pre><code class=\"language-bash\"># Masuk ke server Debian Production\ncurl -L \"https://packages.gitlab.com/install/repositories/runner/gitlab-runner/script.deb.sh\" | bash\napt install gitlab-runner -y\n\n# Mempair Token Budak ini ke Repository Project GitLab Master\ngitlab-runner register --url https://gitlab.com/ --registration-token XyZToken123</code></pre>\n<h3>3. Mendesain <code>.gitlab-ci.yml</code></h3>\n<p>Tumbalkan file sakral ini di ujung folder project programer.</p>\n<pre><code class=\"language-yaml\">stages:\n  - build\n  - deploy\n  \n# TAHAP 1: Merakit (Mendownload Vendor/Node_modules)\njob_build:\n  stage: build\n  script:\n    - echo \"Melakukan instalasi ketergantungan Composer / NPM..\"\n    - npm install\n    - npm run build\n    \n# TAHAP 2: Mengkopi Hasil Build ke Root Web Server (RILIS KE DUNIA)\njob_deploy:\n  stage: deploy\n  # Menjalankan spesifik ke Runner Tag milik Production Server yang kita pasang diatas tadi\n  tags:\n    - my-production-server\n  script:\n    - echo \"Restarting Web Service ...\"\n    - cp -r ./dist/* /var/www/html/app_kantor/\n    - systemctl restart nginx\n  # Hanya akan RILIS otomatis jika programernya update di cabang (branch) MAIN!\n  only:\n    - main</code></pre>\n<p><b>Apes!</b> Bila tahap build error, proses Deploy langsung dibatalkan sistem, server selamat dari malapateka kode buatan programmer intern ceroboh!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // ==========================================
            // STORAGE & BACKUP ADVANCED
            // ==========================================
            [
                'title' => 'Sinkronisasi Folder Jauh dengan Rsync (Linux)',
                'slug' => Str::slug('Sinkronisasi Folder Jauh dengan Rsync'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 5,
                'excerpt' => 'Kopi Paste Ribuan File? Lupakan Copy Manual (cp/scp)! Rsync bisa melanjutkan proses copy yang putus asalkan beda 1 bit!',
                'content' => "<h3>1. RSYNC vs SCP</h3>\n<p>SCP akan mengkopi 100GB secara membabi buta dari nol meski file sudah ada 99GB pada target server. Rsync pintar membaca Algoritma Delta, Dia HANYA mentransfer file yang termodifikasi / potongan bit file yang berbeda di hari berikutnya! Super Ringan di koneksi Internet!</p>\n<h3>2. Penggunaan Rsync Lokal Ke Lokal</h3>\n<pre><code class=\"language-bash\"># -a : Archive (Mempertahankan attribute dan owner permissions filenya agar tak berubah, serta rekursif masuk subfolder kedalamnya)\n# -v : Verbose (Menampilkan pergerakan nama file di layar)\n# -z : Compress (Kompres di udara sebelum dilempar)\nrsync -avz /home/siswa/website /backup_local/</code></pre>\n<h3>3. Rsync Menyebrang Ke Server Jauh Via SSH Push</h3>\n<pre><code class=\"language-bash\"># Perintah mendaratkan folder /var/www/ Asal milik kita menuju pelukan mesra Folder Root /backup milik Server IP 10.10.10.2!\nrsync -avz -e \"ssh -p 22\" /var/www/html/ root@10.10.10.2:/backup_di_seberang/ \n\n# -e = Memberitahu rsync agar menggunakan protokol Tunnel enkripsi SSH spesifik port 22 saat numpang jalan!\n# --delete = (Bahaya opsional) Flag yang memaksa keadaan Mirror Total. Jika di Folder Asal dihapus, Target Jauh akan IKUT TERHAPUS!</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sistem File ZFS (The Ultimate Storage Platform)',
                'slug' => Str::slug('Sistem File ZFS Dasar Enterprise Storage'),
                'category' => 'Debian Server',
                'author' => 'Data Center Specialist',
                'read_time' => 8,
                'excerpt' => 'Mengawinkan kemudahan Volume-Manager dengan Reliabilitas sistem File yang Tahan Tipu. Tinggalkan mdadm (Raid software lama)!',
                'content' => "<h3>Apa itu ZFS (Zettabyte File System)?</h3>\n<p>ZFS adalah The King of File System buatan Sun Microsystem. Dia mencegah 'Bit Rot' atau kebususan data korup di sekctor harddisk yang didiamkan bertahun-tahun dengan mekanisme checksum mandiri di setiap gigabytenya (Self-Healing Copy-on-Write)!</p>\n<h3>1. Implementasi Pool (Mirror / RAID 1 Array)</h3>\n<pre><code class=\"language-bash\">apt install zfsutils-linux -y\n\n# Asumsi kita masukkan 2 Harddisk Kosong kapasitas 1 TeraByte (sdX, sdY)\n# Zpool akan membuat kolam Volume raksasa bernama kolam_sakral yang berisikan replikator kembar Mirroring!\nzpool create kolam_sakral mirror /dev/sdX /dev/sdY</code></pre>\n<h3>2. ZFS Snapshot & Rollback Sekejap Mata</h3>\n<p>Karena Copy-On-Write, melakukan Backup status server yang berukuran 5 TB pada ZFS hanya membutuhkan 1 DETIK waktu eksekusi Bash Command!!</p>\n<pre><code class=\"language-bash\"># MEREKAM keadaan kolam sekarang (Contoh dinamai checkpoint1)\nzfs snapshot kolam_sakral@checkpoint1\n\n# Walah Server Terinfeksi Ransomeware pada Jam 3 Sore Ini!\n# ...Tidak masalah, pulihkan total keadaan sistem kita persis utuh 100% seperti keadaan @checkpoint1 dalam waktu 2 detik via perintah Rollback!!\nzfs rollback kolam_sakral@checkpoint1</code></pre>\n<p>Kemewahan yang ditawarkan Proxmox VE sangat bergantung pada kecanggihan format Harddisk ZFS ini di backend Virtualisasinya!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // IT SERVICE MANAGEMENT & HELPDESK
            // ==========================================
            [
                'title' => 'Membangun Tiket Helpdesk Lokal (GLPI)',
                'slug' => Str::slug('Membangun Tiket Helpdesk Lokal GLPI'),
                'category' => 'Debian Server',
                'author' => 'IT Support Coordinator',
                'read_time' => 7,
                'excerpt' => 'Tinggalkan metode pelaporan kerusakan IT via grup WhatsApp! Bangun sistem pertiketan ITIL compliant menggunakan GLPI.',
                'content' => "<h3>1. Arsitektur GLPI (Gestionnaire Libre de Parc Informatique)</h3>\n<p>GLPI hanyalah Website berbahasa PHP murni. Anda harus memiliki Web Server (Apache) + Mariadb DB. Semua pegawai dari komputer client akan mengakses Web intranet ini untuk mengklik \"Buat Tiket Keluhan Baru\".</p>\n<h3>2. Proses Deployment Awal</h3>\n<pre><code class=\"language-bash\"># 1. Pastikan LAMP Stack Terinstal (Linux, Apache, Mysql, Php versi modern)\napt install apache2 libapache2-mod-php mariadb-server php-xml php-common php-json php-curl php-mbstring php-mysql php-gd php-intl php-ldap php-apcu php-xmlrpc php-bz2 php-zip -y\n\n# 2. Unduh Source Code GLPI yang terbaru dan Ekstrak paksa di Htdocs\nwget https://github.com/glpi-project/glpi/releases/download/10.0.9/glpi-10.0.9.tgz\ntar -xzvf glpi-*.tgz -C /var/www/html/</code></pre>\n<h3>3. Merubah Hak Akses Ownership Folder Apache</h3>\n<pre><code class=\"language-bash\"># Memberikan kepemilikan folder instalasi glpi kepada 'www-data' (Nama User Anonim khusus aplikasi apache/nginx debian!)\nchown -R www-data:www-data /var/www/html/glpi\nchmod -R 755 /var/www/html/glpi</code></pre>\n<h3>4. Konfigurasi GUI</h3>\n<p>Setelah database MySQL diisi kosong. Datangi portal instalasi di browser klien: <code>http://IP_Server/glpi/install/install.php</code>. Aplikasi Helpdesk Profesional ini sekarang siap menerima komplain pertama karyawan dan melacak inventory (Mouse, Keyboard, Monitor Asset) perusahaan Anda!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // ==========================================
            // DEVOPS TOOLS
            // ==========================================
            [
                'title' => 'Manajemen Konfigurasi via Git Version Control',
                'slug' => Str::slug('Manajemen Konfigurasi via Git Version Control'),
                'category' => 'DevOps',
                'author' => 'Software Engineer',
                'read_time' => 8,
                'excerpt' => 'Semua SysAdmin Wajib Tahu GIT! Manajemen revisi sistem konfigurasi dan infrastruktur dengan kolaborasi kontrol versi.',
                'content' => "<h3>1. Git Dasar (The Savior)</h3>\n<p>Anda mengedit file /etc/bind/named.conf, namun besok server DNS anda ERROR dan hancur. Anda Lupa baris keberapa saja yang kemarin di tambahkan. Dengan GIT di level root, setiap edit bisa dikembalikan (revert) semudah menjentikkan jari.</p>\n<pre><code class=\"language-bash\"># Inisialisasi awal di folder (misal projek config website)\ngit init\n\n# Melacak semua barang/perubahan dari titik terakhir (. dot = semuanya)\ngit add .\n\n# Mematenkan (Commit) perubahan sementara tersebut dan berikan Label Komentar\ngit commit -m \"Menyetel fitur Vhost pada file /etc/nginx/sites-available\"\n\n# Menghubungkannya ke cloud penyimpanan seperti GitHub \ngit remote add origin https://github.com/namakamu/konfig-server-kantor.git\ngit push -u origin master</code></pre>\n<h3>2. Cabang Eksperimental (Branch)</h3>\n<pre><code class=\"language-bash\"># Jika anda ragu dengan uji coba modifikasi kode anda, buat Cermin Dunia Paralel (Branch)\ngit checkout -b eksperimen_fitur_ssl\n\n# Asiknya, error separah apapun di branch eksperimen TIDAK AKAN merusak stabilitas branch utama (Master)\n# Jika sudah sukses tak ada bug, gabungkan ke alam semesta asalnya (Merge)!\ngit checkout master\ngit merge eksperimen_fitur_ssl</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // NETWORKING VPN Lanjutan
            // ==========================================
            [
                'title' => 'Membangun OpenVPN Server (Metode Kuno Tapi Aman)',
                'slug' => Str::slug('Membangun OpenVPN Server'),
                'category' => 'Security',
                'author' => 'Security Specialist',
                'read_time' => 9,
                'excerpt' => 'Otentikasi Keras kepala VPN Layer 3 dan enkripsi kelas Perbankan AES-256 menggunakan PKI (Public Key Infra) Sertifikat Authority.',
                'content' => "<h3>1. Kenapa Masih OpenVPN?</h3>\n<p>Meskipun berat, OVPN paling kaya fitur dibandingkan L2TP, IPSEC. Bisa diinject (Trik fakepayload bypass firewall), mendukung TCP port 443 sehingga bisa menembus proxy kantor manapun yang menutup udp.</p>\n<h3>2. Instalasi Easy-RSA dan Pembangunan CA Master</h3>\n<pre><code class=\"language-bash\">apt install openvpn easy-rsa -y\n\n# Memecah folder persiapan Pembangkitan Sertifikat\nmake-cadir ~/openvpn-ca\ncd ~/openvpn-ca\n\n# Menginisiasi Pohon CA root dan Menulis Key Rahasia Privat untuk menerbitkannya\n./easyrsa init-pki\n./easyrsa build-ca # Anda akan dituntut membuat passphrase password Gembok!</code></pre>\n<h3>3. Membuat Sertifikat Anak (Kunci Server & Kunci Client Handphonemu!)</h3>\n<pre><code class=\"language-bash\"># Membangkitkan Keypass Server Gatewaynya agar dipercayai CA Master Utama\n./easyrsa gen-req server_vpnku nopass\n./easyrsa sign-req server server_vpnku\n\n# Membangkitkan Keypass Paspor Clientnya untuk Laptop Bos Anda (Berikan ekstensi nopass agar beliau tdk direpotkan passphase saat klik connnect)\n./easyrsa gen-req BosBesar_Client nopass\n./easyrsa sign-req client BosBesar_Client</code></pre>\n<p>Hasil <code>.crt</code>, <code>.key</code> dan CA induk <code>ca.crt</code> lalu kita salibkan/injeksi ke dalam format template standar config OpenVPN berektensi <code>.ovpn</code>. Config matangnya ini yang kemudian anda berikan ke Laptop klien (OpenVPN Connect Gui).</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // BASH SCRIPTING ADVANCED
            // ==========================================
            [
                'title' => 'Bash Scripting Lanjut: Penggunaan Looping dan Variabel',
                'slug' => Str::slug('Bash Scripting Penggunaan Looping dan Variabel'),
                'category' => 'Debian Server',
                'author' => 'System Programmer',
                'read_time' => 6,
                'excerpt' => 'Cara merancang aplikasi CLI kecil (Terminal App) milik anda sendiri dengan percabangan Logika Array perulangan murni.',
                'content' => "<h3>1. Logika Perulangan Dinamis (FOR-LOOP)</h3>\n<p>Kasus: Guru Minta Dibuatkan User Debian Cepat dari Daftar 100 Siswa. Buat <code>nano auto-create-user.sh</code></p>\n<pre><code class=\"language-bash\">#!/bin/bash\n\n# Membuat Daftar Variabel Array\nDAFTAR_NAMA=(\"budi\" \"tono\" \"putri\" \"zain\")\n\n# Membongkar Array dan Mengulang Eksekusi hingga tuntas per Elemen\nfor SISWA in \"\${DAFTAR_NAMA[@]}\"\ndo\n    echo \"Mengeksekusi pembuatan ID Linux untuk User: \$SISWA ...\"\n    # Perintah memanggil sintaks Asli Debian (-m : Paksa buatkan directory root Userhome)\n    useradd -m \$SISWA\n    # Mensetel password default sama dengan namanya namun diam diam / quiet di console chpasswd\n    echo \"\$SISWA:\$SISWA\" | chpasswd\n    echo \"[!] SUKSES.\"\ndone</code></pre>\n<h3>2. Interaksi dengan Input Parameter Command Pilihan CLI</h3>\n<pre><code class=\"language-bash\">#!/bin/bash\necho \"Aplikasi Reset Password Massal V.1\"\n\n# \$1 adalah argumen input pertama saat orang mengeksekusi script ini (Misal: ./script.sh Argumen_Target)\nif [ -z \"\$1\" ]\nthen\n  echo \"ERROR: Coba sebutkan Nama Sekolahnya! (Contoh: ./reset.sh SMA1)\"\n  exit 1\nelse\n  echo \"Meriset seluruh database milik Parameter ke-1 yaitu: \$1\"\n  # ... Aksi perintah lain\n  exit 0\nfi</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // ==========================================
            // WINDOWS SERVER POWERSHELL
            // ==========================================
            [
                'title' => 'Powershell Server Administration Dasar',
                'slug' => Str::slug('Powershell Server Administration Dasar'),
                'category' => 'Windows Server',
                'author' => 'Automation Engineer',
                'read_time' => 7,
                'excerpt' => 'Tinggalkan GUI yang lambat! Gunakan Powershell (Framework Modern Object Oriented Microsoft) menggantikan CMD jadul.',
                'content' => "<h3>1. Dasar Syntax Cmdlet (Verb-Noun)</h3>\n<p>Powershell mudah ditebak karena semua seragam pakai bahasa kerja <i>(Aksi-Tujuan)</i>, Misal: <b>Get-</b> (Mengambil), <b>Set-</b> (Mensetting), <b>New-</b> (Membuat).</p>\n<pre><code class=\"language-powershell\"># \"Mendapatkan\" informasi tentang \"Proses\" Service\nGet-Process\n\n# Terlalu banyak memakan layar? Lempar (Pipe) Objek ke filter pencari Where-Object (\$_) dan periksa memory (WS)\nGet-Process | Where-Object { \$_.WS -gt 50MB }\n\n# Ingin Stop Service Hang (Misal Print Spooler)?\nStop-Service -Name \"Spooler\" -Force</code></pre>\n<h3>2. Manajemen Jaringan Lapis Bawah Server Core</h3>\n<p>Ketika anda memecat fitur GUI Windows Server Desktop Experience (Tersisa Teks Biru Polos CMD di layar fisik). Disitulah anda Wajib pakai PS CLI.</p>\n<pre><code class=\"language-powershell\"># Melihat Daftar ID colokan Ethernet\nGet-NetAdapter\n\n# Mengganti Manual IP ke Statis Static Port ID nomor 3 (Ethernet)\nNew-NetIPAddress -InterfaceIndex 3 -IPAddress 192.168.1.10 -PrefixLength 24 -DefaultGateway 192.168.1.1\nSet-DnsClientServerAddress -InterfaceIndex 3 -ServerAddresses (\"8.8.8.8\",\"1.1.1.1\")</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
