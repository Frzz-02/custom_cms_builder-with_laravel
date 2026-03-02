<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang didefinisikan secara eksplisit.
     * * @var string
     */
    protected $table = 'newsletters';

    /**
     * Atribut yang dapat diisi melalui mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'status',
    ];

    /**
     * Default nilai untuk atribut tertentu.
     * Sesuai dengan database yang memberikan default 'Subscribed'.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'Subscribed',
    ];
}