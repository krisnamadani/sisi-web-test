<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuUser extends Model
{
    use HasFactory;

    protected $table = 'menu_user';
    protected $primaryKey = 'no_seting';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
