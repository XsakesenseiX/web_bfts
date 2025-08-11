# Perbaikan Error "Missing parameter: filename"

## Masalah
Error: `Missing required parameter for [Route: admin.transaction-proofs.show] [URI: admin/transaction-proofs/{filename}] [Missing parameter: filename].`

Terjadi pada menu "Bukti Transaksi" dan "Verifikasi Pembayaran" ketika:
1. Field `payment_proof` dalam tabel `memberships` bernilai NULL atau kosong
2. Field `proof_path` dalam tabel `transaction_proofs` bernilai NULL atau kosong
3. Function `basename()` dipanggil pada nilai NULL

## Analisis Root Cause
Pada kode Filament Resources, terdapat fungsi yang memanggil:
```php
// SEBELUM (BERMASALAH):
->url(fn (Membership $record): string => route('admin.transaction-proofs.show', ['filename' => basename($record->payment_proof)]))
```

Masalah terjadi ketika `$record->payment_proof` bernilai NULL, maka:
- `basename(NULL)` menghasilkan string kosong atau error
- Route `admin.transaction-proofs.show` memerlukan parameter `filename` yang valid
- Laravel throw error "Missing parameter: filename"

## Perbaikan yang Dilakukan

### 1. MembershipResource.php
**File**: `app/Filament/Resources/MembershipResource.php`

**SEBELUM** (Baris 38-42):
```php
Tables\Columns\TextColumn::make('payment_proof')
    ->label('Bukti Bayar')
    ->formatStateUsing(fn () => 'Lihat Bukti')
    ->url(fn (Membership $record): string => route('admin.transaction-proofs.show', ['filename' => basename($record->payment_proof)]))
    ->openUrlInNewTab(),
```

**SESUDAH**:
```php
Tables\Columns\TextColumn::make('payment_proof')
    ->label('Bukti Bayar')
    ->formatStateUsing(fn ($state) => $state ? 'Lihat Bukti' : 'Tidak Ada')
    ->url(fn (Membership $record): ?string => $record->payment_proof 
        ? route('admin.transaction-proofs.show', ['filename' => basename($record->payment_proof)]) 
        : null
    )
    ->color(fn ($state) => $state ? 'primary' : 'gray')
    ->openUrlInNewTab(),
```

### 2. TransactionProofResource.php  
**File**: `app/Filament/Resources/TransactionProofResource.php`

**A. ImageColumn (Baris 83-88):**
```php
// SEBELUM:
Tables\Columns\ImageColumn::make('proof_path')
    ->label('Preview Bukti')
    ->square()
    ->size(60)
    ->url(fn (TransactionProof $record): string => route('admin.transaction-proofs.show', ['filename' => basename($record->proof_path)]))
    ->openUrlInNewTab(),

// SESUDAH:
Tables\Columns\ImageColumn::make('proof_path')
    ->label('Preview Bukti')
    ->square()
    ->size(60)
    ->url(fn (TransactionProof $record): ?string => $record->proof_path 
        ? route('admin.transaction-proofs.show', ['filename' => basename($record->proof_path)]) 
        : null
    )
    ->openUrlInNewTab(),
```

**B. Action view_proof (Baris 213-219):**
```php
// SEBELUM:
Tables\Actions\Action::make('view_proof')
    ->label('Lihat Bukti')
    ->icon('heroicon-o-eye')
    ->color('info')
    ->url(fn (TransactionProof $record): string => route('admin.transaction-proofs.show', ['filename' => basename($record->proof_path)]))
    ->openUrlInNewTab(),

// SESUDAH:
Tables\Actions\Action::make('view_proof')
    ->label('Lihat Bukti')
    ->icon('heroicon-o-eye')
    ->color('info')
    ->url(fn (TransactionProof $record): ?string => $record->proof_path 
        ? route('admin.transaction-proofs.show', ['filename' => basename($record->proof_path)]) 
        : null
    )
    ->visible(fn (TransactionProof $record): bool => !empty($record->proof_path))
    ->openUrlInNewTab(),
```

## Logika Perbaikan

### 1. Null Safety Check
```php
// Cek apakah field proof path tidak null/kosong
$record->payment_proof ? /* generate URL */ : null
```

### 2. Conditional URL Generation
```php
// Return type nullable string (?string) instead of string
fn (Model $record): ?string => ...
```

### 3. UI Improvements
```php
// Display berbeda untuk data yang ada vs tidak ada
->formatStateUsing(fn ($state) => $state ? 'Lihat Bukti' : 'Tidak Ada')
->color(fn ($state) => $state ? 'primary' : 'gray')
```

### 4. Action Visibility
```php
// Hide action jika tidak ada file
->visible(fn (TransactionProof $record): bool => !empty($record->proof_path))
```

## Benefits dari Perbaikan

### ✅ Error Prevention
- Tidak ada lagi error "Missing parameter: filename"
- Aplikasi tetap stabil meskipun ada data NULL

### ✅ Better User Experience
- Text "Tidak Ada" untuk membership tanpa bukti bayar
- Gray color untuk indicate data kosong
- Action "Lihat Bukti" hanya muncul jika ada file

### ✅ Data Integrity
- Aplikasi dapat handle data lama yang mungkin proof_path-nya NULL
- Graceful degradation untuk data incomplete

## Test Scenarios

### ✅ Membership dengan payment_proof NULL
- Display: "Tidak Ada" (gray)
- URL: tidak ada link
- Behavior: tidak error

### ✅ Membership dengan payment_proof valid
- Display: "Lihat Bukti" (primary color)  
- URL: route ke file viewer
- Behavior: open file di tab baru

### ✅ TransactionProof dengan proof_path NULL
- ImageColumn: tidak ada URL
- Action: hidden (tidak muncul)
- Behavior: tidak error

### ✅ TransactionProof dengan proof_path valid
- ImageColumn: ada URL ke file
- Action: visible dan clickable
- Behavior: open file di tab baru

## File yang Dimodifikasi
1. `app/Filament/Resources/MembershipResource.php`
2. `app/Filament/Resources/TransactionProofResource.php`

## Testing
- [x] Syntax check passed
- [x] Cache cleared
- [x] Routes verified
- [x] Null handling tested

## Status
✅ **BERHASIL DIPERBAIKI**

Error "Missing parameter: filename" telah teratasi. Aplikasi sekarang dapat:
1. Handle data NULL dengan graceful
2. Display UI yang appropriate untuk data kosong
3. Mencegah error routing pada data incomplete
4. Memberikan user experience yang lebih baik
