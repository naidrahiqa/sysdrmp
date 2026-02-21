<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpertSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Membangun Proxmox VE Cluster (High Availability Datacenter)',
                'slug' => Str::slug('Membangun Proxmox VE Cluster High Availability'),
                'category' => 'Cloud',
                'author' => 'Datacenter Architect',
                'read_time' => 12,
                'excerpt' => 'Gabungkan 3 Server Fisik menjadi 1 kesatuan Cluster. Jika Server 1 terbakar, VM akan otomatis pindah dan hidup lagi di Server 2!',
                'content' => "<h3>1. Apa itu Proxmox Cluster?</h3>\n<p>Jika Anda punya 1 server berisi 50 VM lalu listriknya mati, perusahaan rugi besar. Dengan Cluster, Anda butuh minimal 3 Server (disebut Node) untuk mendapatkan <b>Quorum/Voting mayoritas</b>. Mereka akan saling membagi storage (Ceph) dan state VM. Jika Node A mati, Node B dan C akan memilih pemimpin baru dan menghidupkan paksa VM yang mati di tempat mereka <i>(High Availability)</i>.</p>\n<h3>2. Persiapan Network Corosync</h3>\n<p>Cluster butuh jalur belakang (Backbone Network) khusus agar antar-node bisa berbisik-bisik (heartbeat) mengecek siapa yang masih bernafas setiap detiknya.</p>\n<pre><code class=\"language-bash\"># Pastikan Node 1, Node 2, Node 3 bisa saling ping via IP lokal backbone\nping 10.10.10.2\nping 10.10.10.3</code></pre>\n<h3>3. Membentuk Cluster di Node 1 (Master Semu)</h3>\n<pre><code class=\"language-bash\"># Membuat identitas grup cluster bernama 'DatacenterMaster'\npvecm create DatacenterMaster\n\n# Mengecek status siapa saja yang bergabung (saat ini cuma node 1)\npvecm status</code></pre>\n<h3>4. Menggabungkan / Node 2 dan 3 Kedalam Cluster</h3>\n<pre><code class=\"language-bash\"># Login SSH ke Node 2, lalu ketik perintah JOIN menargetkan IP Node 1\npvecm add 10.10.10.1\n\n# Saat ditanya password, masukkan password root dari Node 1! Lakukan hal serupa di Node 3.\n# Setelah ketiganya tergabung, Quorum (Syarat minimal 2 node hidup) berhasil tercapai!</code></pre>",
                'level_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kubernetes Lanjut: Manajemen Ingress dan Helm Charts',
                'slug' => Str::slug('Kubernetes Lanjut Ingress dan Helm Charts'),
                'category' => 'DevOps',
                'author' => 'Cloud Engineer',
                'read_time' => 10,
                'excerpt' => 'Jangan mengekspos NodePort sembarangan! Gunakan Nginx Ingress Controller dan automasi deploy dengan Helm (Apt-get nya Kubernetes).',
                'content' => "<h3>1. Kenapa Kurang Cukup Hanya Pakai Service NodePort?</h3>\n<p>NodePort membuka port acak (30000-32767) pada IP Fisik Server. Ini tidak etis untuk Web Production. Kita butuh Port 80 dan 443 standar. Jawabannya adalah <b>Ingress</b> - sebuah Load Balancer L7 / Reverse Proxy pintar yang berjalan DI DALAM k8s.</p>\n<h3>2. Menginstal Helm (Package Manager K8s)</h3>\n<pre><code class=\"language-bash\">curl -fsSL -o get_helm.sh https://raw.githubusercontent.com/helm/helm/master/scripts/get-helm-3\nchmod 700 get_helm.sh\n./get_helm.sh</code></pre>\n<h3>3. Deploy Nginx Ingress Controller via Helm</h3>\n<pre><code class=\"language-bash\"># Masukkan repository helm nginx\nhelm repo add ingress-nginx https://kubernetes.github.io/ingress-nginx\nhelm repo update\n\n# Install Ingress Guard \nhelm install my-ingress ingress-nginx/ingress-nginx</code></pre>\n<h3>4. Membuat Aturan Ingress (Manifest Ingress.yml)</h3>\n<pre><code class=\"language-yaml\">apiVersion: networking.k8s.io/v1\nkind: Ingress\nmetadata:\n  name: ingress-utama-perusahaan\nspec:\n  ingressClassName: nginx\n  rules:\n  - host: www.perusahaan.com  # Jika client request ke domain ini\n    http:\n      paths:\n      - path: /\n        pathType: Prefix\n        backend:\n          service:\n            name: web-service-internal  # Maka buang trafiknya masuk ke service web k8s didalam!\n            port:\n              number: 80</code></pre>",
                'level_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Praktek BGP MikroTik Lanjut: BGP Peering dan AS-Path Prepend',
                'slug' => Str::slug('Praktek BGP MikroTik Lanjut BGP Peering AS-Path Prepend'),
                'category' => 'Networking',
                'author' => 'ISP Core Engineer',
                'read_time' => 11,
                'excerpt' => 'Bagaimana mengatur rute utama dan rute cadangan jika website Anda ditembak dari 2 Provider (Telkom dan Indosat) menggunakan atribut AS-Path-Prepend.',
                'content' => "<h3>1. Manipulasi Rute Inbound Traffic Internet</h3>\n<p>Masalah: Anda punya 2 ISP (ISPA dan ISPB). Anda mengiklankan IP Publik block /24 Anda ke keduanya. Bagaimana cara agar Trafik Download (Inbound pengunjung Web dari luar) 90% diarahkan MAJU lewat ISPA (Kencang) dan ISPB hanya dijadikan backup?</p>\n<h3>2. Konsep AS-Path (Atribut Panjang Jalan)</h3>\n<p>BGP memilih jalur berdasarkan rute TERPENDEK (AS-Path terkecil). Jika kita <i>menggoreng/memalsukan</i> panjang AS kita pada iklan rute ke ISPB, maka dunia akan memandang \"Lewat ISP B jaluaran-nya ruwet dan panjang\", otomatis seluruh Asia akan mengakses web kita lewat ISPA!</p>\n<h3>3. Terapkan Filter AS-Path Prepend (Manipulasi)</h3>\n<pre><code class=\"language-bash\">/routing filter rule\n# Buat aturan keluar (OUT) khusus menembak ISPB\nadd chain=bgp-out-ISPB rule=\"if (dst == 202.1.1.0/24) { set bgp-path-prepend 3; accept; }\"\n\n# Panggil Filter Route map tersebut pada konfigurasi Peering BGP\n/routing bgp connection\nset [ find name=to-ISPB ] output.filter=bgp-out-ISPB</code></pre>\n<p><i>As-Path-Prepend 3</i> berarti Router MikroTik kita akan MENDUPLIKAT (menambahkan) nomor plat perusahaan AS NUMBER kita sebanyak 3 kali berturut-turut pada brosur penyebaran IP kita saat melewati ISPB. Google akan melihat ISPA (1 AS), sedangkan dari ISPB (3 AS), jadi trafik diprioritaskan lewat A!</p>",
                'level_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cisco CCNP: OSPF Lanjut Berbeda Area (Multi-Area)',
                'slug' => Str::slug('Cisco CCNP OSPF Lanjut Multi Area'),
                'category' => 'Networking',
                'author' => 'Network Architect',
                'read_time' => 8,
                'excerpt' => 'Mencegah CPU Router meledak. Desain Hirarki Area OSPF (Backbone Area 0) dan ABR (Area Border Router).',
                'content' => "<h3>1. Kenapa Tidak Semua Dimasukkan Area 0?</h3>\n<p>Algoritma SPF (Dijkstra) memakan RAM & CPU besar. Jika ada 500 Router dalam 1 area, ketika 1 link mati, ke-500 Router akan menghitung ulang seluruh topologi! Pemecahannya adalah membuat Area 1, Area 2, dan Area 0 (Backbone Utama).</p>\n<h3>2. ABR (Area Border Router) Sang Jembatan</h3>\n<p>Router yang kakinya menjejak dua dunia. Interface Gigabit0 masuk ke Area 0, Gigabit1 masuk ke Area 1. Tugasnya MENGKASAR/MERINGKAS (Summarization) informasi Area 1 untuk dilempar ke Area 0.</p>\n<pre><code class=\"language-bash\"># Konfigurasi di Router Tengah ABR\nrouter ospf 1\n# Interface yang mengarah ke Inti Backbone Perusahaan\n network 10.0.0.0 0.0.0.255 area 0\n# Interface yang mengarah ke Cabang Gedung Timur\n network 172.16.0.0 0.0.255.255 area 1</code></pre>\n<h3>3. Route Summarization di ABR</h3>\n<p>Daripada Area 0 dikirimi 10 IP gang kecil LAN dari Area 1, suruh ABR menyingkatnya jadi 1 Rute Supernet.</p>\n<pre><code class=\"language-bash\">router ospf 1\n# Menyebutkan bahwa Area 1 tolong dirangkum totalnya menjadi prefix sakti /16\n area 1 range 172.16.0.0 255.255.0.0</code></pre>\n<p>Dengan teknik tingkat lanjut CCNP ini, stabilitas routing korporat raksasa terjamin.</p>",
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Arsitektur Database Terdistribusi: Galera Cluster (MariaDB)',
                'slug' => Str::slug('Arsitektur Database Terdistribusi Galera Cluster MariaDB'),
                'category' => 'Database',
                'author' => 'Database Administrator',
                'read_time' => 9,
                'excerpt' => 'Tinggalkan Master-Slave (Aktif-Pasif). Selamat datang di Master-Master (Multi-Primary) sinkron MySQL Replication tanpa jeda dengan Galera.',
                'content' => "<h3>1. Master-Slave vs Galera (Multi-Master)</h3>\n<p>Replikasi Slave biasa itu Asynchronous (lambat) dan READ-ONLY. Jika Master mati, aplikasi Anda EROR karena tidak bisa INSERT. Dengan <b>Galera Cluster</b>, Anda punya 3 Server MySQL yang semuanya adalah MASTER sejati. Anda bisa <i>INSERT/DELETE</i> di Node 1, dan seketika berubah di Node 3 di mili-detik yang sama berdasarkan algoritma sertifikasi sinkronnya.</p>\n<h3>2. Instalasi Paket Tambahan Galera</h3>\n<pre><code class=\"language-bash\">apt install mariadb-server galera-4 mariadb-client -y</code></pre>\n<h3>3. Konfigurasi Inti di Semua Node</h3>\n<p>Buka <code>/etc/mysql/mariadb.conf.d/50-server.cnf</code> dan aktifkan mode wsrep.</p>\n<pre><code class=\"language-ini\">[galera]\n# Memilih provider plugin sinkronisasi!\nwsrep_on=ON\nwsrep_provider=/usr/lib/galera/libgalera_smm.so\n\n# Memasukkan IP ketiga Node secara berurutan agar mereka tahu saudaranya\nwsrep_cluster_address=\"gcomm://192.168.10.11,192.168.10.12,192.168.10.13\"\nwsrep_cluster_name=\"DB_Cenat_Cenut\"\nwsrep_node_address=\"192.168.10.11\" # Ganti ini sesuai IP Node tempat ngedit\n\n# Format penyimpanan engine diwajibkan INNODB!\ndefault_storage_engine=InnoDB\ninnodb_autoinc_lock_mode=2</code></pre>\n<h3>4. Bootstrapping (Menyulut Cluster)</h3>\n<p>Tugas pertama (hanya untuk Node 1) adalah membangun cluster yang masih belum ada. JANGAN NYALAKAN SYSTEMCTL DULU!</p>\n<pre><code class=\"language-bash\"># Menyalakan api cluster perdana di dunia (Node Pertama)\ngalera_new_cluster\n\n# Buka Node 2 & 3, lalu jalankan normal (Mereka akan otomatis nge-push data ke node 1)\nsystemctl restart mariadb</code></pre>\n<p>Cluster DB kelas Bank Konvensional siap digunakan aplikasimu!</p>",
                'level_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Monitoring Ekstrem dengan ELK Stack (Elasticsearch, Logstash, Kibana)',
                'slug' => Str::slug('Monitoring Ekstrem dengan ELK Elasticsearch Logstash Kibana'),
                'category' => 'Cloud',
                'author' => 'System Architect',
                'read_time' => 10,
                'excerpt' => 'Mesin pencari log ratusan Gigabyte. Sentralisasi Log Apache, Mikrotik, Firewall dan menampilkannya di Dashboard ala Intelijen.',
                'content' => "<h3>1. Apa itu ELK?</h3>\n<ul>\n<li><b>Elasticsearch:</b> Database spesial pencari teks layaknya otak mesin Google.</li>\n<li><b>Logstash:</b> Parit saluran (Pipeline) yang mencerna / memfilter jutaan baris log kotor menjadi format JSON rapi.</li>\n<li><b>Kibana:</b> Papan Dasbor Web yang mewah berisi Grafis visualisasi log.</li>\n</ul>\n<h3>2. Setup Sederhana via Docker Compose!</h3>\n<pre><code class=\"language-yaml\">version: '3'\nservices:\n  elasticsearch:\n    image: docker.elastic.co/elasticsearch/elasticsearch:8.10.2\n    environment:\n      - discovery.type=single-node\n      - xpack.security.enabled=false # Matiin security password pasang-awal (Bahaya tapi cepat untuk tes)\n    ports:\n      - \"9200:9200\"\n\n  kibana:\n    image: docker.elastic.co/kibana/kibana:8.10.2\n    ports:\n      - \"5601:5601\"\n    environment:\n      - ELASTICSEARCH_HOSTS=http://elasticsearch:9200\n    depends_on:\n      - elasticsearch</code></pre>\n<h3>3. Menghisap Log Menggunakan Filebeat</h3>\n<p>Daripada Logstash, di ujung klien server (Korbannya), kita pasang agen pembantu bernama <b>Filebeat</b> (ringan).</p>\n<pre><code class=\"language-bash\">apt install filebeat -y\n# Ubah filebeat.yml untuk memonitor letak log Nginx\nfilebeat.inputs:\n- type: log\n  paths: [\"/var/log/nginx/access.log\"]\n\n# Outputkan log tembak langsung ke Elasticsearch container\noutput.elasticsearch:\n  hosts: [\"192.168.10.20:9200\"]</code></pre>\n<p>Buka UI Kibana di port 5601. Mulailah menganalisis Data Logs trafik web dalam bentuk bar chart keren!</p>",
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Automasi Infrastruktur Lanjut: Terraform Multi-Cloud Environment',
                'slug' => Str::slug('Automasi Infrastruktur Lanjut Terraform Multi-Cloud'),
                'category' => 'DevOps',
                'author' => 'Cloud DevOps Engineer',
                'read_time' => 8,
                'excerpt' => 'Menulis syntax permohonan Infrastruktur (IaC) yang dapat menciptakan server di Amazon AWS, Google GCP, dan Azure secara serempak dengan 1 Tombol Eksekusi!',
                'content' => "<h3>1. Terraform: Si Pejabat Proyek (Agnostik)</h3>\n<p>HCL (HashiCorp Configuration Language) memungkinkan kita mengomandoi API semua raksasa Cloud dari 1 file <code>main.tf</code>.</p>\n<h3>2. Kode Infrastructure Beda Provider (Mutli-Provider)</h3>\n<p>Buka file <code>multicloud.tf</code>:</p>\n<pre><code class=\"language-hcl\"># Mendefinisikan Provider Kanan & Kiri\nprovider \"aws\" {\n  region = \"us-east-1\"\n}\nprovider \"google\" {\n  project = \"perusahaanku-2311\"\n  region  = \"us-central1\"\n}\n\n# Menciptakan EC2 Server di AWS (Amerika)\nresource \"aws_instance\" \"database_backend\" {\n  ami           = \"ami-0c55b159cbfafe1f0\"  # ID OS Ubuntu\n  instance_type = \"t2.micro\"\n}\n\n# Bersamaan dengan diciptakannya Server VPC di GCP (Google)\nresource \"google_compute_instance\" \"web_frontend\" {\n  name         = \"web-server-gcp\"\n  machine_type = \"e2-micro\"\n  zone         = \"us-central1-a\"\n\n  boot_disk {\n    initialize_params { image = \"debian-cloud/debian-11\" }\n  }\n  network_interface { network = \"default\" }\n}</code></pre>\n<h3>3. Siklus Penciptaan</h3>\n<pre><code class=\"language-bash\"># 1. Menginisialisasi modul API penghubung AWS dan GCP\nterraform init\n# 2. Merencanakan dan mendeteksi kesalahan sintax\nterraform plan\n# 3. MENGUBAH Kode Teks anda di layar menjadi Besi Mesin Fisik nyata di Data Center Sillicon Valley!\nterraform apply -auto-approve</code></pre>",
                'level_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
