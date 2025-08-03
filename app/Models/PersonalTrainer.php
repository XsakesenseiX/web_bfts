<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // <-- Tambahkan ini

class PersonalTrainer extends Model
{
    use HasFactory;

    // Tambahkan 'birth_date' ke fillable
    protected $fillable = ['name', 'birth_date', 'photo', 'specialties', 'contact_info'];

    /**
     * Accessor untuk menghitung umur secara otomatis.
     * Sekarang Anda bisa memanggil $trainer->age
     */
    public function getAgeAttribute(): ?int
    {
        if ($this->birth_date) {
            return Carbon::parse($this->birth_date)->age;
        }
        return null;
    }
}