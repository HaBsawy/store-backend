<?php

namespace App\Http\Controllers\Auth;

use App\Helper\JsonResponder;
use App\Helper\Twilio;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgetPasswordRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Notifications\ForgetPasswordMail;
use App\Notifications\WelcomeMail;
use App\Repository\User\UserInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $user;

    /**
     * Create a new AuthController instance.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->user->register($request->all());
        $user->notify(new WelcomeMail($user));
//        Twilio::send(env('TWILIO_WHATSAPP_ADMIN'),
//            'new user ' . $user->name . ' with email ' . $user->email . ' registered to store web app'
//        );
        $token = auth()->login($user);

        return JsonResponder::make([
            'token' => $token,
            'user'  => $user
        ], true, 201, 'user is created successfully');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return JsonResponder::make(null, false, 401, 'unauthorized');
        }

        $user = $this->user->getByEmail(request('email'));

        return $this->respondWithToken($token, $user);
    }

    public function verify($token)
    {
        return $this->user->verify($token) ?
            JsonResponder::make(null, true, 202, 'the email is verified successfully') :
            JsonResponder::make(null, false, 404, 'user not found');
    }

    public function resendWelcomeMail()
    {
        $user = $this->user->updateVerifyToken();
        $user->notify(new WelcomeMail($user));

        return JsonResponder::make(null, true, 202, 'mail is sent');
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $user = $this->user->getByEmailAndUpdateToken($request->all());

        if (!$user) {
            return JsonResponder::make(null, false, 404, 'user not found');
        }

        $user->notify(new ForgetPasswordMail($user));

        return JsonResponder::make(null, true, 202, 'forget password mail is sent');
    }

    public function resetPassword($token, ResetPasswordRequest $request)
    {
        return  $this->user->updatePassword($token, $request->all()) ?
            JsonResponder::make(null, true, 202, 'password is updated successfully') :
            JsonResponder::make(null, false, 404, 'user not found');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return JsonResponder::make(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return JsonResponder::make(null, true, 202, 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @param null $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null)
    {
        $data = [
            'token' => $token,
            'user' => $user,
        ];

        return JsonResponder::make($data, true, 202);
    }
}
