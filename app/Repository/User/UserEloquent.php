<?php

namespace App\Repository\User;

use App\Models\User;
use Carbon\Carbon;

class UserEloquent implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(array $data)
    {
        $token = bcrypt($data['email'] . $data['password']);
        $token = str_replace('/', 'a', $token);

        return $this->user->create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'mobile'            => $data['mobile'],
            'password'          => bcrypt($data['password']),
            'verify_token'      => $token
        ]);
    }

    public function getByEmail(string $email)
    {
        $user = $this->user->where('email', $email)->first();

        return $user ? $user : null;
    }

    public function verify(string $token)
    {
        $user = auth()->user();
        if ($user->verify_token === $token) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            return true;
        }
        return false;
    }

    public function updateVerifyToken()
    {
        $user = auth()->user();
        $token = bcrypt($user->email . $user->password);
        $token = str_replace('/', 'a', $token);
        $user->verify_token = $token;
        $user->save();

        return $user;
    }

    public function getByEmailAndUpdateToken(array $data)
    {
        $user = $this->user->where('email', $data['email'])->first();

        if (!$user) {
            return null;
        }

        $token = bcrypt($user->email . $user->password);
        $token = str_replace('/', 'a', $token);
        $user->verify_token = $token;
        $user->save();

        return $user;
    }

    public function updatePassword(string $token, array $data)
    {
        $user = auth()->user();
        if ($user->verify_token === $token) {
            $user->password = bcrypt($data['password']);
            $user->save();
            return true;
        }
        return false;
    }
}
