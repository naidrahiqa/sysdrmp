<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExtraSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Membangun Mail Server (Postfix & Dovecot)',
                'slug' => Str::slug('Membangun Mail Server Postfix dan Dovecot'),
                'category' => 'Debian Server',
                'author' => 'SysAdmin',
                'read_time' => 12,
                'excerpt' => 'Membangun layanan komunikasi email lokal lengkap dengan protokol SMTP (Postfix) dan IMAP/POP3 (Dovecot).',
                'content' => "<h3>1. Instalasi Postfix & Dovecot</h3>\n<pre><code class=\"language-bash\">apt install postfix dovecot-core dovecot-imapd dovecot-pop3d -y</code></pre>\n<h3>2. Konfigurasi SMTP (Postfix)</h3>\n<pre><code class=\"language-bash\"># Mengkonfigurasi tempat penyimpanan format kotak surat ke gaya folder standar (Maildir)
postconf -e 'home_mailbox= Maildir/'\nsystemctl restart postfix</code></pre>\n<h3>3. Konfigurasi IMAP/POP3 (Dovecot)</h3>\n<p>Edit <code>/etc/dovecot/conf.d/10-mail.conf</code>:</p>\n<pre><code class=\"language-ini\"># Menunjukkan tempat server IMAP membaca kumpulan email milik user\nmail_location = maildir:~/Maildir</code></pre>\n<p>Edit <code>/etc/dovecot/conf.d/10-auth.conf</code>:</p>\n<pre><code class=\"language-ini\"># Disable ke false agar diizinkan otentikasi login email dengan Plain-Text (Karena blm pakai SSL CA Valid)\ndisable_plaintext_auth = no\nauth_mechanisms = plain login</code></pre>\n<h3>4. Tambah User Karyawan & Restart</h3>\n<pre><code class=\"language-bash\"># Menambahkan akun email adalah menambahkan akun OS Server itu sendiri!\nadduser karyawan1\n\nsystemctl restart postfix dovecot</code></pre>",
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'title' => 'Web Proxy Server (Squid)',
                'slug' => Str::slug('Web Proxy Server Server Squid'),
                'category' => 'Debian Server',
                'author' => 'Security Admin',
                'read_time' => 8,
                'excerpt' => 'Membangun Proxy Server menggunakan Squid untuk memblokir situs web tertentu (filtering).',
                'content' => "<h3>1. Instalasi Squid Config</h3>\n<pre><code class=\"language-bash\">apt install squid -y</code></pre>\n<h3>2. Konfigurasi Dasar dan Access Control List (ACL)</h3>\n<p>Tambahkan line ini di <code>/etc/squid/squid.conf</code> untuk memblokir domain sosial media:</p>\n<pre><code class=\"language-bash\"># ACL (Access Control List) mendefinisikan Variabel bernama blockedsites berisikan daftar URL ini\nacl blockedsites dstdomain .facebook.com .twitter.com\n# Atribut \"deny\" diterapkan untuk mengeksekusi nasib Variabel tersebut\nhttp_access deny blockedsites\n\n# Izinkan akses internet proxy HANYA dari komputer subnet lokal sekolah\nacl localnet src 192.168.10.0/24\nhttp_access allow localnet\n\n# Ubah port proxy dari default 3128 ke port 8080 (agar mirip router cisco/mikrotik)\nhttp_port 8080</code></pre>\n<h3>3. Restart Squid</h3>\n<pre><code class=\"language-bash\"># Proses restart Squid akan memakan waktu relatif lama untuk membangun cache 256MB di Ram\nsystemctl restart squid</code></pre>",
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'title' => 'Network Time Protocol (NTP Server)',
                'slug' => Str::slug('Network Time Protocol NTP Server'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 3,
                'excerpt' => 'Sinkronisasi jam dan waktu ke seluruh infrastruktur jaringan terpusat menggunakan layanan Chrony/NTP.',
                'content' => "<h3>1. Instalasi Chrony</h3>\n<pre><code class=\"language-bash\">apt install chrony -y</code></pre>\n<h3>2. Konfigurasi Sinkronisasi Pool</h3>\n<p>Edit file <code>/etc/chrony/chrony.conf</code>.</p>\n<pre><code class=\"language-bash\"># Tunjuk arah Server Jam Induk Indonesia (Stratum 2) jika Server Anda terhubung internet\nserver 0.id.pool.ntp.org iburst\nserver 1.id.pool.ntp.org iburst\n\n# Izinkan client (Router Mikrotik / Switch / PC Windows) untuk menyamakan jamnya pada Server Debian Ini\nallow 192.168.10.0/24</code></pre>\n<h3>3. Restart dan Verifikasi</h3>\n<pre><code class=\"language-bash\">systemctl restart chrony\n# Periksa sinkronisasi antar peer induk, harusnya status delay dan offset tercatat akurat (Milisec)\nchronyc sources -v</code></pre>",
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'title' => 'Samba File Server: Network Drive Sharing Lintas OS',
                'slug' => Str::slug('Samba File Server Sharing lintas OS'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 6,
                'excerpt' => 'Cara membagikan folder di Linux agar bisa diakses oleh PC Windows Client (SMB Protocol) di My Computer.',
                'content' => "<h3>1. Instalasi Samba</h3>\n<pre><code class=\"language-bash\">apt install samba smbclient -y</code></pre>\n<h3>2. Pembuatan Folder & User Samba</h3>\n<pre><code class=\"language-bash\"># -p (Membuat folder rekursif)\nmkdir -p /srv/samba/data_kantor\n# Memberikan izin 775 (Read-Write-Execute untuk User Owner & Grupnya, Read-Execute ke Other)\nchmod -R 0775 /srv/samba/data_kantor\nchown -R root:users /srv/samba/data_kantor\n\n# Daftarkan Password autentikasi Sharing Samba ke User Linux lokal bernama 'siswa'\nsmbpasswd -a siswa</code></pre>\n<h3>3. Konfigurasi smb.conf</h3>\n<p>Tambahkan config di <code>/etc/samba/smb.conf</code>:</p>\n<pre><code class=\"language-ini\">[DataKantor]\n   path = /srv/samba/data_kantor\n   browseable = yes # Biar share name-nya kelihatan di File Explorer / Network\n   read only = no # Artinya bisa di modifikasi pakai hak Write\n   valid users = siswa # Kunci folder berbagi ini, Minta kredensial Samba user 'siswa' (Yg passwordnya di set pakai smbpasswd tadi)</code></pre>\n<h3>4. Restart Service</h3>\n<pre><code class=\"language-bash\">systemctl restart smbd nmbd</code></pre>",
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'title' => 'Dasar VLAN (Virtual LAN) Bridge Filtering Mikrotik',
                'slug' => Str::slug('Dasar VLAN Mikrotik Switch'),
                'category' => 'Networking',
                'author' => 'Network Engineer',
                'read_time' => 8,
                'excerpt' => 'Implementasi VLAN (Access & Trunk) pada Switch Mikrotik menggunakan Bridge VLAN Filtering spesifik RouterOS v6.41+.',
                'content' => "<h3>1. Buat Switch Virtual (Bridge)</h3>\n<pre><code class=\"language-bash\"># Matikan vlan-filteringnya sementara selama masa perancangan konfigurasi\n/interface bridge add name=bridge1 vlan-filtering=no</code></pre>\n<h3>2. Masukkan Colokan (Port) Fisik ke Bridge</h3>\n<pre><code class=\"language-bash\"># Asumsi Ether1 adalah Jalur Utama (Trunk Inter-Vlan). Ether2 Vlan-10, Ether3 Vlan-20\n/interface bridge port\nadd bridge=bridge1 interface=ether1\n# Fitur PVID digunakan pada port Access (Bukan trunk). Jadi PC yang dicolok ether2 akan dilabeli Vlan=10 otomatis\nadd bridge=bridge1 interface=ether2 pvid=10\nadd bridge=bridge1 interface=ether3 pvid=20</code></pre>\n<h3>3. Tagging & Untagging Konsep</h3>\n<pre><code class=\"language-bash\">/interface bridge vlan\n# Mendefinisikan rute. Port Ether 1 Membawa \"Seluruh Label VLAN utuh ke langit (Tagged)\"\n# Ether 2 Melepas Label (Untagged) jadi lalu lintas Data Asli komputer (Vlan-id=10)\nadd bridge=bridge1 tagged=ether1 untagged=ether2 vlan-ids=10\nadd bridge=bridge1 tagged=ether1 untagged=ether3 vlan-ids=20</code></pre>\n<h3>4. Nyalakan Aturannya</h3>\n<pre><code class=\"language-bash\"># Terakhir, nyalakan mesin filternya agar aturan di atas mulai berjalan dan memblokade leak broadcast network!\n/interface bridge set bridge1 vlan-filtering=yes</code></pre>",
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'title' => 'Static Routing dan OSPF Basic Mikrotik',
                'slug' => Str::slug('Static Routing dan OSPF Mikrotik'),
                'category' => 'Networking',
                'author' => 'Core Router Admin',
                'read_time' => 9,
                'excerpt' => 'Menghubungkan 2 Router Mikrotik beda Network memakai Static Routing Manual dan Routing Dynamic Automatis (OSPF).',
                'content' => "<h3>Metode 1: Static Route</h3>\n<pre><code class=\"language-bash\"># Di Router A (Kita punya LAN 192.168.20.0 di Router B seberang)\n# Lewat mana kita menghubunginya? Lewat IP colokan ethernet di sisi router B (10.10.10.2)\n/ip route add dst-address=192.168.20.0/24 gateway=10.10.10.2</code></pre>\n<h3>Metode 2: OSPF (Dynamic Terdesentralisasi)</h3>\n<pre><code class=\"language-bash\"># Ini dieksekusi Seragam di Router A & Router B: \n# Masukkan saja semua Network yang ke-KONEK LOKAL di router itu kedalam perut area Backbone OSPF!\n/routing ospf network\nadd network=192.168.10.0/24 area=backbone\nadd network=10.10.10.0/30 area=backbone</code></pre>\n<p>Begitu OSPF Menyala di Backbone, Router akan mengirim tiket tiket LSA (Hello Neighbor!). Merchendise topologi jalan otomatis terpetakan tanpa campur tangan Admin!</p>",
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'title' => 'Membangun VPN Cepat dengan WireGuard',
                'slug' => Str::slug('Membangun VPN Cepat dengan WireGuard'),
                'category' => 'Networking',
                'author' => 'Security Analyst',
                'read_time' => 9,
                'excerpt' => 'Pelajari cara setup WireGuard, protokol VPN termodern, teringan, dan tercepat di Mikrotik RouterOS v7.',
                'content' => "<h3>1. Konfigurasi WireGuard Interface (Server HQ)</h3>\n<pre><code class=\"language-bash\"># Listen Port di Mikrotik Server Utama. WireGuard berjalan di mode Cepat (UDP)\n/interface wireguard add name=wg1 listen-port=13231\n\n# Memberikan Subnet IP Privat kepada antarmuka WireGuard agar saling bertegur sapa\n/ip address add address=10.255.255.1/24 interface=wg1</code></pre>\n<h3>2. Buka Port Firewall Router Pusat</h3>\n<pre><code class=\"language-bash\">/ip firewall filter add chain=input protocol=udp dst-port=13231 action=accept</code></pre>\n<h3>3. Konfigurasi Peer (Router Cabang)</h3>\n<pre><code class=\"language-bash\"># Router Cabang Harus menyertakan Password Publik Key yang bisa dicopy dari antarmuka WireGuard Server HQ\n/interface wireguard peers\n# Allowed-address: 0.0.0.0/0 berarti Traffic Full Route Internet Cabang dilewatkan HQ Server. \n# (Jika Point-to-Point lokal antar kantor saja isikan 10.255.255.0/24 !)\nadd interface=wg1 public-key=\"[PUBLIC_KEY_SERVER]\" endpoint-address=[IP_PUBLIC_SERVER] endpoint-port=13231 allowed-address=0.0.0.0/0</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Virtualisasi Penuh dengan Proxmox VE (Debian Based)',
                'slug' => Str::slug('Virtualisasi Penuh dengan Proxmox VE'),
                'category' => 'Debian Server',
                'author' => 'Cloud Architect',
                'read_time' => 11,
                'excerpt' => 'Membangun Private Cloud Anda sendiri. Tutorial instalasi Hypervisor tipe 1 (Proxmox Virtual Environment).',
                'content' => "<h3>1. Apa itu Proxmox VE?</h3>\n<p>Proxmox adalah platform manajemen Enterprise Open-Source yang merangkul teknologi kernel VM virtualisasi tinggi (KVM) dan Linux Container Lighweight (LXC) dalam 1 Dashboard terpadu.</p>\n<h3>2. Konfigurasi Jaringan VM (Linux Bridge)</h3>\n<p>Di Proxmox, mesin Virtual Guest butuh Jaringan Virtual (Linux Bridge/vmbr0) layaknya Virtual Switch. Mengarahkan Jaringan ini ke NIC colokan Hardware Server. Edit config Debiannya di <code>/etc/network/interfaces</code>:</p>\n<pre><code class=\"language-bash\">auto lo\niface lo inet loopback\n\n# Ini Hardware Ethernel Cardnya nyala tapi ngga di set IP karena dilempar ke Bridge\niface eno1 inet manual\n\n# Ini Switch virtual utama (VMBR-0) milik Proxmox\nauto vmbr0\niface vmbr0 inet static\n        address 192.168.10.2/24\n        gateway 192.168.10.1\n        # Switch Virtual (vmbr0) Disolder Pakem masuk menempel di Hardware Ethernel asli (eno1)\n        bridge-ports eno1\n        bridge-stp off\n        bridge-fd 0</code></pre>\n<h3>3. Manajemen via Panel HTML5</h3>\n<p>Buka <code>https://IP_SERVER:8006</code> pakai user `root`. Disitu anda mengendalikan VNC / Konsol, Storage ISO, Disks Pool (ZFS), Firewall Datacenter, hingga Cluster Management Migrasi Mesin antar gedung.</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Reverse Proxy Load-Balancer menggunakan NGINX',
                'slug' => Str::slug('Reverse Proxy Server menggunakan NGINX'),
                'category' => 'Debian Server',
                'author' => 'DevOps Engineer',
                'read_time' => 8,
                'excerpt' => 'Amankan aplikasi backend (Node.js, Docker, Java App) Anda di port tersembunyi lewat Reverse Proxy server eksternal port HTTP (Nginx).',
                'content' => "<h3>1. Instalasi Nginx</h3>\n<pre><code class=\"language-bash\">apt update\napt install nginx -y</code></pre>\n<h3>2. Konfigurasi Reverse Proxy Blocks</h3>\n<p>Buat blok server proxy config <code>/etc/nginx/sites-available/app</code>:</p>\n<pre><code class=\"language-nginx\">server {\n    listen 80; # Nginx mendengarkan permintaan dunia di Port 80 (Aman)\n    server_name app.kantor.id;\n\n    location / {\n        # Begitu User Public internet connect ke app.kantor.id, TERUSKAN (Proxy Pass) Secara rahasia dibelakang background menuju port docker App kita!\n        proxy_pass http://127.0.0.1:3000;\n        \n        # Syntax Websocket Support (Penting untuk Frontend JS / NextJS Terkini)\n        proxy_http_version 1.1;\n        proxy_set_header Upgrade \$http_upgrade;\n        proxy_set_header Connection 'upgrade';\n        proxy_set_header Host \$host;\n        proxy_cache_bypass \$http_upgrade;\n    }\n}</code></pre>\n<h3>3. Test Terapkan Nginx</h3>\n<pre><code class=\"language-bash\"># Buat Symlink file dari available ke folder \"enabled\"\nln -s /etc/nginx/sites-available/app /etc/nginx/sites-enabled/\n# Validasi pengetikan (Mengecek titik koma yang ada tapi hilang, yang error tapi ngga nongol)\nnginx -t\n# Apply Refresh\nsystemctl reload nginx</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Remote Workers: Windows Remote Desktop Services (VDI Base)',
                'slug' => Str::slug('Windows Remote Desktop Services RDS'),
                'category' => 'Windows Server',
                'author' => 'System Administrator',
                'read_time' => 12,
                'excerpt' => 'Berikan sensasi bekerja di kantor Remote Desktop Session Host (Multi-User) pada Windows Server sentral Anda bagi 50 karyawan dirumah.',
                'content' => "<h3>1. RDP Tunggal vs RDS Enterprise</h3>\n<p>Secara alami, kita Remote Desktop Connection (RDP) Port 3389 ke Server Administrator kita cuma bisa melayani 2 sesion pengguna Admin, selebihnya di TENDANG KERAS.</p>\n<p>Namun dengan Role <b>Remote Desktop Services (RDS / Session Host)</b>, limitasi koneksi serentak dicabut dan 50 User Non-Admin (Staff, Kasir, Manager) punya akun Windows dan profil desktop-nya sendiri-sendiri saat ngeremote Server besar (Multi-Account Desktop VDI).</p>\n<h3>2. Instalasi RDS Components via Powershell</h3>\n<pre><code class=\"language-powershell\"># Dalam perintah deployment Sakti ini kita install RD-ConnectionBroker, RD-WebAccess, RD-SessionHost pada 1 mesin utama (localhost) sekalian!\nNew-RDSessionDeployment -ConnectionBroker \"rds-server.domain.local\" -WebAccessServer \"rds-server.domain.local\" -SessionHost \"rds-server.domain.local\"</code></pre>\n<h3>3. Lisensi & CALs Per-User</h3>\n<p>Fitur RDS ini GRATIS beroperasi, TAPI HANYA SELAMA 120 HARI. Setelah Grace Limit lewat, Windows Remote menolak Client (Kecuali anda install RDS Licensing Role di server). Pada role Licensi ini, anda wajid inject SN dan Client Access License (CAL)-baik untuk Per-User atau Per-Device dan melakukan Server Activation ke Microsoft.</p>\n<h3>4. RemoteApp</h3>\n<p>Dengan RD-WebAccess, Karyawan tidak perlu memuat Remote Desktop OS penuh yang melahap Bandwidth! Karyawan cukup masuk browser, Klik Link App (Misal Ms Word), dan JENDELA MS Word saja (tanpa OS taskbarnya) yang muncul di depan Desktop Pribadinya!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
