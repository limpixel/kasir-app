# 📊 Dokumentasi Aplikasi Kasir (Point of Sales)

## 📋 Daftar Isi
1. [Struktur Project](#struktur-project)
2. [Tech Stack](#tech-stack)
3. [Fitur Utama](#fitur-utama)
4. [Alur Kerja Sistem](#alur-kerja-sistem)
5. [Penjelasan Per Fitur](#penjelasan-per-fitur)

---

## 🏗️ Struktur Project

```
kasir-app/
├── app/                          # Logika aplikasi
│   ├── Http/
│   │   ├── Controllers/          # Mengatur permintaan HTTP
│   │   │   ├── Apps/            # Controller fitur utama
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── CustomerController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── TransactionController.php
│   │   │   │   └── SaleController.php
│   │   │   ├── UserController.php
│   │   │   ├── RoleController.php
│   │   │   ├── PermissionController.php
│   │   │   ├── ProfileController.php
│   │   │   └── FECheckoutController.php
│   │   ├── Middleware/           # Middleware untuk autentikasi & validasi
│   │   └── Requests/             # Form request validation
│   ├── Models/                   # Model basis data
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Customer.php
│   │   ├── Transaction.php
│   │   ├── TransactionDetail.php
│   │   ├── Cart.php
│   │   └── Profit.php
│   └── Providers/                # Service providers
│
├── database/                     # Database management
│   ├── migrations/              # Migrasi database
│   ├── seeders/                 # Data seeding
│   └── factories/               # Factory untuk testing
│
├── resources/                   # Frontend resources
│   ├── views/                   # View (Inertia React)
│   ├── js/                      # JavaScript/React components
│   └── css/                     # Stylesheet
│
├── routes/                      # Konfigurasi rute
│   ├── web.php                 # Web routes
│   ├── auth.php                # Auth routes
│   └── console.php             # Console routes
│
├── public/                      # Public assets
│   ├── storage/                # File uploads
│   ├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── storage/                     # Cache & logs
│   ├── app/                    # File storage
│   ├── framework/              # Cache files
│   └── logs/                   # Application logs
│
├── config/                      # Konfigurasi aplikasi
├── bootstrap/                   # Bootstrap aplikasi
├── docker/                      # Docker configuration
├── tests/                       # Unit & Feature tests
├── vendor/                      # Dependencies
│
├── docker-compose.yml          # Docker Compose config
├── Dockerfile                   # Docker image config
├── vite.config.js              # Vite bundler config
├── tailwind.config.js          # TailwindCSS config
├── package.json                # Node.js dependencies
└── composer.json               # PHP dependencies
```

---

## 🛠️ Tech Stack

### Backend
- **Laravel 11.x** - Framework PHP modern
- **Inertia.js** - Menghubungkan Laravel & React tanpa API
- **MySQL 8.0** - Database relasional
- **Redis** - Caching & session management
- **Spatie Laravel Permission** - Role & Permission management

### Frontend
- **React 18.2** - Library UI
- **TailwindCSS 3.2** - Utility-first CSS framework
- **Axios** - HTTP client
- **Headless UI** - Unstyled UI components
- **React Hot Toast** - Notification system
- **SweetAlert2** - Dialog notifications
- **JSBarcode** - Barcode generator
- **Dexie.js** - IndexedDB library untuk offline

### DevTools
- **Vite 5.0** - Build tool
- **PostCSS** - CSS processing
- **Autoprefixer** - CSS vendor prefixes

### Infrastructure
- **Docker & Docker Compose** - Containerization
- **Nginx** - Web server
- **PHP 8.2** - Runtime environment

---

## ⭐ Fitur Utama

### 1. **Manajemen Produk**
- CRUD produk dengan kategori
- Upload gambar produk
- Barcode generator
- Tracking harga beli & jual
- Manajemen stok

### 2. **Transaksi/Penjualan**
- Checkout dengan cart system
- Pencarian produk real-time
- Multiple payment methods
- Diskon per transaksi
- Generate invoice & print receipt
- Perhitungan keuntungan otomatis

### 3. **Manajemen Pelanggan**
- CRUD customer data
- Tracking riwayat pembelian
- Customer information management

### 4. **Manajemen Kategori**
- CRUD kategori produk
- Organisasi produk berdasarkan kategori

### 5. **User & Authentication**
- Registrasi & login
- Email verification
- Password reset
- Profile management
- Avatar upload

### 6. **Role & Permission Management**
- Multi-role system (Admin, Cashier, dll)
- Fine-grained permissions
- Dynamic role assignment

### 7. **Laporan & Analytics**
- Transaction history
- Profit tracking
- Dashboard overview

---

## 🔄 Alur Kerja Sistem

### Alur Autentikasi
```
User → Login → Middleware Auth Check → Dashboard/Admin Panel
```

### Alur Transaksi Penjualan
```
1. User masuk halaman transaksi
2. Cari & pilih produk (SearchProduct)
3. Produk ditambah ke cart (AddToCart)
4. Kelola cart (Edit qty, Remove item)
5. Input data pelanggan & diskon
6. Submit transaksi (Store)
7. Generate invoice & print
8. Update stok & hitung keuntungan (Profit)
```

### Alur Manajemen Data Master
```
Admin → CRUD Operations (Create, Read, Update, Delete) → Database
        ↓
      Validasi Input
      ↓
      Simpan/Update/Hapus
      ↓
      Response ke Frontend
```

---

## 📱 Penjelasan Per Fitur

### 🛍️ 1. FITUR PRODUK (Product Management)

#### Database Schema
```
products table:
- id (Primary Key)
- image (URL gambar produk)
- barcode (Unique identifier)
- title (Nama produk)
- description (Deskripsi)
- buy_price (Harga beli)
- sell_price (Harga jual)
- category_id (Foreign Key ke categories)
- stock (Jumlah stok tersedia)
- created_at, updated_at
```

#### Relasi Model
```php
Product → Category (Many-to-One)
Product → TransactionDetail (One-to-Many)
```

#### Routes
```
GET    /dashboard/products           # List semua produk
GET    /dashboard/products/create    # Form tambah produk
POST   /dashboard/products           # Simpan produk baru
GET    /dashboard/products/{id}/edit # Form edit produk
PUT    /dashboard/products/{id}      # Update produk
DELETE /dashboard/products/{id}      # Hapus produk
```

#### Workflow
1. **Create Produk**
   - Admin input data (nama, harga, stok, kategori)
   - Upload gambar produk
   - Generate barcode otomatis
   - Simpan ke database

2. **Read Produk**
   - Tampilkan list produk dengan pagination
   - Filter berdasarkan kategori
   - Pencarian produk

3. **Update Produk**
   - Edit data produk
   - Update gambar
   - Adjust harga & stok

4. **Delete Produk**
   - Hapus produk dari database
   - Automatic cascade jika ada relasi

---

### 📂 2. FITUR KATEGORI (Category Management)

#### Database Schema
```
categories table:
- id (Primary Key)
- name (Nama kategori)
- description (Deskripsi)
- created_at, updated_at
```

#### Relasi Model
```php
Category → Product (One-to-Many)
```

#### Routes
```
GET    /dashboard/categories         # List kategori
GET    /dashboard/categories/create  # Form tambah
POST   /dashboard/categories         # Simpan
GET    /dashboard/categories/{id}/edit # Form edit
PUT    /dashboard/categories/{id}    # Update
DELETE /dashboard/categories/{id}    # Hapus
```

#### Workflow
- Simple CRUD untuk manage kategori produk
- Setiap kategori dapat memiliki banyak produk
- Soft delete support (optional)

---

### 👥 3. FITUR PELANGGAN (Customer Management)

#### Database Schema
```
customers table:
- id (Primary Key)
- name (Nama pelanggan)
- phone (No. telepon)
- email (Email)
- address (Alamat)
- created_at, updated_at
```

#### Relasi Model
```php
Customer → Transaction (One-to-Many)
```

#### Routes
```
GET    /dashboard/customers          # List pelanggan
GET    /dashboard/customers/create   # Form tambah
POST   /dashboard/customers          # Simpan
GET    /dashboard/customers/{id}/edit # Form edit
PUT    /dashboard/customers/{id}     # Update
DELETE /dashboard/customers/{id}     # Hapus
```

#### Workflow
- CRUD customer data
- Track semua transaksi customer
- Search & filter customer

---

### 🧾 4. FITUR TRANSAKSI (Transaction/Point of Sales)

#### Database Schema
```
transactions table:
- id (Primary Key)
- cashier_id (Foreign Key ke users - siapa yang kasir)
- customer_id (Foreign Key ke customers)
- invoice (Nomor invoice unik)
- cash (Jumlah uang yang diterima)
- change (Kembalian)
- discount (Diskon total)
- grand_total (Total harga akhir)
- created_at, updated_at

transaction_details table:
- id (Primary Key)
- transaction_id (Foreign Key ke transactions)
- product_id (Foreign Key ke products)
- quantity (Jumlah item)
- price (Harga per item saat transaksi)
- subtotal (quantity × price)
- created_at, updated_at

carts table:
- id (Primary Key)
- session_id (Session user)
- product_id (Foreign Key ke products)
- quantity (Jumlah)
- created_at, updated_at
```

#### Relasi Model
```php
Transaction → TransactionDetail (One-to-Many)
Transaction → Customer (Many-to-One)
Transaction → User/Cashier (Many-to-One)
Transaction → Profit (One-to-Many)
```

#### Routes
```
GET    /dashboard/transactions               # List transaksi
POST   /dashboard/transactions/searchProduct # Cari produk
POST   /dashboard/transactions/addToCart     # Tambah ke cart
DELETE /dashboard/transactions/{cart_id}/destroyCart # Hapus dari cart
POST   /dashboard/transactions/store         # Submit transaksi
GET    /dashboard/transactions/{invoice}/print # Print invoice
```

#### Step-by-Step Workflow

##### Step 1: Halaman Transaksi
```
- Tampilkan daftar produk
- Tampilkan cart saat ini
- Form input diskon & customer
```

##### Step 2: Search Product
```
POST /transactions/searchProduct
Input: {query: "nama produk"}
- Backend cari produk berdasarkan nama/barcode
- Return daftar produk yang cocok
- Frontend tampilkan hasil search
```

##### Step 3: Add to Cart
```
POST /transactions/addToCart
Input: {product_id, quantity}
- Validasi stok produk (cek apakah stok cukup)
- Cek apakah produk sudah di cart (update qty atau insert baru)
- Simpan/update ke tabel carts
- Return cart terbaru
```

##### Step 4: Manage Cart
```
- Lihat semua item di cart
- Edit quantity per item
- Hapus item dari cart dengan DELETE /transactions/{cart_id}/destroyCart
- Hitung subtotal & grand total real-time
```

##### Step 5: Input Checkout Data
```
- Pilih atau input customer baru
- Input diskon (Rp atau %)
- Input jumlah uang yang diterima (cash)
- Hitung kembalian otomatis
```

##### Step 6: Submit Transaksi
```
POST /transactions/store
Input: {customer_id, discount, cash, cart_items}

Backend Process:
1. Validasi semua data
2. Hitung total harga dari semua cart items
3. Hitung grand total setelah diskon
4. Generate unique invoice number
5. Create transaction record
6. Loop setiap item di cart:
   - Create transaction_detail
   - Update stok produk (kurangi)
   - Calculate profit per item
   - Create profit record
7. Clear cart setelah selesai
8. Return transaction data
```

##### Step 7: Print Invoice
```
GET /transactions/{invoice}/print
- Query transaction berdasarkan invoice number
- Include transaction_details & customer info
- Include calculated profit
- Generate HTML untuk print
- Display receipt format
```

---

### 💰 5. FITUR PROFIT TRACKING

#### Database Schema
```
profits table:
- id (Primary Key)
- transaction_id (Foreign Key)
- product_id (Foreign Key)
- profit_amount (Harga jual - Harga beli)
- quantity (Jumlah terjual)
- total_profit (profit_amount × quantity)
- created_at, updated_at
```

#### Workflow
- Setiap kali transaksi selesai, otomatis hitung keuntungan
- Profit = (sell_price - buy_price) × quantity
- Track profit per produk dan per transaksi
- Laporan profit history

---

### 👤 6. FITUR USER & AUTHENTICATION

#### Database Schema
```
users table:
- id (Primary Key)
- name (Nama user)
- email (Email unik)
- password (Password terenkripsi)
- avatar (URL avatar)
- email_verified_at (Timestamp verifikasi)
- remember_token (Token remember me)
- created_at, updated_at
```

#### Routes
```
GET/POST   /register              # Registrasi user
GET/POST   /login                 # Login
POST       /logout                # Logout
GET/PATCH  /profile               # Edit profile
DELETE     /profile               # Delete account
```

#### Workflow
1. **Registrasi**
   - Input email & password
   - Validasi email belum terdaftar
   - Encrypt password
   - Send email verification
   - Create user record

2. **Login**
   - Input email & password
   - Validasi credentials
   - Check email verified
   - Create session/token
   - Redirect ke dashboard

3. **Profile Management**
   - View profile info
   - Update nama, email, avatar
   - Change password
   - Delete account

---

### 🔐 7. FITUR ROLE & PERMISSION

#### Database Schema
```
roles table:
- id, name, guard_name, created_at, updated_at

permissions table:
- id, name, guard_name, created_at, updated_at

model_has_roles table:
- role_id, model_id, model_type

role_has_permissions table:
- permission_id, role_id
```

#### Routes
```
GET    /dashboard/roles             # List roles
POST   /dashboard/roles             # Create role
PUT    /dashboard/roles/{id}        # Update role
DELETE /dashboard/roles/{id}        # Delete role

GET    /dashboard/permissions       # List permissions
```

#### Workflow
1. **Create Role**
   - Input nama role (Admin, Cashier, Manager)
   - Assign permissions ke role
   - Simpan role

2. **Assign Role to User**
   - Di user management, pilih role
   - User inherit semua permission dari role
   - Update middleware untuk check permissions

3. **Permission Check**
   - Middleware validate user memiliki permission
   - Return 403 jika tidak authorized
   - Log unauthorized access attempts

---

### 🛒 8. FITUR CART (Frontend Checkout)

#### Routes
```
GET    /cart                  # Tampilkan cart
POST   /cart/add              # Add item to cart
DELETE /cart/{id}             # Remove item dari cart
DELETE /cart                  # Clear semua cart
```

#### Database (Dexie.js - Client-side)
```
Menggunakan IndexedDB untuk offline cart persistence
- Store cart items locally
- Sync ke server saat checkout
```

#### Workflow
- Customer browse produk di frontend public
- Add items to cart (local storage)
- Checkout process
- Redirect ke transaksi atau payment gateway

---

## 📊 Alur Data Flow Per Fitur

### Alur Transaksi Lengkap

```
┌─────────────────┐
│ Kasir Dashboard │
│  Halaman Trx   │
└────────┬────────┘
         │
         ├─→ [Search Product] ──→ Backend search ──→ Return hasil
         │
         ├─→ [Add to Cart] ──→ Validate stok ──→ Save to carts table
         │
         ├─→ [View Cart Items] ──→ Calculate totals ──→ Display
         │
         ├─→ [Submit Checkout]
         │     │
         │     ├─→ Validate data
         │     ├─→ Create transaction record
         │     ├─→ Create transaction_details (per item)
         │     ├─→ Update stok produk
         │     ├─→ Calculate & save profit
         │     ├─→ Clear cart
         │     └─→ Return success
         │
         └─→ [Print Invoice] ──→ Generate HTML ──→ Browser print dialog
```

### Alur CRUD Produk

```
┌──────────────────┐
│ Admin Dashboard  │
│ Product Manager  │
└────────┬─────────┘
         │
         ├─→ [List Products]
         │     └─→ Query products + category + paginate ──→ Display table
         │
         ├─→ [Create Product]
         │     ├─→ Show form
         │     ├─→ Upload image ──→ Save ke /storage/products
         │     ├─→ Generate barcode
         │     ├─→ POST /products ──→ Validate & Save
         │     └─→ Success message
         │
         ├─→ [Update Product]
         │     ├─→ Load product data
         │     ├─→ Update form fields
         │     ├─→ PUT /products/{id} ──→ Validate & Update
         │     └─→ Success message
         │
         └─→ [Delete Product]
               ├─→ Confirm dialog
               ├─→ DELETE /products/{id}
               └─→ Remove from list
```

---

## 🔑 Key Concepts

### 1. **Middleware Authorization**
```php
// Protect dashboard routes
Route::group(['middleware' => ['auth']], function () {
    // Only authenticated users can access
});

// Role-based access
@can('view transactions')
    // Display transaction link
@endcan
```

### 2. **Validation**
```php
// Input validation di request class
$validated = $request->validated();

// Business logic validation di controller
if ($product->stock < $quantity) {
    return response()->json(['error' => 'Stok tidak cukup'], 422);
}
```

### 3. **Relationship Loading**
```php
// Eager load untuk optimize query
$transactions = Transaction::with(['customer', 'details.product'])->get();
```

### 4. **Attribute Casting**
```php
// Auto format data saat retrieve
protected $casts = [
    'email_verified_at' => 'datetime',
];
```

---

## 🚀 Cara Menjalankan Aplikasi

### Dengan Docker (Recommended)
```bash
# 1. Setup awal
./docker-setup.sh

# 2. Jalankan services
docker-compose up -d

# 3. Access aplikasi
# - Frontend: http://localhost:8000
# - MySQL: localhost:3306
# - Redis: localhost:6379
```

### Tanpa Docker
```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Konfigurasi database di .env

# 4. Migrate & seed
php artisan migrate --seed

# 5. Link storage
php artisan storage:link

# 6. Run development server
php artisan serve
npm run dev
```

---

## 📝 File Penting

| File | Fungsi |
|------|--------|
| `routes/web.php` | Mendefinisikan semua routes |
| `app/Models/*` | Model & relasi database |
| `app/Http/Controllers/*` | Business logic & request handling |
| `database/migrations/*` | Schema database |
| `resources/js/*` | React components |
| `config/auth.php` | Authentication config |
| `config/permission.php` | Role & permission config |

---

## ✅ Kesimpulan

Aplikasi Kasir ini adalah sistem Point of Sales modern yang menggabungkan:
- **Backend robust** dengan Laravel 11
- **Frontend modern** dengan React & TailwindCSS
- **Database terstruktur** dengan relasi antar entitas
- **Security layer** dengan authentication & authorization
- **User experience** dengan real-time validation & feedback

Setiap fitur dirancang untuk mendukung operasional toko dengan efisien, dari inventory management hingga financial tracking.

---

**Last Updated:** January 2026
**Version:** 2.0
