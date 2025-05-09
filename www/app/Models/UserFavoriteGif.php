<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavoriteGif extends Model {

    use HasFactory;

    protected $fillable = ['user_id', 'gif_id', 'alias'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
