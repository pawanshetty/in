<?php 
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckRole as Middleware;
use Closure;
use Auth;

class CheckRole{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check())
        {
            return redirect('login');
        }
            
        $user = Auth::user();
    
        if($user->isAdmin()){
            return $next($request);
        }
            
        foreach($roles as $role) {
            if($user->role->name == $role)
            {
                return $next($request);
            }
        }
    
        abort(403, 'Unauthorized action.');
    }
    
	
}