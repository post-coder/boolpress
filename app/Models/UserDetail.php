<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    public function user() {
        // sintassi per indicare che la riga della tabella dipendente (user_details) appartiene ad una riga della tabella principale (users)
        return $this->belongsTo(User::class);
    }
}
