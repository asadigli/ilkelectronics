<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
class Admin
{
    /**
    *The Guard implementation.
    * @var Guard
    */
    protected $auth;
    /**
    * Create a new filter instance.
    *
    * @param Guard $auth
    * @return void
    */
    public function __construct(Guard $auth){
      $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()){
          if ($request->ajax()){
            return response('Unauthorized.', 401);
          } else{
            return redirect('/account?action=login');
            // return redirect()->guest('login');
          }
        } else {
          if(Auth::user()->role_id == 2 | Auth::user()->role_id == 3 | Auth::user()->role_id == 4){
            return $next($request);
          } else {
            return redirect()->back();
          }
        }
    }
}
