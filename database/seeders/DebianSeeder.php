<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DebianSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Menguasai Docker & Docker Compose untuk Deployment',
                'slug' => Str::slug('Menguasai Docker dan Docker Compose untuk Deployment'),
                'category' => 'Debian Server',
                'author' => 'DevOps Engineer',
                'read_time' => 15,
                'excerpt' => 'Panduan super padat menguasai containerization: Instalasi Docker Engine, manajemen container dasar, hingga orkestrasi layanan.',
                'content' => "<h3>1. Apa itu Docker?</h3>\n<p>Docker memungkinkan kita membungkus aplikasi dan dependensinya ke dalam wadah terisolasi yang disebut <b>Container</b>.</p>\n<h3>2. Instalasi Docker Engine di Debian</h3>\n<pre><code class=\"language-bash\"># Menambahkan GPG key resmi Docker untuk verifikasi paket\ncurl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg\n\n# Update dan Install komponen utama Docker Engine, CLI, dan Compose Plugin\napt update\napt install docker-ce docker-ce-cli containerd.io docker-compose-plugin -y</code></pre>\n<h3>3. Perintah Essensial Docker</h3>\n<pre><code class=\"language-bash\"># -d artinya detach (jalan di background)\n# -p 8080:80 artinya port 8080 di Debian dilempar ke port 80 milik Container\ndocker run -d -p 8080:80 --name webku nginx:latest\n\n# Melihat container yang sedang running atau sudah mati (-a)\ndocker ps -a\n\n# Menghapus paksa container bernama webku\ndocker rm -f webku</code></pre>\n<h3>4. Orkestrasi dengan Docker Compose</h3>\n<pre><code class=\"language-yaml\">version: '3.8'\nservices:\n  db:\n    image: mariadb:10.5 # Menarik image database mariadb versi 10.5\n    environment:\n      MYSQL_ROOT_PASSWORD: rahasia # Otomatis mengatur password root MariaDB saat container pertama kali hidup\n      MYSQL_DATABASE: db_app # Otomatis membuatkan database kosong\n    volumes:\n      - db_data:/var/lib/mysql # Mengikat storage agar data tidak hilang walau container dihapus\n  wordpress:\n    depends_on:\n      - db # Wordpress tidak akan jalan sebelum DB siap\n    image: wordpress:latest\n    ports:\n      - \"80:80\"\nvolumes:\n  db_data: # Inisialisasi volume persisten (Penyimpanan permanen docker)</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Monitoring Infrastruktur dengan Prometheus & Grafana',
                'slug' => Str::slug('Monitoring Infrastruktur dengan Prometheus dan Grafana'),
                'category' => 'Debian Server',
                'author' => 'System Reliability Engineer',
                'read_time' => 12,
                'excerpt' => 'Membangun arsitektur pemantauan server modern. Mengumpulkan metrics menggunakan Prometheus Node Exporter dan membuat dashboard visual di Grafana.',
                'content' => "<h3>1. Arsitektur Monitoring Modern</h3>\n<p>Kita akan menggunakan kombinasi <b>Prometheus</b> (Time-Series Database dan Data Puller) dan <b>Grafana</b> (Visualisasi).</p>\n<h3>2. Instalasi Prometheus dan Agen</h3>\n<pre><code class=\"language-bash\"># Prometheus adalah database sentralnya\n# Node-exporter adalah 'agen/mata-mata' yang diinstall di setiap Server Target agar servernya bisa dipantau RAM/CPU nya\napt install prometheus prometheus-node-exporter -y</code></pre>\n<h3>3. Instalasi Grafana Enterprise</h3>\n<pre><code class=\"language-bash\"># Menambahkan Repo Resmi Grafana APT Repository\napt-get install -y apt-transport-https software-properties-common wget\nwget -q -O /usr/share/keyrings/grafana.key https://apt.grafana.com/gpg.key\necho \"deb [signed-by=/usr/share/keyrings/grafana.key] https://apt.grafana.com stable main\" | tee /etc/apt/sources.list.d/grafana.list\n\n# Install dan Hidupkan Layanan GUI Grafana\napt update\napt install grafana -y\nsystemctl enable --now grafana-server</code></pre>\n<h3>4. Konfigurasi Dashboard</h3>\n<p>Buka <code>http://IP_SERVER:3000</code>. Di menu Data Source Grafana, arahkan ke IP Prometheus <code>http://localhost:9090</code>. Selanjutnya tinggal Import ID Dashboard grafis keren: <b>1860</b> (Node Exporter Full).</p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Otomatisasi Server dengan RedHat Ansible',
                'slug' => Str::slug('Otomatisasi Server dengan RedHat Ansible'),
                'category' => 'Debian Server',
                'author' => 'Infra Coder',
                'read_time' => 14,
                'excerpt' => 'Tinggalkan Instalasi Manual. Belajar mengelola dan menginstal paket di puluhan server secara bersamaan hanya dengan 1 baris skrip Playbook.',
                'content' => "<h3>1. Selamat datang di era Infrastructure as Code (IaC)</h3>\n<p>Ansible memungkinkan intruksi itu berjalan paralel dengan format manifest YAML murni tanpa agen (via SSH murni).</p>\n<h3>2. Instalasi Control Node</h3>\n<pre><code class=\"language-bash\">apt update\n# Install master panel Ansible di 1 PC Admin saja\napt install ansible -y</code></pre>\n<h3>3. Membuat File Inventory (Daftar Korban)</h3>\n<pre><code class=\"language-ini\"># Membuat grup yang berisikan IP server target yang akan kita kendalikan remotenya\n[webservers]\n192.168.10.11\n192.168.10.12</code></pre>\n<h3>4. Setup Kunci SSH Tanpa Password</h3>\n<p>Wajib menggunakan <code>ssh-keygen</code> dan copy pubkey (<code>ssh-copy-id</code>) ke seluruh server target supaya command Ansible berhasil tanpa prompt password.</p>\n<h3>5. Membuat Ansible Playbook</h3>\n<p>Mari buat resep bernama <code>install_web.yaml</code>.</p>\n<pre><code class=\"language-yaml\">---\n- name: Otomatisasi Instalasi Nginx Web Server\n  hosts: webservers # Sasaran: Grup webservers di file inventory\n  become: yes # Mode sudo / Root Access ditiap server target\n  tasks:\n    - name: Memastikan Apache2 terinstall\n      apt:\n        name: apache2\n        state: present # Present = Minta tolong di installkan kalo blm ada\n\n    - name: Memastikan layanan apache berjalan hidup\n      systemd:\n        name: apache2\n        state: started # Paksa running\n        enabled: yes # Tanam auto-start on boot</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'High Availability: Load Balancing menggunakan HAProxy',
                'slug' => Str::slug('High Availability Load Balancing menggunakan HAProxy'),
                'category' => 'Debian Server',
                'author' => 'DevOps Architect',
                'read_time' => 10,
                'excerpt' => 'Jangan biarkan web mati jika 1 server down! Membagi trafik kunjungan ke banyak server backend dengan metode Round-Robin.',
                'content' => "<h3>1. Instalasi HAProxy</h3>\n<pre><code class=\"language-bash\"># HAProxy adalah software the-best untuk urusan pembagian beban jaringan\napt install haproxy -y</code></pre>\n<h3>2. Konfigurasi Backend & Frontend</h3>\n<p>Edit file <code>nano /etc/haproxy/haproxy.cfg</code>:</p>\n<pre><code class=\"language-ini\">frontend http_front\n    # Menangkap semua akses dari public web di port 80\n    bind *:80\n    # Arahkan arus jalanan HTTP ke Terminal Backend bernama web_backend_pool\n    default_backend web_backend_pool\n\nbackend web_backend_pool\n    # Metode pembagian sama rata secara bergilir (1-2-1-2)\n    balance roundrobin\n    # Daftar server lokal sesungguhnya beserta 'check' untuk memeriksa server sedang Hidup/Mati\n    server web1 192.168.10.11:80 check\n    server web2 192.168.10.12:80 check</code></pre>\n<h3>3. Reload & Uji Coba</h3>\n<pre><code class=\"language-bash\"># Terapkan konfig tanpa memutus aktifitas jaringan yang lagi jalan (Graceful reload)\nsystemctl reload haproxy</code></pre>",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
