<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Masukkan semua nama kolom database kamu di sini
    protected $fillable = [
    'full_name', 
    'address', 
    'customer_id_string', 
    'package', 
    'installation_date', 
    'expiry_date',
    'status', 
    'phone',
    'notes',
    'keterangan'
];

    protected $casts = [
        'installation_date' => 'date:Y-m-d',
        'expiry_date' => 'date:Y-m-d',
    ];
}