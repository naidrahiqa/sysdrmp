<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">🐧 The SysAdmin Roadmap (SYSRDMP)</h1>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-11-FF2D20.svg?style=flat&logo=laravel" alt="Laravel 11"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=flat&logo=php" alt="PHP 8"></a>
  <a href="#"><img src="https://img.shields.io/badge/Database-SQLite-003B57.svg?style=flat&logo=sqlite" alt="SQLite"></a>
  <a href="#"><img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3.svg?style=flat&logo=bootstrap" alt="Bootstrap 5"></a>
</p>

<h3 align="center">Platform Pembelajaran & Kurikulum Mandiri IT Network & System Administrator</h3>

---

## 📖 Tentang Aplikasi
**The SysAdmin Roadmap** adalah platform edukasi dokumentasi dan panduan <i>best-practices</i> berbahasa Indonesia untuk mempersiapkan keahlian di bidang infrastruktur TI (Sistem Administrator, Network Engineer, DevOps, dan Cloud Computing). Aplikasi ini dibangun murni menggunakan framework Laravel dengan perpaduan desain antarmuka yang modern, cepat, dan nyaman dibaca.

Di dalamnya mencakup ratusan modul pembelajaran mulai dari tingkat dasar (Pemula) hingga tahap lanjutan (Expert / Arsitek).

## 🚀 Fitur Utama

- **📚 Kurikulum Terstruktur**: Materi dipecah berdasarkan Kategori (Debian Server, Windows Server, Networking, Security, DevOps, Cloud).
- **📶 Indikator Leveling**: Penanda tingkat kesulitan materi (🟢 Pemula, 🟡 Menengah, 🟠 Lanjut, 🔴 Ahli).
- **🔍 Pencarian Dinamis**: Mencari konfigurasi spesifik atau mengatasi troubleshooting error dengan cepat.
- **📱 Desain Responsif**: Antarmuka berbasis Bootstrap yang mendukung tampilan mobile, tablet, maupun desktop.
- **🕶️ Mode Modern**: Clean UI layout dengan tipografi `Inter`/`Space Grotesk` yang memberikan kesan rapi ala dokumentasi enterprise.

## 🛠️ Modul Pembelajaran Tersedia

1. **Linux System Administration (Debian/Ubuntu)**: Manajemen File, Iptables Firewall, Web Server (Apache/Nginx), Mail Server (Postfix, Dovecot), Proxy (Squid), Storage (LVM & ZFS).
2. **Windows Server Administration**: Active Directory (AD DS), Group Policy Object (GPO), File Server Resource Manager (FSRM), Distributed File System (DFS), WSUS.
3. **Advanced Networking (Mikrotik & Cisco)**: Routing Dinamis (OSPF & BGP), Tunneling (EoIP, WireGuard, OpenVPN), VLAN & VTP, Load Balancing PCC, Manajemen QoS.
4. **DevOps & Cloud Computing**: Docker & Docker Compose Containerization, Git Version Control, Ansible Automation, Kubernetes (K8s), CI/CD Server.

## ⚙️ Persyaratan Sistem

Pastikan PC/Server Anda sudah terinstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Ekstensi PHP Ctype, cURL, DOM, Fileinfo, Filter, Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer, XML.

## 💻 Panduan Instalasi (Local Development)

1. **Clone repositori proyek ini**
   ```bash
   git clone https://github.com/naidrahiqa/sysdrmp.git
   cd sysdrmp
   ```
2. **Install Dependensi PHP via Composer**
   ```bash
   composer install
   ```
3. **Install Dependensi Front-end**
   ```bash
   npm install && npm run build
   ```
4. **Persiapkan Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. **Siapkan Struktur Database (Migration & Seeding)**
   Secara default, aplikasi akan memakai `database.sqlite` di folder `database/`.
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Proses seeding akan menyuntikkan semua modul pelajaran ke database secara otomatis).*

6. **Jalankan Aplikasi Lokal**
   ```bash
   php artisan serve
   ```
   Akses `http://localhost:8000` di web browser Anda.

## 🤝 Kontribusi Koding & Materi
Kami sangat terbuka jika Anda ingin menambahkan materi dokumentasi IT yang baru atau memperbaiki kode Laravel-nya:
- Silakan **Fork** repository ini, lalu buat branch baru (`git checkout -b fitur-baru`).
- Kirimkan **Pull Request** ke branch `main`.
- Lihat juga langkah rinci penulisan di halaman *Kontribusi* pada aplikasi utama.

---
> Dibuat dengan 💻 dan ☕ untuk Komunitas IT Indonesia.
