<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginUsersAccess extends Model {

    use HasFactory;

    protected $table = 'login_users_access';

    protected $fillable = [
        'user_id',
        'service',
        'request_body',
        'http_response_code',
        'response_body',
        'ip_request'
    ];
}
