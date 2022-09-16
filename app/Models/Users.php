<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Users extends Model
{
    use AuthenticableTrait;
    
    protected $table = 'users';
    protected $fillable = ['firstname','lastname','username','email','password'];
    protected $hidden = ['password'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Crypt::encrypt($password);
    }
}