<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CoreSysadminSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Senjata Wajib SysAdmin: Multiplexing Terminal dengan Tmux',
                'slug' => Str::slug('Multiplexing Terminal dengan Tmux'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 6,
                'excerpt' => 'Pernahkah Anda compile Apache 3 jam via SSH, lalu putus koneksi internet? Jangan biarkan proses mati! Gunakan Tmux (Terminal Multiplexer) dan tinggalkan sesi Anda aman di background.',
                'content' => "<h3>1. Kenapa Menyerahkan Nyawa ke Koneksi SSH?</h3>\n<p>Saat koneksi SSH mati, Bash shell otomatis mengirim sinyal <b>SIGHUP (Signal Hangup)</b> ke semua program yang sedang Anda jalankan. `apt upgrade` bisa terputus di tengah jalan! <b>Tmux</b> menciptakan terminal virtual di rahim server yang tidak peduli internet Anda putus.</p>\n<h3>2. Penggunaan Tmux Dasar</h3>\n<pre><code class=\"language-bash\"># 1. Install\napt install tmux -y\n\n# 2. Mulai sesi layar baru (Anggap nama layarnya 'UpgradeServer')\ntmux new -s UpgradeServer\n\n# Di dalam layar ini, Anda bisa kompilasi apa saja. Coba ketik:\ntop</code></pre>\n<h3>3. Detach & Attach (Meninggalkan dan Kembali)</h3>\n<p>Untuk keluar sementara dari layar Tmux TAPI tetap membiarkan `top` berjalan, tekan: <b>Ctrl+B lalu (lepas tuts) tekan tombol 'd' (Detach).</b></p>\n<p>Besoknya, Anda ssh lagi dari warnet, kembalilah ke sesi tersebut:</p>\n<pre><code class=\"language-bash\"># Masuk kembali ke jendela virtual sebelumnya\ntmux attach -t UpgradeServer</code></pre>\n<h3>4. Manajemen Jendela Belah Layar (Split Pane)</h3>\n<p>Di dalam 1 layar tmux, Anda bisa membelah CLI jadi 2:\n<ul>\n<li>Belah Vertikal: <b>Ctrl+B lalu %</b></li>\n<li>Belah Horizontal: <b>Ctrl+B lalu \"</b></li>\n<li>Berpindah Kotak/Pane: <b>Ctrl+B lalu Panah Arah</b></li>\n</ul></p>\n<p>Kini Anda layaknya hacker film Hollywood dengan 4 terminal split jalan bersamaan!</p>",
                'level_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Menciptakan Daemon: Custom Systemd Service',
                'slug' => Str::slug('Menciptakan Custom Systemd Service Daemon'),
                'category' => 'Debian Server',
                'author' => 'Linux Engineer',
                'read_time' => 8,
                'excerpt' => 'Punya script Node.js / Python bot telegram dan ingin agar selalu jalan, bisa di-start/stop/restart/auto-start waktu booting? Jadikan dia Daemon Service!',
                'content' => "<h3>1. File Unit Systemd</h3>\n<p>Tinggalkan manual eksekusi <code>nohup python bot.py &amp;</code> (itu kampungan). Semua service resmi Debian .service dikendalikan oleh SystemD.</p>\n<p>Buka folder khusus sistem: <code>sudo nano /etc/systemd/system/bot_telegramku.service</code></p>\n<h3>2. Konfigurasi Unit (Manifest)</h3>\n<pre><code class=\"language-ini\">[Unit]\nDescription=Bot Telegram Otomatisasi Absensi Kantor\n# Tunggu sampai network idup sebelum nyalain ini\nAfter=network.target \n\n[Service]\n# Jalankan program ini bukan sebagai user dewa (root) demi keamanan\nUser=budi\nGroup=budi\nWorkingDirectory=/home/budi/app_bot\n\n# Mantra Eksekusi utamanya!\nExecStart=/usr/bin/python3 main.py\n\n# Jika program error (crash), hidupkan lagi paksa! Jangan menyerah!\nRestart=always\nRestartSec=5s\n\n[Install]\n# Target Multi-User artinya dicolok ke startup rutin pas OS grafis CLI sudah ready\nWantedBy=multi-user.target</code></pre>\n<h3>3. Reload dan Uji Coba</h3>\n<pre><code class=\"language-bash\"># Jika kita menyentuh isi folder /etc/systemd/, WAJIB reload mesin systemd-nya!\nsystemctl daemon-reload\n\n# Hidupkan script bodoh kita yang sekarang berevolusi menjadi System Service Elit!\nsystemctl start bot_telegramku\nsystemctl enable bot_telegramku\nsystemctl status bot_telegramku\n\n# Lihat buku laporannya!\njournalctl -u bot_telegramku -f</code></pre>",
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seni Administrasi Teks Sakti: Awk & Sed (Manipulasi File / Log)',
                'slug' => Str::slug('Awk dan Sed Manipulasi Log File System'),
                'category' => 'Debian Server',
                'author' => 'System Programmer',
                'read_time' => 7,
                'excerpt' => 'Anda disuruh bos mencari 1 nomor IP khusus dari file log Apache sebesar 2 Gigabyte? Jangan pakai Nano atau VSCode, gunakan pisau bedah mesin UNIX asli: awk & sed.',
                'content' => "<h3>1. Mengapa AWK & SED?</h3>\n<p>Membuka file log bergiga-giga menggunakan text editor (cat/nano/notepad++) akan membuat RAM meledak dan PC hang. <b>awk</b> dan <b>sed</b> itu bersifat <i>stream editor</i>, memeriksa baris demi baris dan membuangnya dari memori detik itu juga!</p>\n<h3>2. Mencari Kolom Unik dengan AWK</h3>\n<p>Log Nginx punya kolom berurutan pas spasi: <code>IP - - [Tgl] \"\" 200 ...</code></p>\n<pre><code class=\"language-bash\"># AWK bisa di suruh nge-print KoloM (Atau variabel ke-1 ($1)) yaitu angka IP\n# Mengextract SELURUH IP SAJA dari log nginx:\nawk '{print \$1}' /var/log/nginx/access.log\n\n# Kasus: Cari dan Hitung Ada Berapa Total Unique (IP yang berbeda-beda) yang ngakses web saya?\nawk '{print \$1}' /var/log/nginx/access.log | sort | uniq -c | sort -nr | head -n 10\n# 1 baris itu langsung menjawab IP siapa saja yang menspam Website Anda (10 Hacker Teratas). Sangat ajaib!</code></pre>\n<h3>3. Global Search & Replace (Timpa Konfig) memakai SED</h3>\n<pre><code class=\"language-bash\"># Kasus: Server Anda di hack dan hacker menyisipkan link judi \"http://judionline\" di 200 file index.php lama\n# Cari semua file dan perintahkan sed (s=Subsitusi)\nsed -i 's/http:\\/\\/judionline/http:\\/\\/aman.com/g' /var/www/html/index.php\n\n# Mengganti port SSH dari 22 jadi 2022 tanpa harus buka text editor!\nsed -i 's/#Port 22/Port 2022/g' /etc/ssh/sshd_config</code></pre>",
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mengintip Arus Bawah Tanah Jaringan: tcpdump & ss',
                'slug' => Str::slug('Menganalisa Jaringan dengan tcpdump dan ss'),
                'category' => 'Debian Server',
                'author' => 'Security Analyst',
                'read_time' => 9,
                'excerpt' => 'Netstat sudah terlalu tua, gunakan \'ss\'. Dan bongkar isi bungkusan paket TCP di kabel server Anda secara Live dari terminal menggunakan rajanya sniffer: Tcpdump!',
                'content' => "<h3>1. SS (Socket Statistics): Pengganti Modern Netstat</h3>\n<pre><code class=\"language-bash\"># ss -tulpen (Kependekan: T=Tcp, U=Udp, L=Listen, P=Process PID, N=Numeric/Jangan reverse ip nya)\n# Perintah ini memberitahu Anda Program Apache (PID 991) sedang mendengarkan/membuka Port 80 dan mengintai bahaya!\nss -tulpen\n\n# Melihat sesi koneksi established yang nyantol dan konek ke user ssh!\nss -at | grep ESTAB</code></pre>\n<h3>2. Tcpdump Menjala Paket Layaknya Spiderman</h3>\n<p>Bos curiga ada yang diam-diam menyedot FTP data dari Server, tapi log proftpd kosong. Ayo bedah kabel ethernet!</p>\n<pre><code class=\"language-bash\"># Panggil tcpdump dan sadap kabel enp0s8, hanya intip port 21 (FTP)\ntcpdump -i enp0s8 port 21\n\n# Mencetak isi Text Ascii yg seliweran polos tanpa TLS Encryption di port 80!\n# A,X=Tampilkan payload Hex dan ascii, -l=(buffer), n=Matikan dns resolution lambat\ntcpdump -i enp0s8 -n -A port 80\n\n# Atau hasil panen sniffer-nya simpan kedalam file .pcap ! \n# File PCAP ini nantinya tinggal Kamu download ke Windows lalu buka lewat GUI WIreshark yg indah dan mudah difilter!\ntcpdump -i enp0s8 -w pakan_wireshark.pcap</code></pre>",
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Membobol Port Firewall dengan SSH Tunneling & Port Forwarding',
                'slug' => Str::slug('SSH Tunneling Port Forwarding Dasar dan Dynamic'),
                'category' => 'Security',
                'author' => 'Penetration Tester',
                'read_time' => 10,
                'excerpt' => 'Website PHPMyAdmin hanya bisa diakses Localhost (127.0.0.1) dari Server VPS AWS? Tembus perisai itu lewat terowongan tanah (SSH Tunnel) masuk kedalam DB lokalnya!',
                'content' => "<h3>1. Kasus dan Trik Gelap</h3>\n<p>Sebuah VM di DigitalOcean ber-IP Pubilk <b>123.123.123.1</b>. MySQL-nya terbuka tapi cuma di <code>localhost:3306</code> dan firewall external menolak koneksi port 3306. Kita punya User SSH ke server tersebut. Bagaimana agar Navicat GUI di Laptop kita (Windows) bisa mendeteksi MySql tsb?</p>\n<h3>2. L-Port (Local Port Forwarding)</h3>\n<pre><code class=\"language-bash\"># Eksekusi di Terminal GitBash / Linux Laptop Kesayangan Kamu:\n# L = Local Port Kita di Laptop yang dikorbankan\n# Format: -L [PortTujuanMintaDiLaptop]:[IP_Tujuan_Dilihat_DariKacaMataServerNYA]:[PortTujuan]\nssh -L 9999:127.0.0.1:3306 root@123.123.123.1 -N -f</code></pre>\n<p>Maksud perintah di atas: <i>\"Wahai ssh, bukakan port 9999 fiktif di Laptopku. Jika aku nyambung ke port 9999 tsb, teleportasikan lewat kabel rahasiamu dan hubungkan ke 127.0.0.1:3306 secara murni!\".</i></p>\n<p>Buka Navicat, koneksi ke: <b>127.0.0.1 port 9999</b>. Croot, tembus masuk MySql di US!</p>\n<h3>3. Dynamic Port Forwarding (SOCKS5 VPN)</h3>\n<pre><code class=\"language-bash\"># Menggunakan flag -D (SOCKS)\nssh -D 1080 root@123.123.123.1 -N -f</code></pre>\n<p>Ini Mengerikan! Seluruh Laptop Kamu memiliki VPN rahasia di Port localhost 1080. Cukup masuk ke Proxy setting Browser Chrome -> Isi Socks Proxy IP 127.0.0.1 Port 1080. Seketika IP Publik kamu berubah menjadi 123.123.123.1 tanpa install Software VPN Server sama sekali!</p>",
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'MAC Dasar: Mandatory Access Control (AppArmor)',
                'slug' => Str::slug('Mandatory Access Control AppArmor Debian'),
                'category' => 'Security',
                'author' => 'Security Expert',
                'read_time' => 7,
                'excerpt' => 'Mengekang Root Server! Walaupun Hacker berhasil mengeksploitasi 0-Day Nginx dan memegang kontrol Web Root, ia TIDAK AKAN BISA berbuat kerusakan karena AppArmor memenjarakannya.',
                'content' => "<h3>1. Bedanya DAC dan MAC</h3>\n<p>Linux normal bergantung pada izin File rwx (<b>DAC</b> / Discretionary Access Control). Jika web dibobol dan hacker naik hak privilege, dia bisa ngerjain OS kita! <b>AppArmor</b> membatasi Program secara spesifik (Contoh: Profil Nginx HANYA BOLEH membaca file berakhiran txt/html/php di folder /var/www dan SAMA SEKALI DILARANG membuka hal lain walaupun ijin DAC-nya 777)!</p>\n<h3>2. Konfigurasi AppArmor Dasar</h3>\n<pre><code class=\"language-bash\">apt install apparmor apparmor-profiles apparmor-utils -y\n\n# Melihat status program mana saja yang dipenjara secara bawaan\naa-status</code></pre>\n<h3>3. Mengekang Program Spesifik (Complain & Enforce)</h3>\n<p>Kalian bisa menyuruh AppArmor membuat profil untuk `myapp`. Mode awalnya adalah <b>Complain</b> (Tidak diblok, namun semua aktivitas aneh dikeluhkan dan ditulisi sebagai peringatan d log syslog untuk bahan pembelajaran polisi). Jika yakin aman, ubah mode jadi <b>Enforce</b> (Tebas tanpa ampun).</p>\n<pre><code class=\"language-bash\"># Masukkan aplikasi spesifik kedalam mode observasi log\naa-complain /usr/sbin/nginx\n\n# Suruh si Polisi membacakan log kelakuan aneh nginx, dan tanya Anda apakah nginx ini emang kita halalkan nyentuh folder anu anu...\naa-logprof\n\n# Jika saringan / profil ijin penjara udah kelar, TEBAS ENFORCE!\naa-enforce /usr/sbin/nginx</code></pre>",
                'level_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Membatasi Ruang Cakra Harddisk User: Linux Disk Quota',
                'slug' => Str::slug('Membatasi Kapasitas Harddisk User Linux Disk Quota'),
                'category' => 'Debian Server',
                'author' => 'System Administrator',
                'read_time' => 5,
                'excerpt' => 'Anda punya 50 Siswa Praktik yang diwajibkan mengupload Web ke Server SSH. Wajib hukumnya mencegah Tono mengisi partisi Linux Anda dengan Drakor memakai Quota sistem!',
                'content' => "<h3>1. Persiapan File System dan Mount Point</h3>\n<p>Quota itu memblok di layer bawah filesystem OS (Ext4/XFS), bukan cuman level software.</p>\n<p>Edit file rahasia dudukan partisi (<code>/etc/fstab</code>). Pada partisi utama (misal ext4 mount / ), tambahkan argumen usrs dan grp quota: <code>usrquota,grpquota</code></p>\n<pre><code class=\"language-bash\"># Reboot atau Mount pelan-pelan ulang OS nya agar sadar kalo ada parameter baru\nmount -o remount /</code></pre>\n<h3>2. Membuat Tabel Databae Quota</h3>\n<pre><code class=\"language-bash\">apt install quota quotatool -y\n\n# Inisiasi File pangkalan Aquota (Perlu dicetak di ROOT / folder induk dari lokasi partisi fstab yg dirubah diatas)\nquotacheck -cumg /</code></pre>\n<h3>3. Mulai Eksekusi Hard/Soft Kuota (Edquota)</h3>\n<pre><code class=\"language-bash\"># Anda sedang mencadangkan pembatasan untuk Siswi bernama Budi!\nedquota -u budi</code></pre>\n<p>Layar nano/vi (Editor Terminal) akan terbuka secara ajaib. Ada parameter block/size:</p>\n<p><i>Soft=2000000</i> (2 GB - akan ngasih error spam warning kalau file Budi menembus ini, tapi masih tetap bisa ngopi file). <i>Hard=2500000</i> (2.5 Gb Maksimal sejati. Jika Budi memaskakan mengopi file drakor 3 GB, sistem akan meledek disk full errror)!</p>\n<pre><code class=\"language-bash\"># Mau copy template settingan Budi ke Siswa bernama Tono dan Joni secepat kilat?\nedquota -p budi tono joni\n\n# Mengaktifkan saklar pengaman listrik! GO GO!\nquotaon /</code></pre>",
                'level_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
