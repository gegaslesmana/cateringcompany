<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ❌ Tambahkan ini
use App\Models\Division;
use App\Models\Plant;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

  protected $fillable = [
    'created_by',
    'user_id',    // 👈 Pastikan ini ada di sini
    'division_id',
    'plant_id',
    'shift_time',
    'order_date',
    'qty',
    'name',
    'remark',
    'status'
];
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function plant()
{
    // Ini menghubungkan plant_id di tabel orders ke id di tabel plants
    return $this->belongsTo(Plant::class, 'plant_id');
}

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}