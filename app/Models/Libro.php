<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    protected $table = 'libros';

     /**
     * Get the post that owns the comment.
     */
    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }
}
