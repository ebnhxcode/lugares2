<?php

namespace App\Http\Middleware\Role;

use Closure;
use Auth;

class UMiddleware {
    private $usuario_logueado;
    private $usuario_role;
    private $role;
    public function handle($request, Closure $next) {
        $this->usuario_logueado = Auth::user();
        if ($this->usuario_role = $this->usuario_logueado->usuario_role) {
            if ($this->role = $this->usuario_role->role) {

                switch ($this->role->nom_role) {
                    case 'Administrador':
                    case 'Jefe de Area':
                    case 'Lider Equipo':
                    case 'Modificador':
                        return $next($request);
                        break;
                }
            }
        }
        return redirect()->to('/');
    }
}
