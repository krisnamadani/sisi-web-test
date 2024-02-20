<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLevel extends Model
{
    use HasFactory;

    protected $table = 'menu_level';
    protected $primaryKey = 'id_level';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
