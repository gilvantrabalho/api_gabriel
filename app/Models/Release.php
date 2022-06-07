<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    public $table = "oliveira_gabriel.user_releases";
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'user_id', 'transaction_id', 'operation_type', 'created_at'
    ];
}
