<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            // ==========================================
            // DEBIAN SERVER LAYER
            // ==========================================
            [
                'title' => 'Pengenalan Dasar Linux Command Line (CLI)',
                'slug' => Str::slug('Pengenalan Dasar Linux Command Line (CLI)'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 5,
                'excerpt' => 'Pelajari perintah-perintah navigasi, manajemen file, dan hak akses (permissions) paling esensial dalam lingkungan Linux.',
                'content' => "<h3>1. Navigasi Direktori</h3>\n<p>Dalam sistem operasi Linux, everything is a file. Struktur direkori dimulai dari root (<code>/</code>). Anda dapat berpindah direktori menggunakan perintah <code>cd</code>.</p>\n<pre><code class=\"language-bash\"># Masuk ke direktori log sistem\ncd /var/log\n# Menampilkan jalur direktori saat ini (Print Working Directory)\npwd\n# Menampilkan isi direktori secara detail (Long listing) beserta file tersembunyi (all)\nls -la</code></pre>\n<h3>2. Manajemen File</h3>\n<p>Beberapa perintah esensial untuk memanipulasi file dan folder:</p>\n<pre><code class=\"language-bash\"># cp: Kependekan dari Copy. Memerlukan target file dan tempat tujuan\ncp sumber.txt /folder/tujuan/\n# mv: Move, selain untuk memindah juga berguna merename file\nmv filelama.txt filebaru.txt\n# rm: Remove (Menghapus). Flag -r (recursive) menghapus folder, -f (force) tanpa bertanya\nrm -rf /namadirektori\n# touch: Membuat satu file kosong dengan cepat\ntouch file_kosong.conf</code></pre>\n<h3>3. Hak Akses (Permissions)</h3>\n<p>Linux memiliki sistem permission ketat. Terdapat 3 level: Owner, Group, dan Others.</p>\n<pre><code class=\"language-bash\"># Merubah izin script agar bisa dieksekusi (755 berarti RWE untuk owner, RE untuk group/other)\nchmod 755 script.sh\n# Mengubah kepemilikan file menjadi milik user root dan grup root\nchown root:root script.sh</code></pre>",
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'title' => 'Konfigurasi SSH Server & Hardening (Debian)',
                'slug' => Str::slug('Konfigurasi SSH Server & Hardening di Debian'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 4,
                'excerpt' => 'Panduan instalasi dan pengamanan (hardening) OpenSSH Server dengan Key-Based Authentication.',
                'content' => "<h3>1. Instalasi OpenSSH Server</h3>\n<pre><code class=\"language-bash\"># Perbarui index cache repository lokal\napt update\n# Install paket utama openssh-server\napt install openssh-server -y</code></pre>\n<h3>2. Generate SSH Key (di PC Client)</h3>\n<pre><code class=\"language-bash\"># Membuat pasangan kunci (Public & Private) dengan metode RSA 4096 bit\nssh-keygen -t rsa -b 4096\n# Mendorong/mengkopi publik key kita ke server agar dikenali\nssh-copy-id namauser@IP_SERVER</code></pre>\n<h3>3. Hardening di Konfigurasi Server</h3>\n<p>Ubah pengaturan di <code>/etc/ssh/sshd_config</code>:</p>\n<pre><code class=\"language-ini\"># MELARANG login memakai password biasa (Hanya wajib pakai SSH Key)\nPasswordAuthentication no\n# MENCEGAH user root dari server untuk di-remote langsung (Cegah bruteforce)\nPermitRootLogin no\n# MENGUBAH default port 22 ke angka acak agar tidak mudah di scan\nPort 2222</code></pre>\n<h3>4. Restart</h3>\n<pre><code class=\"language-bash\">systemctl restart ssh</code></pre>",
                'created_at' => now()->subDays(9),
                'updated_at' => now()->subDays(9),
            ],
            [
                'title' => 'Membangun DHCP Server (isc-dhcp-server)',
                'slug' => Str::slug('Membangun DHCP Server isc dhcp server'),
                'category' => 'Debian Server',
                'author' => 'Network Admin',
                'read_time' => 6,
                'excerpt' => 'Cara mendistribusikan IP Address, Gateway, dan DNS secara otomatis ke client Debian/Windows memakan isc-dhcp-server.',
                'content' => "<h3>1. Instalasi isc-dhcp-server</h3>\n<pre><code class=\"language-bash\">apt update\napt install isc-dhcp-server -y</code></pre>\n<h3>2. Tentukan Interface Pelayan</h3>\n<p>Buka file <code>/etc/default/isc-dhcp-server</code>.</p>\n<pre><code class=\"language-bash\"># InterfacesV4 memberitahu aplikasi ethernet mana yang akan memancarkan IP otomatis\nINTERFACESv4=\"enp0s8\"</code></pre>\n<h3>3. Konfigurasi Scope IP (Pool)</h3>\n<p>Edit file konfigurasi utamanya di <code>/etc/dhcp/dhcpd.conf</code>.</p>\n<pre><code class=\"language-bash\"># Jadikan server kita sebagai pemberi IP DHCP utama di jaringan ini\nauthoritative;\n\n# Mendeklarasikan subnet mask jaringan\nsubnet 192.168.10.0 netmask 255.255.255.0 {\n  # Memberikan pool IP dari titik mulai .10 sampai titik akhir .100\n  range 192.168.10.10 192.168.10.100;\n  # Memberikan gateway / pintu keluar internet untuk klien\n  option routers 192.168.10.1;\n  # Menentukan DNS referensi klien (Google dan Cloudflare)\n  option domain-name-servers 8.8.8.8, 1.1.1.1;\n  # Waktu kadaluarsa sewa IP (Detik). Klien wajib renewal setelah angka ini habis.\n  default-lease-time 600;\n  max-lease-time 7200;\n}</code></pre>\n<h3>4. Restart Service</h3>\n<pre><code class=\"language-bash\">systemctl restart isc-dhcp-server</code></pre>",
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'title' => 'Konfigurasi DNS Server Lokal dengan Bind9',
                'slug' => Str::slug('Konfigurasi DNS Server Lokal dengan Bind9'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 8,
                'excerpt' => 'Langkah-langkah mapping layanan IP address ke Nama Domain (Forward & Reverse lookup zone) menggunakan Bind9.',
                'content' => "<h3>1. Instalasi Bind9</h3>\n<pre><code class=\"language-bash\">apt install bind9 bind9utils bind9-doc dnsutils -y</code></pre>\n<h3>2. Konfigurasi Zone</h3>\n<p>Edit file <code>/etc/bind/named.conf.local</code>. Kita mendefinisikan batas area kepemilikan nama domain kita.</p>\n<pre><code class=\"language-bash\">zone \"lks-itnsa.id\" {\n    # Server ini adalah pencatat zona (Pemilik utama zona lks-itnsa)\n    type master;\n    # Tempat fisik file database diletakkan\n    file \"/etc/bind/db.forward\";\n};\n\nzone \"10.168.192.in-addr.arpa\" {\n    # Ini adalah area kebalikan (Reverse) untuk menebak domain jika hanya dikasih IP\n    type master;\n    file \"/etc/bind/db.reverse\";\n};</code></pre>\n<h3>3. Membuat File Zone Record</h3>\n<p>Edit <code>db.forward</code> <i>(Mengubah Nama Domain Menjadi IP)</i>:</p>\n<pre><code class=\"language-bind\">\$TTL    604800 # Time to Live Cache dalam detik (Penyimpanan memori sementara pada client)\n@       IN      SOA     ns.lks-itnsa.id. root.lks-itnsa.id. (\n                        2         ; Serial (Penting diubah kalau ada backup NS)\n                        604800    ; Refresh (Waktu refresh NS sekunder)\n)\n# Ini adalah A-Record (Record utama memetakan Teks ke IP v4)\n@       IN      A       192.168.10.1\nns      IN      A       192.168.10.1\nwww     IN      A       192.168.10.1 # Mengarahkan www.lks-itnsa.id ke server IP berikut\n# Ini adalah CNAME (Alias), berguna agar mail.domain diarahkan ke lokasi yang sama dengan A record utamanya\nmail    IN      CNAME   @</code></pre>\n<p>Edit <code>db.reverse</code> <i>(Mengubah IP Menjadi Nama Domain)</i>:</p>\n<pre><code class=\"language-bind\">\n# '1' adalah oktet terakhir IP 192.168.10.1 (Kombinasi dengan nama zone arpa sebelumnya)\n1       IN      PTR     www.lks-itnsa.id.\n1       IN      PTR     ns.lks-itnsa.id.</code></pre>\n<h3>4. Restart</h3>\n<pre><code class=\"language-bash\">systemctl restart bind9</code></pre>",
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'title' => 'Membangun Web Server Apache2 & SSL',
                'slug' => Str::slug('Instalasi Web Server Apache2 dan SSL'),
                'category' => 'Debian Server',
                'author' => 'Web Dev Ops',
                'read_time' => 7,
                'excerpt' => 'Membangun web server (HTTP/HTTPS) menggunakan Apache2 dan mengatur Secure Socket Layer (Self-Signed).',
                'content' => "<h3>1. Instalasi Apache2</h3>\n<pre><code class=\"language-bash\">apt install apache2 -y</code></pre>\n<h3>2. Generate Self-Signed SSL</h3>\n<pre><code class=\"language-bash\"># Perintah req -x509 digunakan membuat self-signed cert sendiri (Otoritas Pribadi)\n# -days 3650 (Sertifikat valid 10 tahun)\n# rsa:2048 (Enkripsi tipe RSA panjang 2048 bit)\nopenssl req -x509 -nodes -days 3650 -newkey rsa:2048 -keyout /etc/ssl/private/apache.key -out /etc/ssl/certs/apache.crt</code></pre>\n<h3>3. Konfigurasi Virtual Host</h3>\n<p>Aktifkan modul HTTPS dan Rewrite engine:</p>\n<pre><code class=\"language-bash\">a2enmod ssl # Mengizinkan pengolahan kriptografi SSL pada apache\na2enmod rewrite # Mengizinkan manipulasi mod_rewrite pada .htaccess framework web (Laravel/CI)</code></pre>\n<p>Edit virtual host anda ke port 443 <code>/etc/apache2/sites-available/default-ssl.conf</code> :</p>\n<pre><code class=\"language-apache\">&lt;VirtualHost *:443&gt;\n    # Jika user mengakses www.lks-itnsa.id pada port HTTPS, tangkap requestnya!\n    ServerName www.lks-itnsa.id\n    # Di mana letak root direktori website yang akan ditampilkan?\n    DocumentRoot /var/www/html/website\n    \n    # Menghidupkan Mode Dekripsi Enkripsi\n    SSLEngine on\n    # Tunjuk alamat letak sertifikat public kunci gemboknya\n    SSLCertificateFile /etc/ssl/certs/apache.crt\n    # Tunjuk alamat letak private key rahasia untuk gembok tersebut\n    SSLCertificateKeyFile /etc/ssl/private/apache.key\n&lt;/VirtualHost&gt;</code></pre>\n<h3>4. Terapkan</h3>\n<pre><code class=\"language-bash\">a2ensite default-ssl\nsystemctl reload apache2</code></pre>",
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
            ],
            [
                'title' => 'Konfigurasi FTP Server (ProFTPD)',
                'slug' => Str::slug('Konfigurasi FTP Server ProFTPD'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 5,
                'excerpt' => 'Cara membuat File Transfer Protocol (FTP) server menggunakan ProFTPD untuk kemudahan upload/download file terpusat.',
                'content' => "<h3>1. Instalasi ProFTPD</h3>\n<pre><code class=\"language-bash\">apt install proftpd -y</code></pre>\n<p>Apabila dimintai pilihan saat instalasi (StandAlone atau Inetd), pilih <b>StandAlone</b> (Aplikasi berjalan mandiri selamanya di background).</p>\n<h3>2. Konfigurasi Keamanan Dasar</h3>\n<p>Sangat dirokemendasikan untuk memenjarakan user hanya dalam direktorinya sendiri (chroot jail). Edit file <code>/etc/proftpd/proftpd.conf</code>.</p>\n<pre><code class=\"language-ini\"># Fitur DefaultRoot (Chroot) memaksa user yang login tidak bisa cd / mundur menuju folder root linux (/var/etc) \nDefaultRoot ~  # Tanda Tilda (~) artinya mereka terkurung di Home Dir spesifik tiap usernya.\n\n# Melarang akses login sebagai ROOT dalam FTP, hal ini untuk mencegah hacker meresize/mengedit OS\nRootLogin off\n\n# Mewajibkan shell yang sah bagi user yang mau terhubung (Optional layer)\nRequireValidShell on</code></pre>\n<h3>3. Restart Service</h3>\n<pre><code class=\"language-bash\">systemctl restart proftpd</code></pre>",
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Memahami Arsitektur Kubernetes (K8s)',
                'slug' => Str::slug('Memahami Arsitektur Kubernetes K8s'),
                'category' => 'Debian Server',
                'author' => 'Cloud Architect',
                'read_time' => 15,
                'excerpt' => 'Menyelam dalam ekosistem orkestrasi kontainer terbesar. Pelajari dasar-dasar Nodes, Pods, Deployments, dan Services di Kubernetes.',
                'content' => "<h3>1. Apa itu Kubernetes?</h3>\n<p>Jika Docker digunakan untuk menjalankan 1 container, Kubernetes (K8s) digunakan untuk mengatur, men-scale, dan menyembuhkan RATUSAN container secara massal pada klaster mesin yang berbeda-beda secara otomatis.</p>\n<h3>2. Komponen Utama K8s</h3>\n<pre><code class=\"language-yaml\"># 1. NODE: Server fisik atau VM. Dibedakan menjadi Master Node (Pengatur/Control Plane) dan Worker Node (Pekerja).\n# 2. POD: Entitas komputasi terkecil di K8s. Sebuah Pod membungkus 1 (atau lebih) Docker Container bersama dengan volume dan alamat IP internalnya.\n# 3. Kubelet: Agen kecil penunggu di dalam setiap Worker Node.\n# 4. Kube-Proxy: Agen jaringan di tiap node yang memastikan Pod bisa berinteraksi satu sama lain lewat Network Layer virtual.</code></pre>\n<h3>3. Mendefinisikan Manifest Deployment (Contoh Nginx)</h3>\n<pre><code class=\"language-yaml\">apiVersion: apps/v1\nkind: Deployment\nmetadata:\n  name: my-nginx-deployment\nspec:\n  # Meminta kubernetes MENCIPTAKAN DAN MENJAGA persis 3 duplikat (replika) dari container web kita secara nonstop\n  replicas: 3\n  selector:\n    matchLabels:\n      app: web-server\n  template:\n    metadata:\n      labels:\n        app: web-server\n    spec:\n      containers:\n      - name: nginx-container\n        image: nginx:1.21.6 # Gambar sumber docker\n        ports:\n        - containerPort: 80 # Pelabuhan tempat server kita mendengar internal data</code></pre>\n<h3>4. Cara Kerja Self-Healing</h3>\n<p>Ketika Anda memasukkan file manifest <code>.yaml</code> di atas melalui command <code>kubectl apply -f nginx.yaml</code>, Master Control Plane akan menyebar 3 Pod (misal 1 ke Server A, 2 ke Server B).</p>\n<p>Jika Server A terbakar (Mati Listrik), sistem Kublet melaporkan hal tersebut. Master K8s secara OMTOMATIS mendeteksi bahwa jumlah replika sekarang sisa 2 (Kurang dari Target 3). Master K8s dengan cerdas seketika akan menyuruh Server C dan D untuk menciptakan ulang 1 Pod yang hilang di detik itu juga! Zero Downtime.</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Linux LVM: Menggabungkan Banyak Harddisk Jadi Satu',
                'slug' => Str::slug('Linux LVM Menggabungkan Banyak Harddisk'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 9,
                'excerpt' => 'Cara mengatasi kepenuhan Storage Disk tanpa install ulang OS. Gunakan fitur Logical Volume Manager (LVM) di Debian untuk menggabung multiple disk fisik.',
                'content' => "<h3>1. Konsep Logical Volume Manager (LVM)</h3>\n<p>Bila kita menggunakan partisi fisik tradisional (ext4 pada /dev/sda1), ketika sda1 penuh kita PUSING. Namun dengan LVM, kita memiliki lapisan abstraksi (elastis). Kita bisa mencabut atau menambah harddisk baru (Physical Volume), menggabungkannya di wadah kolam bersama (Volume Group), lalu membaginya kembali per irisan (Logical Volume).</p>\n<h3>2. Alur Pengerjaan (Membuat LVM Baru)</h3>\n<pre><code class=\"language-bash\"># Masukkan Harddisk Baru ke PC Server (misal terdeteksi sdb dan sdc)\n# Langkah 1: Tandai ke-2 HD tersebut sebagai PV (Physical Volume/Bahan Baku LVM)\npvcreate /dev/sdb /dev/sdc\n\n# Langkah 2: Satukan 2 harddisk PV ini dalam satu Kolam VG (Misal dinamai vg_data)\nvgcreate vg_data /dev/sdb /dev/sdc\n\n# Langkah 3: Cetak Partisi Elastis (LV) mengambil 100 Giga dari kolam raksasa vg_data tersebut!\nlvcreate -L 100G -n lv_database vg_data\n\n# Terakhir: Formating LV menjadi ext4 lalu di-mount ke OS file kita!\nmkfs.ext4 /dev/mapper/vg_data-lv_database\nmount /dev/mapper/vg_data-lv_database /srv/database</code></pre>\n<h3>3. Menambah Kapasitas LVM Secara Instan (Extend)</h3>\n<p>Umpama LVM 100G di atas Kepenuhan. Pasang 1 HDD lagi (sdd kapasitas 50 GB).</p>\n<pre><code class=\"language-bash\"># Jadikan SDD sebagai bahan baku baru lalu masukkan ke kolam vg_data yang sudah ada\npvcreate /dev/sdd\nvgextend vg_data /dev/sdd\n\n# Melar-kan secara paksa ukuran Partisi LV yang penuh (Kini kita tambah 50 Giga ekstra)\nlvextend -L +50G /dev/mapper/vg_data-lv_database\n# Force OS file manager untuk mem-refresh size block fisiknya\nresize2fs /dev/mapper/vg_data-lv_database</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // NETWORKING LAYER
            // ==========================================
            [
                'title' => 'Konfigurasi Mikrotik Firewall NAT & Masquerade',
                'slug' => Str::slug('Konfigurasi Mikrotik Firewall NAT Masquerade'),
                'category' => 'Networking',
                'author' => 'Network Engineer',
                'read_time' => 4,
                'excerpt' => 'Cara membagikan koneksi internet (Sharing Internet) dari satu IP Public ke banyak IP Local.',
                'content' => "<h3>Kenapa Butuh NAT Masquerade?</h3>\n<p>Client di LAN menggunakan private IP (seperti 192.168.x.x) yang tidak bisa di-routing ke internet langsung. Perlu diterjemahkan oleh Router Mikrotik (Network Address Translation).</p>\n<h3>Konfigurasi via CLI</h3>\n<p>Asumsikan <code>ether1</code> adalah port yang menuju ke Internet/ISP.</p>\n<pre><code class=\"language-bash\"># Chain=srcnat (Memberitahu router agar mengontrol asal/source traffic dari dalam ke luar)\n# action=masquerade (Topeng: Mengganti IP LAN Private secara spontan menjadi IP Public dari Ether1 saat paket dilempar ke provider)\n/ip firewall nat add chain=srcnat out-interface=ether1 action=masquerade</code></pre>\n<p>Pastikan juga anda sudah mempunyai route menuju gateway internet agar paket dari LAN bisa diteruskan.</p>\n<pre><code class=\"language-bash\"># 0.0.0.0/0 berarti (SEMUA NETWORK TUJUAN DI ALAM SEMESTA INTERNET ini), tolong selalu lempar lewat pintu Gerbang Utama IP ISP 10.10.10.1\n/ip route add dst-address=0.0.0.0/0 gateway=10.10.10.1</code></pre>",
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Manajemen Bandwidth Lanjut (QoS) dengan PCQ Mikrotik',
                'slug' => Str::slug('Manajemen Bandwidth Lanjut PCQ Mikrotik'),
                'category' => 'Networking',
                'author' => 'Network Architect',
                'read_time' => 10,
                'excerpt' => 'Implementasi cerdas Per Connection Queue (PCQ) untuk membagi bandwidth ke ratusan klien secara merata dan dinamis.',
                'content' => "<h3>1. Konsep Kerja PCQ</h3>\n<p>PCQ membagi bandwidth secara pro-rata kepada siapapun yang SEDANG AKTIF (dinamis). Jika kapasitas 50 Mbps dipakai 2 anak, masing-masing dapat 25 Mbps. Jika dipakai 10 anak, masing-masing 5 Mbps.</p>\n<h3>2. Membuat Queue Type (PCQ Down & Up)</h3>\n<pre><code class=\"language-bash\">/queue type\n# Kita definisikan Mesin PCQ-Download: Tolak ukurnya (classifier) pakai ID (Alamat Tujuan di internal network/Dst-Address)\n# Rate=0 berarti tidak ada pemangkasan statik individu, ambil langsung sebesar-besarnya dari pipa ibu\nadd kind=pcq name=PCQ-Download pcq-classifier=dst-address pcq-rate=0\n\n# Mesin PCQ-Upload : Mengklasifikasi koneksi Upload LAN berdasar source/sumber pengirim\nadd kind=pcq name=PCQ-Upload pcq-classifier=src-address pcq-rate=0</code></pre>\n<h3>3. Implementasi Mangle (Cap Tanda Air)</h3>\n<pre><code class=\"language-bash\">/ip firewall mangle\n# Langkah 1 (Tandai Rute): Kita stempel koneksi/sesi dari alamat network 192.168.88.0/24 lalu namakan koneksinya 'conn_Lokal'\nadd chain=forward src-address=192.168.88.0/24 action=mark-connection new-connection-mark=conn_Lokal passthrough=yes\n# Langkah 2 (Tandai Barang): Selipin stempel pada tiap bungkus paket kecil miliki koneksi 'conn_lokal' menjai tanda air 'pkt_Lokal'\nadd chain=forward connection-mark=conn_Lokal action=mark-packet new-packet-mark=pkt_Lokal passthrough=no</code></pre>\n<h3>4. Eksekusi Ekstrem (Queue Tree)</h3>\n<pre><code class=\"language-bash\">/queue tree\n# Mengatur global antrian bernama TOTAL-DOWNLOAD dengan kecepatan 50M. Siapa korbannya? Paket yang bersertifikat pkt_Lokal. Cara baginya? Gunakan antri jenis PCQ-Download yang adil tadi!\nadd name=TOTAL-DOWNLOAD parent=global packet-mark=pkt_Lokal max-limit=50M queue=PCQ-Download\nadd name=TOTAL-UPLOAD parent=global packet-mark=pkt_Lokal max-limit=50M queue=PCQ-Upload</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Konfigurasi EoIP Tunnel Antar Gedung',
                'slug' => Str::slug('Konfigurasi EoIP Tunnel Antar Gedung'),
                'category' => 'Networking',
                'author' => 'Senior Network',
                'read_time' => 7,
                'excerpt' => 'Membangun jembatan Ethernet transparan lintas Internet! Gabungkan LAN Kantor Pusat dan Cabang melalui EoIP (Ethernet over IP) spesifik Mikrotik RouterOS.',
                'content' => "<h3>Apa itu EoIP Tunnel?</h3>\n<p>EoIP adalah protokol enkapsulasi layer 2 ciptaan Mikrotik. Kelebihannya: Membuat kabel tak kasat mata di atas koneksi Internet Publik! Traffic antar router bisa bersifat broadcast (DHCP di Router A bisa sampai ke Router B) seperti dicolok satu switch yang sama.</p>\n<h3>Konfigurasi Pembangunan Terowongan (Tunnel)</h3>\n<p>Pastikan kedua Router memiliki IP Public Static (Misal HQ=202.1.1.1 v Branch=101.2.2.2)</p>\n<pre><code class=\"language-bash\"># DI ROUTER PUSAT/A (Mengarahkan tembakan eoip ke IP Public Router lawan)\n/interface eoip add name=eoip-hq remote-address=101.2.2.2 tunnel-id=10\n\n# DI ROUTER CABANG/B\n/interface eoip add name=eoip-branch remote-address=202.1.1.1 tunnel-id=10</code></pre>\n<p><b>Catatan Penting GHAIB:</b> <code>tunnel-id</code> wajib HARUS SAMA PERSIS antara kedua router! Itulah kunci jembatannya.</p>\n<h3>Menyatukan Tunnel Kedalam Lan Fisik</h3>\n<pre><code class=\"language-bash\"># Buat colokan master bridge (switch palsu)\n/interface bridge add name=bridge-eoip\n\n# Memasukkan port Kabel LAN Fisik ke switch palsu\n/interface bridge port add bridge=bridge-eoip interface=ether2_LAN_Fisik\n\n# Memasukkan colokan Terowongan EoIP ke Switch palsu yang sama!\n/interface bridge port add bridge=bridge-eoip interface=eoip-hq</code></pre>\n<p>Sekarang, komputer di Cabang seakan-akan memakai 1 Kabel LAN Fisik yang langsung menancap di Pusat tanpa batas geografi!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==========================================
            // WINDOWS SERVER LAYER
            // ==========================================
            [
                'title' => 'Membangun Active Directory Domain Services (DC)',
                'slug' => Str::slug('Active Directory Domain Services DC'),
                'category' => 'Windows Server',
                'author' => 'IT Infrastructure Specialist',
                'read_time' => 10,
                'excerpt' => 'Langkah-langkah menyiapkan DC (Domain Controller) dan memanajemen user sentral perusahaan.',
                'content' => "<h3>1. Persiapan Host Server</h3>\n<p>Pastikan Windows Server Anda memiliki IP Address Static dan Nama Komputer (Hostname) yang sudah diubah (contoh: DC-SVR22) sebelum menginstall roles.</p>\n<h3>2. Add Roles and Features</h3>\n<pre><code class=\"language-powershell\"># Anda bisa menginstal Role via GUI Server Manager, atau dengan sintaks otomatis Powershell!\n# Sertakan perintah ini untuk memerintahkan instalasi modul inti Active Directory beserta peralatan pelengkap Admin/IncludeManagementTools\nInstall-WindowsFeature -Name AD-Domain-Services -IncludeManagementTools</code></pre>\n<h3>3. Promote to Domain Controller</h3>\n<p>Setelah role siap, saatnya mempromosikan komputer miskin menjadi komputer sakti (Domain Controller).</p>\n<pre><code class=\"language-powershell\"># Kita instal Forest Dasar (Hutan pertama di pabrik). Nama perusahaannya 'perusahaan.local'\n# Setel password perbaikan aman DSRM \nInstall-ADDSForest -DomainName \"perusahaan.local\" -SafeModeAdministratorPassword (ConvertTo-SecureString \"PasswordSakti123!\" -AsPlainText -Force) -InstallDns -Force</code></pre>\n<p>Setelah restart, Komputer berstatus sebagai RAJA! Client di LAN bisa mengganti pengaturan 'Workgroup' mereka menjadi Domain `perusahaan.local` lalu otentifikasi sentral!</p>",
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'title' => 'Optimasi Storage dengan FSRM (File Server Resource Manager)',
                'slug' => Str::slug('Optimasi Storage dengan FSRM (File Server Resource Manager)'),
                'category' => 'Windows Server',
                'author' => 'System Administrator',
                'read_time' => 10,
                'excerpt' => 'Mencegah Server Kepenuhan! Terapkan Quota dan blokir file Ekstensi (Film/Musik) menggunakan File Screening FSRM.',
                'content' => "<h3>1. Cara Install FSRM Role</h3>\n<pre><code class=\"language-powershell\"># Instal modul FS-Resource-Manager bawaan MS Windows\nInstall-WindowsFeature -Name FS-Resource-Manager -IncludeManagementTools</code></pre>\n<h3>2. Membuat Kuota Hard (Mencegah Kepenuhan)</h3>\n<p>Daripada KLIK-KLIK puluhan menu GUI pusing, di Server 2022 powershell menyelamatkan kita.</p>\n<pre><code class=\"language-powershell\"># Path / Tujuan Folder Share: D:\\Data_Keuangan\n# Ukuran Limite maks: 5 GB (-Size 5GB)\n# -Type Hard (Aksi Tolak/Error jika lewat quota, -Type Soft (Cuma beri notifikasi)\nNew-FsrmQuota -Path \"D:\\Data_Keuangan\" -Size 5GB -Template \"5 GB Limit\"</code></pre>\n<h3>3. Eksekusi File Screening (Saring Ekstensi Jahat)</h3>\n<p>Karyawan dilarang menyimpan Film `.mp4` / `.mkv` di server bersama perusahaan!</p>\n<pre><code class=\"language-powershell\"># Mendaftarkan tipe grup ekstensi bajakan buatan kita sendiri dan mendefinisikannya\nNew-FsrmFileGroup -Name \"Spesial Bajakan Movie\" -IncludePattern @(\"*.mp4\", \"*.mkv\", \"*.avi\")\n\n# Menerapkan proteksi Screening (Saringan Aktif/Active) Pada Folder D:\\Share\\Bersama milik publik\n# Beri tahu penjaga FSrm bahwa format referensinya adalah file group \"Spesial Bajakan Movie\"\nNew-FsrmFileScreen -Path \"D:\\Share\\Bersama\" -IncludeGroup \"Spesial Bajakan Movie\" -Active \$true</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pusat Update Otomatis via WSUS (Windows Server Update Service)',
                'slug' => Str::slug('Pusat Update Otomatis via WSUS'),
                'category' => 'Windows Server',
                'author' => 'System Administrator',
                'read_time' => 9,
                'excerpt' => 'Menghemat ratusan Gigabyte bandwitdh Kuota Internet dengan merancang master Update Service tersendiri di LAN.',
                'content' => "<h3>Perihal WSUS</h3>\n<p>WSUS (Windows Server Update Service) adalah pedoman krusial! Menginstal 1 WSUS Server berarti ia sendiri akan mengunduh ratusan Gigabyte patch langsung dari pabrikan Microsoft lalu dilempar ulang via jaringan Gigabit LAN. Bandwidth Internet kantor AMAN.</p>\n<h3>Konfigurasi via GPO (Memaksa Client Untuk Connect LOKAL WSUS kita)</h3>\n<p>Setelah GUI WSUS menyala, anda harus memodifikasi Policy Active Directory agar client dipaksa mendownload dari link INTRA-NET bukan INTER-NET asli.</p>\n<pre><code class=\"language-yaml\"># Hierarchy Lokasi Folder GPO Management:\n# Computer Configuration > Policies > Administrative Templates > Windows Components > Windows Update\n\n# Atribut Konfigurasi:\n> Specify intranet Microsoft update service location             = Enabled\n> Set the intranet update service for detecting updates          = http://192.168.10.22:8530\n> Set the intranet statistics server                             = http://192.168.10.22:8530</code></pre>\n<p>Hanya dengan bermodalkan GPO tersebut disebarkan ke OU seluruh karyawan perusahaan, maka WSUS secara mendadak akan membajak proses Windows Update puluhan PC klien secara sentral. Luar Biasa!</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        
        DB::table('articles')->truncate(); // Membersihkan data lama
        DB::table('articles')->insert($articles); // Menginject ALL ARRAY
        
        // Memanggil modul materi baru yang dipisah agar file tidak terlalu besar
        $this->call([
            DebianSeeder::class,
            SecuritySeeder::class,
            ExtraSeeder::class,
            SysAdminSeeder::class,
            AdvancedSeeder::class,
            ExpertSeeder::class,
            CoreSysadminSeeder::class,
            OneHundredSeeder::class,
            GeneratorSeeder::class,
        ]);

        // Secara massal me-rating tingkatan level kesulitan setiap mapel (1: Pemula, 2: Menengah, 3: Lanjut, 4: Ahli)
        $semuaArtikel = DB::table('articles')->get();
        foreach ($semuaArtikel as $artikel) {
            // Kita skip artikel dari ExpertSeeder (atau yang tadinya secara default punya levelnya sndiri di atas 2)
            if ($artikel->level_id !== 2 && $artikel->level_id !== 0) continue;

            $t = strtolower($artikel->title);
            $lvl = 2; // Default (Menengah)

            if (str_contains($t, 'dasar') || str_contains($t, 'pengenalan') || str_contains($t, 'pemula') || str_contains($t, 'awal') || str_contains($t, 'simpel') || str_contains($t, 'command line')) {
                $lvl = 1;
            } elseif (str_contains($t, 'lanjut') || str_contains($t, 'advanced') || str_contains($t, 'kelas') || str_contains($t, 'masterclass') || str_contains($t, 'kompleks') || str_contains($t, 'vpn')) {
                $lvl = 3;
            } elseif (str_contains($t, 'expert') || str_contains($t, 'arsitektur') || str_contains($t, 'cluster') || str_contains($t, 'datacenter') || str_contains($t, 'bgp')) {
                $lvl = 4;
            }

            DB::table('articles')->where('id', $artikel->id)->update(['level_id' => $lvl]);
        }
    }
}
