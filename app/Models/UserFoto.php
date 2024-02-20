<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFoto extends Model
{
    use HasFactory;

    protected $table = 'user_foto';
    protected $primaryKey = 'no_foto';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
