<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        
            if (!$user || !$user->is_admin) {
                return response()->json(['error' => 'Permission denied'], 403);
            }
        
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid token.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not found.'], 401);
        }
        
        return $next($request);
    }
}
