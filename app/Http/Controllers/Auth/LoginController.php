<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function attemptLogin(Request $request)
    {
        // attempt to issue a token to the user based on the login credentials

        $token = $this->guard()->attempt($this->credentials($request));

        if (!$token){
            return false;
        }

        // Get the authenticated user

        $user = $this->guard()->user();

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return false;
        }

        // set the user token

        $this->guard()->setToken($token);

        return true;
    }

    protected function sendLoginResponse(Request $request){
        $this->clearLoginAttempts($request);

        // get the token from the authentication guard (JWT)

        $token = (string)$this->guard()->getToken();

        // extract the expiry date of the token
        //
        $expiration = $this->guard()->getPayload()->get('exp');

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $this->guard()->user();

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "verification" => "You need to verify email account"
            ]]);
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => "Invalid credentials."
        ]);
    }

    public function logout(){
        $this->guard()->logout();
        return response()->json(['message' => "Logged out successfully"]);
    }

}
