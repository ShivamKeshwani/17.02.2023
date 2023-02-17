<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageStorage extends Model
{
    use HasFactory;
    protected $table = 'crud_storage_images';
    protected $primarkyKey = 'id';
    protected $fillable = ['name', 'detail', 'image'];

}
