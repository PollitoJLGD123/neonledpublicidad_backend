<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permiso;
use App\Models\Rol;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!$request->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No autorizado'
            ], 401);
        }

        // capacidades del token (roles)
        $userRoles = $request->user()->currentAccessToken()->abilities;
        
        // verificar si el token tiene los permisos requeridos
        foreach ($userRoles as $roleName) {
            $rol = Rol::where('nombre', $roleName)->first();
            
            if ($rol) {
                foreach ($permissions as $permissionSlug) {
                    $permiso = Permiso::where('slug', $permissionSlug)->first();
                    
                    if ($permiso && $rol->permisos()->where('permisos.id_permiso', $permiso->id_permiso)->exists()) {
                        return $next($request);
                    }
                }
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No tiene los permisos necesarios para acceder a este recurso'
        ], 403);
    }
}
