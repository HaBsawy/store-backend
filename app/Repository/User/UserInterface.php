<?php

namespace App\Repository\User;

interface UserInterface
{
    public function register(array $data);
    public function verify(string $token);
    public function updateVerifyToken();
    public function getByEmailAndUpdateToken(array $data);
    public function getByEmail(string $email);
    public function updatePassword(string $token, array $data);
}
