<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['title', 'content', 'category_id'];

    // aggiungiamo la possibilità di leggere le tabelle a lui collegate

    // il nostro post appartiene ad una sola categoria
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
