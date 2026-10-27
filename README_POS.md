# Multi-Tier POS (Laravel 13)

```
[Browser] → multitier_client (port 8001, GUI Blade) → HTTP/JSON + Bearer token → multitier_server (port 8000, REST API) → MySQL "Web_Multi_Tier"
```

## Menjalankan

```bash
# 1. Buat database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS Web_Multi_Tier"

# 2. Server API
cd multitier_server
php artisan config:clear
php artisan migrate --seed
php artisan serve --port=8000

# 3. Client GUI (terminal lain)
cd multitier_client
php artisan config:clear
php artisan serve --port=8001
```

Buka http://localhost:8001

Akun bawaan (dari seeder):

| Role | Email | Password |
|---|---|---|
| admin | admin@pos.test | password |
| operator (kasir) | kasir@pos.test | password |

## Hak akses

| Fitur | admin | operator |
|---|---|---|
| Lihat data barang (Read) | ✔ | ✔ |
| Tambah / Edit / Hapus barang | ✔ | ✘ (403) |
| Jual barang (QTY berkurang) | ✘ (403) | ✔ |
| Register user baru | ✔ | ✘ (403) |

## Endpoint API (`http://127.0.0.1:8000/api`)

| Method | URI | Akses | Body |
|---|---|---|---|
| POST | /register | admin | name, email, password, password_confirmation, role (admin/operator) |
| POST | /login | publik | email, password → `access_token`, `expires_in: 60` |
| GET | /me | token | – |
| POST | /logout | token | – |
| GET | /barang?search= | token | – |
| GET | /barang/{id} | token | – |
| POST | /barang | admin | nama, qty, price |
| PUT | /barang/{id} | admin | nama, qty, price |
| DELETE | /barang/{id} | admin | – |
| PATCH | /barang/{id}/jual | operator | jumlah |

Header: `Authorization: Bearer <access_token>`, `Accept: application/json`

## Token 1 menit

- Diatur di `multitier_server/.env` → `API_TOKEN_TTL=1` (menit), dibaca oleh `config/api.php`.
- Token disimpan sebagai hash SHA-256 di tabel `api_tokens` beserta `expires_at`.
- Middleware `AuthenticateApiToken` menolak token kedaluwarsa dengan **401 `token_expired`**.
- Client menampilkan hitung mundur di navbar; saat habis (atau API membalas 401) sesi dibersihkan dan user diarahkan ke halaman Login.

## File yang ditambahkan / diubah

**multitier_server**: `bootstrap/app.php`, `routes/api.php`, `config/api.php`, `app/Models/{User,ApiToken,Barang}.php`,
`app/Http/Middleware/{AuthenticateApiToken,EnsureRole}.php`, `app/Http/Controllers/Api/{AuthController,BarangController}.php`,
`database/migrations/2026_10_06_00000{1,2,3}_*.php`, `database/seeders/DatabaseSeeder.php`, `.env`

**multitier_client**: `bootstrap/app.php`, `routes/web.php`, `config/pos_api.php`, `app/Services/ApiClient.php`,
`app/Exceptions/{ApiUnauthorizedException,ApiUnavailableException}.php`, `app/Http/Middleware/{EnsureApiToken,EnsureRole}.php`,
`app/Http/Controllers/{AuthController,BarangController}.php`, `resources/views/{layouts,auth,barang}/*.blade.php`, `.env`
(session & cache pakai `file`, jadi client tidak butuh database).

Because nobody can sign up from the login page any more, the first admin has to come from the seeder. That's admin@pos.test, created by php artisan migrate --seed.
