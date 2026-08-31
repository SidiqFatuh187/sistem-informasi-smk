# 📌 Project Context & Copilot Instructions: Sistem Absensi Sekolah

Document status context and technical specification for GitHub Copilot assistant.

---

## 🚀 Status Progress Project Saat Ini

- [x] **Landing Page** (Selesai)
- [x] **Authentication / Login System** (Selesai)
- [x] **Dashboard Sederhana** (Selesai)
- [x] **Sidebar Dashboard Utama** (Selesai)
- [x] **Role Middleware / Otorisasi Dasar** (Admin, Guru, Kepala Sekolah)
- [x] **CRUD Data Master Siswa** (Selesai)
- [ ] **Data Master CRUD** (Guru, Kelas, Tahun Ajaran)
- [ ] **Form Input Absensi Harian** (Grid View Bulk Input)
- [ ] **Laporan & Rekap Kehadiran** (Agregasi & Persentase)

### Progress Implementasi Saat Ini

- Struktur model dan migration dasar untuk siswa, guru, kelas, tahun ajaran, dan absensi sudah dibuat.
- Middleware `role` sudah terdaftar dan dipersiapkan untuk membatasi akses sesuai hak peran.
- CRUD siswa sudah dibuat, termasuk list, create, edit, update, delete, serta tombol hapus dengan modal konfirmasi.
- Aplikasi sudah dapat boot ulang normal setelah membersihkan cache package discovery yang stale dari `bootstrap/cache/packages.php`.

---

## 🛠️ Tech Stack & Framework

- **Backend / Framework:** Laravel v13 (PHP 8.3+)
- **Architecture:** MVC dengan Laravel Middleware & Authorization Policies
- **Database:** MySQL
- **Frontend / Styling:** Blade Templates + Tailwind CSS via CDN (Tanpa NPM/Vite build step untuk Tailwind)

---

## 👥 Peran Pengguna (User Roles) & Hak Akses

1. **Admin**
    - Kelola Data Master: **Siswa**, **Guru**, **Kelas**, dan **Tahun Ajaran**.
    - Akses penuh ke seluruh fitur dan rekapitulasi data.

2. **Guru / Wali Kelas**
    - **Input Absensi Harian** hanya untuk kelas yang diampu.
    - Mengakses rekapitulasi absensi siswa di kelasnya.
    - _Restriksi:_ Tidak diperbolehkan menginput atau mengedit absensi untuk kelas lain (diatur via Laravel Middleware/Policy).

3. **Kepala Sekolah**
    - **Read-Only Access:** Melihat rekapitulasi absensi semua kelas dan periode (harian, bulanan, semester).
    - _Restriksi:_ Tidak memiliki hak akses untuk mengedit data absensi maupun data master.

---

## 🔄 Alur Pemakaian Sehari-hari (Daily Workflow)

1. **Login & Seleksi:** Guru login ke sistem, memilih **Kelas** dan **Tanggal** absensi.
2. **Fetch Data Siswa:** Sistem menampilkan daftar seluruh siswa yang terdaftar di kelas tersebut.
3. **Penandaan Status:** Guru menandai status tiap siswa secara sekaligus (_grid/table view_):
    - Status yang tersedia: `Hadir`, `Sakit`, `Izin`, `Alpa`.
4. **Penyimpanan & Rekap Real-time:** Data tersimpan ke database MySQL. Wali Kelas, Admin, dan Kepala Sekolah dapat langsung melihat rekap kapan saja (per siswa, per kelas, atau per bulan).

---

## 🎯 Fitur Inti & Kompleksitas Fitur

| Fitur                         | Deskripsi Technical                                                                                               | Kompleksitas |   Status   |
| :---------------------------- | :---------------------------------------------------------------------------------------------------------------- | :----------: | :--------: |
| **CRUD Siswa, Kelas, Guru**   | Form + tabel standar CRUD master data                                                                             |    Mudah     | ⏳ Pending |
| **Form Input Absensi Harian** | Tampilan grid dengan pilihan status per baris untuk semua siswa sekaligus (batch submission)                      |    Sedang    | ⏳ Pending |
| **Laporan Rekap Kehadiran**   | Rekap persentase kehadiran per siswa/kelas menggunakan query agregasi MySQL (`COUNT`, `GROUP BY`)                 |    Sedang    | ⏳ Pending |
| **Role & Permission**         | Proteksi akses kelas & fitur menggunakan Middleware / Policy Laravel v13 (Guru hanya bisa input kelasnya sendiri) |    Sedang    | ⏳ Pending |

---

## 🗄️ Skema Database MySQL (Database Design Overview)

### 1. `users`

- `id`, `name`, `email`, `password`, `role` (`admin`, `guru`, `kepala_sekolah`)

### 2. `teachers` (Guru)

- `id`, `user_id` (FK to users), `nip`, `nama`, `no_hp`

### 3. `classes` (Kelas)

- `id`, `nama_kelas`, `teacher_id` (FK to teachers - Wali Kelas / Pengampu)

### 4. `students` (Siswa)

- `id`, `nisn`, `nama`, `class_id` (FK to classes), `jenis_kelamin`

### 5. `academic_years` (Tahun Ajaran)

- `id`, `tahun`, `semester` (`Ganjil` / `Genap`), `is_active`

### 6. `attendances` (Absensi)

- `id`, `student_id` (FK), `class_id` (FK), `teacher_id` (FK), `date`, `status` (`hadir`, `sakit`, `izin`, `alpa`), `notes`

---

## 🤖 Directives & Guidelines for GitHub Copilot

Saat membantu mengembangkan atau refactoring kode pada project ini, mohon ikuti panduan berikut:

1. **Laravel v13 Standard:** Gunakan konvensi struktur dan kodingan terkini dari Laravel v13 (PSR-12, FormRequest, Policy, Resource Controller).
2. **Tailwind CSS via CDN:** Tulis class utilitas Tailwind langsung di file Blade. **Jangan** menyarankan instalasi/konfigurasi `tailwind.config.js` atau proses compile `npm run dev` / Vite untuk CSS.
3. **Database & Query MySQL:** Optimalkan query Eloquent / Query Builder untuk MySQL (gunakan `selectRaw`, `COUNT()`, `GROUP BY`, dan `upsert()` / `updateOrCreate()` saat _batch submission_ agar menghindari issue N+1 query).
4. **Keamanan & Otorisasi:** Pastikan route/action absensi diproteksi dengan `Policy` / `Middleware` agar Guru tidak bisa melakukan manipulasi data kelas lain.
