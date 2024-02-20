<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'menu_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function menu_level()
    {
        return $this->belongsTo(MenuLevel::class, 'id_level', 'id_level');
    }
}
