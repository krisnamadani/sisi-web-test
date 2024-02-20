<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'no_activity';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
