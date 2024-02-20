<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IErrorApplication extends Model
{
    use HasFactory;

    protected $table = 'i_error_application';
    protected $primaryKey = 'error_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
