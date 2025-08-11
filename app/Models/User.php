<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'address',
        'status',
        'student_id_card_path',
        'is_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'member') {
            return $this->role === 'member';
        }

        return false;
    }
    
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function activeMembership()
    {
        return $this->hasOne(Membership::class)->where('status', 'active')->whereDate('end_date', '>=', now());
    }

    public function getStudentIdCardUrlAttribute()
    {
        if ($this->student_id_card_path) {
            return asset('storage/' . $this->student_id_card_path);
        }

        return null;
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }

    /**
     * Get the transaction proofs for the user.
     */
    public function transactionProofs()
    {
        return $this->hasMany(TransactionProof::class);
    }
}