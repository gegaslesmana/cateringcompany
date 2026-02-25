<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Plant;
use App\Models\Order;
use App\Models\Division; // 👈 Import model Division
use App\Models\ActivityLog;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'plant_id',
    'division_id', // 👈 Tambahkan ini agar data registrasi tersimpan
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // -----------------------------
    // ✅ RELASI
    // -----------------------------

    // User terhubung ke satu Divisi/Departemen (PENTING!)
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    // User dimiliki satu Plant
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    // User bisa membuat banyak order
    public function orders()
    {
        return $this->hasMany(Order::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}