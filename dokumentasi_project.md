# Dokumentasi Project Magang (Sistem Manajemen Proposal)

Project ini merupakan aplikasi berbasis web yang dibangun menggunakan framework **Laravel**. Aplikasi ini berfungsi sebagai sistem manajemen pengajuan proposal (submission system) dengan tiga peran (role) utama, yaitu:
1. **Proposer**: Pengguna yang mengajukan proposal.
2. **Reviewer**: Pengguna yang meninjau, memberikan masukan (feedback), dan mengubah status proposal.
3. **Admin**: Pengguna yang memonitor seluruh proposal dan menugaskan reviewer pada proposal tertentu.

Berikut adalah penjabaran detail logika program berdasarkan folder dan file utamanya.

---

## 1. Direktori `app/Models/`

Folder ini berisi model-model Eloquent (ORM) yang merepresentasikan struktur tabel dalam database dan relasi antar tabel.

### `User.php`
Model ini mewakili tabel `users`. Selain autentikasi bawaan Laravel, tabel ini memiliki kolom `role` (`admin`, `reviewer`, `proposer`) untuk membedakan hak akses.
Model ini juga mendefinisikan relasi:
- Seorang User (Proposer) bisa memiliki banyak proposal (`hasMany(Proposal::class, 'proposer_id')`).

### `Proposal.php`
Model utama yang menyimpan informasi tentang proposal.
- Kolom penting: `title`, `abstract`, `category`, `file_path` (lokasi file PDF), `status` (pending_review, in_review, revision_required, revision_submitted, approved, rejected), `proposer_id`, dan `reviewer_id`.
- Relasi: Memiliki banyak `ProposalComment` dan `ProposalLog`. Terhubung dengan `User` sebagai proposer dan reviewer.

```php
// Potongan kode dari Proposal.php
public function proposer() {
    return $this->belongsTo(User::class, 'proposer_id');
}
public function comments() {
    return $this->hasMany(ProposalComment::class);
}
```

### `ProposalComment.php` & `ProposalLog.php`
- **ProposalComment**: Menyimpan feedback atau komentar dari Reviewer ke Proposal. Terhubung dengan `User` dan `Proposal`.
- **ProposalLog**: Menyimpan riwayat perubahan status (audit log/timeline) dari proposal.

---

## 2. Direktori `app/Http/Controllers/`

Folder ini menampung *controller* yang mengendalikan alur logika dari input pengguna (request) hingga mengembalikan tampilan (response). Dipecah berdasarkan hak akses (Role).

### `ProposalController.php` (Logika Proposer)
Menangani seluruh aksi yang dilakukan oleh pengguna ber-role `proposer`.
- `store()`: Mengunggah file PDF dan menyimpan data proposal baru ke database dengan status awal `pending_review`.
- `updateFile()`: Menangani proses ketika proposal perlu direvisi (`revision_required` atau `rejected`). Method ini akan menerima file PDF baru, menghapus file lama dari _storage_, dan mengubah status proposal menjadi `revision_submitted`.

```php
// Potongan kode updateFile di ProposalController.php
$filePath = $request->file('pdf_file')->store('proposals', 'local');
// Delete old file if exists
if ($proposal->file_path && Storage::disk('local')->exists($proposal->file_path)) {
    Storage::disk('local')->delete($proposal->file_path);
}
$proposal->update(['file_path' => $filePath, 'status' => 'revision_submitted']);
```

### `AdminController.php` (Logika Admin)
Menangani fitur khusus Administrator.
- `index()`: Menampilkan semua proposal yang ada dalam sistem beserta detail proposer dan reviewernya.
- `assignReviewer()`: Admin dapat memilih akun `reviewer` dan menugaskannya (`assign`) ke proposal tertentu. Status bisa dilacak dari riwayat `logs`.

### `ReviewController.php` (Logika Reviewer)
Menangani alur penilaian proposal.
- `storeReview()`: Reviewer dapat mengunggah masukan tertulis yang disimpan ke tabel `proposal_comments` dan memperbarui status proposal menjadi disetujui, ditolak, atau perlu direvisi.

---

## 3. Direktori `routes/`

### `web.php`
Pusat pengatur rute/URL aplikasi. Rute dibungkus (dikelompokkan) menggunakan `middleware` berdasarkan role masing-masing, sehingga Proposer tidak dapat mengakses URL Admin, begitu pula sebaliknya.

```php
// Potongan kode web.php
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/proposal/{proposal}/assign', [AdminController::class, 'assignReviewer'])->name('proposal.assign');
});
```

### `auth.php`
Menangani rute autentikasi standar bawaan Laravel Breeze seperti Login, Register, dan Forgot Password. Tampilannya telah dimodifikasi agar lebih premium dengan menambahkan komponen _card_ dan tombol _back_.

---

## 4. Direktori `resources/views/`

Berisi komponen UI yang dibangun menggunakan sistem templating Blade dan *utility classes* Tailwind CSS.

### `auth/`
Berisi `login.blade.php` dan `register.blade.php`. Antarmuka (UI) telah diperbarui untuk terlihat lebih modern dengan mengelompokkan `input fields` ke dalam sebuah kotak kontainer berwarna abu-abu, judul halaman, dan tata letak responsif.
- Menggunakan ekstensi layout `guest.blade.php` yang memuat tombol "Back to Home".

### `proposer/`, `reviewer/`, `admin/`
Memisahkan halaman (dashboard, form, detail proposal) agar kode tidak tercampur.
- **`proposer/show.blade.php`**: Diperbarui dengan fitur kotak komentar _scrollable_ (untuk reviewer feedback), serta otomatis menampilkan form _Upload Revision_ apabila status proposal dalam keadaan ditolak (`rejected`) atau harus direvisi (`revision_required`).

```html
<!-- Potongan blok kode dari proposer/show.blade.php -->
@if(in_array($proposal->status, ['revision_required', 'rejected']))
<div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
    <h4 class="text-lg font-bold">Upload Revision</h4>
    <form action="{{ route('proposer.proposal.updateFile', $proposal) }}" method="POST" enctype="multipart/form-data">
        <!-- Input File -->
    </form>
</div>
@endif
```

---

## Ringkasan Alur Sistem

1. **Pendaftaran/Autentikasi**: Pengguna mendaftar di sistem.
2. **Proposer Mengajukan Proposal**: Proposer mengisi formulir judul, abstrak, dan mengunggah file PDF.
3. **Admin Menugaskan Reviewer**: Admin memantau pengajuan masuk dan memilih reviewer untuk proposal tersebut.
4. **Penilaian oleh Reviewer**: Reviewer membaca dokumen (bisa mengunduh PDF), memberikan komentar di kolom feedback, dan mengganti status (misalnya menjadi _Revision Required_).
5. **Revisi Proposal**: Proposer melihat status berubah, membaca catatan dari reviewer, dan mengunggah file revisi terbaru. Status proposal berubah menjadi _Revision Submitted_.
6. Proses ini berputar hingga proposal berstatus _Approved_ (disetujui).
