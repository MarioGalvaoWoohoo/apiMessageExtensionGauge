<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Repositories\userRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoginService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(string $email, string $password)
    {
        $user = $this->userRepository->getByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            return null;
        }

        auth()->login($user);

        return $user;
    }

}
