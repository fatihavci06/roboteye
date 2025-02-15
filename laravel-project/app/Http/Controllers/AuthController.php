<?php
namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Kullanıcı girişi ve JWT token üretme
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
      
        $credentials = $request->only('email', 'password');
        $token = $this->authService->login($credentials['email'], $credentials['password']);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    }

  
  

    /**
     * Kullanıcı çıkışı (token geçersiz kılma)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
      
        // İstekten gelen token'ı al
        $token = $request->bearerToken();

        // Token'ı geçersiz kıl
        $logoutSuccess = $this->authService->logout($token);

        if ($logoutSuccess) {
            return response()->json(['message' => 'Successfully logged out']);
        } else {
            return response()->json(['error' => 'Failed to log out'], 400);
        }
    }
}
