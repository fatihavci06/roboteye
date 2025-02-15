<?php

namespace App\Services;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * Kullanıcıyı giriş yaptıktan sonra JWT Token oluşturur.
     *
     * @param string $email
     * @param string $password
     * @return string|null
     */
    public function login(string $email, string $password): ?string
    {
        
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return JWTAuth::fromUser($user);
    }

    /**
     * Geçerli kullanıcının bilgilerini döndürür.
     *
     * @param string $token
     * @return \App\Models\User|null
     */
   
    /**
     * Kullanıcıyı çıkış yapmaya zorlar, token geçersiz kılınır.
     *
     * @param string $token
     * @return bool
     */
    public function logout(string $token): bool
    {
        try {
            // Geçerli token'ı geçersiz kıl
            JWTAuth::setToken($token)->invalidate();
            return true;
        } catch (JWTException $e) {
            return false;
        }
    }
}
