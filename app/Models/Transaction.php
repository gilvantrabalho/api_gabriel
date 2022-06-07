<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $table = "oliveira_gabriel.transactions";
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'description', 'value', 'status',
        'updated_at', 'created_at'
    ];
}
