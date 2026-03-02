<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menganggap nama tabelnya 'media'.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filename',
        'file_encrypt',
        'alternative_text',
        'file_type',
        'file_size',
    ];

    /**
     * Casting tipe data kolom.
     * Ini memastikan file_size selalu diperlakukan sebagai integer.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];



    // Tambahkan ini di dalam class Media
    public function getUrlAttribute()
    {
        return asset('storage/uploads/' . $this->fileencrypt);
    }
}