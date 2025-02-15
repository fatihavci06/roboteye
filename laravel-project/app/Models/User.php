<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    // JWTSubject arayüzünün gerektirdiği iki metod
    public function getJWTIdentifier()
    {
        // Burada genellikle kullanıcı id'si döndürülür
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        
        return [
            'id' => $this->id,  
        ];
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
