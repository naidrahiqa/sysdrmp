<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GeneratorSeeder extends Seeder
{
    public function run(): void
    {
        $technologies = [
            ['name' => 'Nginx', 'cat' => 'Debian Server', 'cmd' => 'apt install nginx -y'],
            ['name' => 'Apache2', 'cat' => 'Debian Server', 'cmd' => 'apt install apache2 -y'],
            ['name' => 'MySQL 8', 'cat' => 'Database', 'cmd' => 'apt install mysql-server -y'],
            ['name' => 'PostgreSQL 15', 'cat' => 'Database', 'cmd' => 'apt install postgresql-15 -y'],
            ['name' => 'MongoDB', 'cat' => 'Database', 'cmd' => 'apt install mongodb-org -y'],
            ['name' => 'Redis Cluster', 'cat' => 'Database', 'cmd' => 'apt install redis-server -y'],
            ['name' => 'Docker Engine', 'cat' => 'DevOps', 'cmd' => 'apt install docker-ce docker-ce-cli containerd.io -y'],
            ['name' => 'Kubernetes (K3s)', 'cat' => 'DevOps', 'cmd' => 'curl -sfL https://get.k3s.io | sh -'],
            ['name' => 'Proxmox VE', 'cat' => 'Cloud', 'cmd' => 'apt install proxmox-ve postfix open-iscsi -y'],
            ['name' => 'PfSense Firewall', 'cat' => 'Networking', 'cmd' => '# Gunakan ISO FreeBSD untuk Install PfSense'],
            ['name' => 'MikroTik RouterOS', 'cat' => 'Networking', 'cmd' => '/system package update install'],
            ['name' => 'Cisco IOS BGP', 'cat' => 'Networking', 'cmd' => 'copy running-config startup-config'],
            ['name' => 'Ubuntu Server 24.04', 'cat' => 'Debian Server', 'cmd' => 'do-release-upgrade'],
            ['name' => 'AWS EC2 Instances', 'cat' => 'Cloud', 'cmd' => 'aws ec2 run-instances --image-id ami-xxxxxxxx'],
            ['name' => 'Ansible Playbooks', 'cat' => 'DevOps', 'cmd' => 'apt install ansible -y'],
            ['name' => 'Terraform Modules', 'cat' => 'DevOps', 'cmd' => 'terraform init && terraform apply'],
            ['name' => 'Prometheus Time-Series DB', 'cat' => 'Cloud', 'cmd' => 'apt install prometheus -y'],
            ['name' => 'Grafana Dashboard', 'cat' => 'Cloud', 'cmd' => 'apt-get install -y grafana'],
            ['name' => 'Zimbra Mail Server', 'cat' => 'Debian Server', 'cmd' => './install.sh'],
            ['name' => 'Active Directory (AD DS)', 'cat' => 'Windows Server', 'cmd' => 'Install-WindowsFeature -Name AD-Domain-Services -IncludeManagementTools'],
            ['name' => 'Squid Proxy', 'cat' => 'Security', 'cmd' => 'apt install squid -y'],
            ['name' => 'Suricata IDS', 'cat' => 'Security', 'cmd' => 'apt install suricata -y'],
            ['name' => 'Elasticsearch Logstash', 'cat' => 'Cloud', 'cmd' => 'apt install elasticsearch -y'],
            ['name' => 'Fail2Ban Jails', 'cat' => 'Security', 'cmd' => 'apt install fail2ban -y'],
            ['name' => 'GlusterFS Storage', 'cat' => 'Debian Server', 'cmd' => 'apt install glusterfs-server -y'],
            ['name' => 'OpenLDAP Centralized Login', 'cat' => 'Security', 'cmd' => 'apt install slapd ldap-utils -y'],
            ['name' => 'Windows Server IIS', 'cat' => 'Windows Server', 'cmd' => 'Install-WindowsFeature -name Web-Server -IncludeManagementTools'],
        ];

        $actions = [
            ['title' => 'Quick Setup (Instalasi Cepat)', 'lvl' => 1, 'desc' => 'Panduan teruji langkah demi langkah (Step-by-step) untuk melakukan instalasi awal (Provisioning) yang stabil ke mesin Production.'],
            ['title' => 'Security Hardening (Konfigurasi Pengamanan)', 'lvl' => 3, 'desc' => 'Menutup celah akses berbahaya (Vulnerability) dari setingan default pabrik untuk menghindari serangan Botnet maupun Ransomware.'],
            ['title' => 'Performance Tuning (Optimasi Maksimal)', 'lvl' => 3, 'desc' => 'Memodifikasi parameter internal (Core) agar sistem mampu menampung 10,000 pengguna bersamaan (Concurrent Users) tanpa membuat CPU/RAM over-utilization.'],
            ['title' => 'Backup & Disaster Recovery', 'lvl' => 2, 'desc' => 'Merancang otomatisasi tugas (Cron Job) untuk proses pencadangan (Backup) data dan database periodik agar gampang dipulihkan (Restore) saat terjadi bencana.'],
            ['title' => 'Arsitektur High Availability (HA)', 'lvl' => 4, 'desc' => 'Mendesain infrastruktur berbasis redundansi (Active-Active) Multi Node tanpa menyisakan satupun titik kegagalan tunggal (Single Point of Failure).'],
            ['title' => 'System Observability (Monitoring Terpusat)', 'lvl' => 2, 'desc' => 'Memasang agen pemantauan pada server target (Node) untuk divisualisasikan menjadi metrik log dan grafik secara langsung (Real-time).'],
            ['title' => 'Troubleshooting & Log Analysis', 'lvl' => 2, 'desc' => 'Sebuah kompilasi trik cerdas untuk memecahkan kepanikan sistem (Kernel Panics) dan kesalahan fatal (Critical Errors) langsung dari studi kasus lapangan.'],
        ];
        
        $authors = ['System Administrator', 'DevOps Automator', 'Cloud Storage Architect', 'Network Engineer SP', 'Security Penetration', 'Database Architect'];

        $articles = [];

        for ($i = 1; $i <= 100; $i++) {
            $tech = $technologies[array_rand($technologies)];
            $action = $actions[array_rand($actions)];
            
            $title = $action['title'] . ': ' . $tech['name'];
            $slug = Str::slug($title . '-' . Str::random(6));
            $author = $authors[array_rand($authors)];
            
            $excerpt = "Seri Dokumentasi #{$i}: {$action['desc']} Kajian teknis penerapan {$tech['name']} terbaru di ranah Physical Server maupun Cloud Environment.";
            
            $content = "<h3>1. Analisis Implementasi (Deployment Analysis)</h3>\n";
            $content .= "<p>Di dalam ekosistem Datacenter modern berskala masif, stabilitas implementasi produk <b>{$tech['name']}</b> memegang fungsi teramat sentral demi menjaga keberlangsungan <i>Service Level Agreement (SLA)</i>. Artikel lab ini disusun berdasarkan studi kasus lapangan (Best Practices) oleh seorang {$author} yang memiliki spesialisasi khusus pada lingkup pengerjaan: <i>{$action['title']}</i>.</p>\n";
            
            $content .= "<h3>2. Latar Belakang & Use Case</h3>\n";
            $content .= "<p>{$action['desc']} Tim IT seringkali terkendala waktu jika harus membaca habis dokumentasi rilis pabrikan (Official Docs) yang kadang terasa terlalu kaku dan teoritis (Monolithic). Oleh karena itu, semua elemen teknikal yang rumit di sini sudah dilebur menjadi ringkasan yang lebih taktis dan berfokus pada praktik murni (Hands-on Oriented).</p>\n";
            
            $content .= "<h3>3. Rangkaian Komando (Command-Line Execution)</h3>\n";
            $content .= "<p>Sila salin rangkuman sintaks cepat (Cheat-sheet) berikut, lalu eksekusi (Enter) secara langsung pada jendela CLI/Terminal server Anda. Selalu pastikan Anda menjalankan prosedur krusial ini menggunakan <i>Privilege Escalation</i> (Akses Root/Administrator tingkat tinggi):</p>\n";
            $content .= "<pre><code class=\"language-bash\"># Tahap 1. Membersihkan residu cache dari dependensi (Dependencies) instalasi terdahulu\napt clean && apt autoremove -y\n\n# Tahap 2. Proses Provisioning Engine Utama Target\n{$tech['cmd']}\n\n# Tahap 3. Buka File Konfigurasi Induk/Primer (Gunakan Text Editor CLI seperti nano / vim)\nnano /etc/nama-platform-rahasia.conf\n\n# Modifikasi alokasi Buffer Memory dan Bind Address Listener IP (Opsional namun disarankan):\n# ListenAddress = 0.0.0.0\n# MaxRamUsed = 4GB \n\n# Tahap 4. Memuat ulang siklus kontrol Daemon (Restart Service) agar mesin menerima perubahan State terbaru!\nsystemctl restart nama-program-target</code></pre>\n";
            
            $content .= "<h3>4. Pengecekan Kesehatan (Sanity Check & Verifikasi Lanjut)</h3>\n";
            $content .= "<p>Tindakan fatal (Tabu) bagi seorang <b>{$author}</b> adalah langsung meninggalkan pelataran console pasca-konfigurasi seakan-akan tugas beres begitu saja! Anda wajib dan mutlak melakukan verifikasi validasi sistem (Sanity Check) mandiri. Lacak terbukanya Port <i>Listening</i> dengan utilitas <code>ss -tulpen</code>, periksa filter inspeksi Firewall, dan jangan lupa mengaudit aliran Log kejadian (Event Logs) memakai <code>journalctl -xe</code> secara berkala demi menjamin keandalannya.</p>";
            $content .= "<p>Sampai jumpa lagi pada sesi bahasan lanjutan (Advanced Modules) di halaman berikutnya!</p>";

            $articles[] = [
                'title' => $title,
                'slug' => $slug,
                'category' => $tech['cat'],
                'author' => $author,
                'read_time' => rand(4, 15),
                'excerpt' => $excerpt,
                'content' => $content,
                'level_id' => $action['lvl'],
                'created_at' => now()->subHours(rand(1, 240)),
                'updated_at' => now(),
            ];
        }

        // Chunking the insert to avoid query limits
        foreach (array_chunk($articles, 50) as $chunk) {
            DB::table('articles')->insert($chunk);
        }
    }
}
