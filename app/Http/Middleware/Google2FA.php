<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Google2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //$authenticator = app(Google2FAAuthenticator::class)->boot($request);
        //
        //if ($authenticator->isAuthenticated()) {
        //    return $next($request);
        //}
        //else{
        //    dd('deo hieu cong 2fa fail');
        //    session()->put('2fa_fail',  session()->get('2fa_fail')+1);
        //
        //    if(session()->get('2fa_fail')>2){
        //        auth()->logout();
        //        $request->session()->invalidate();
        //        $request->session()->regenerateToken();
        //    }
        //}
        //session()->put('url.intended',  url()->current());
        //return redirect()->route('admin.two-factor-challenge')->with('error','Fail');

        //return $authenticator->makeRequestOneTimePasswordResponse();

        return $next($request);
    }
}
