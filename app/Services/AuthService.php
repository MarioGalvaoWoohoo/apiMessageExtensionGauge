<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Repositories\userRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticateUser(string $email, string $password): ?string
    {
        $user = $this->userRepository->getByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            return null;
        }

        auth()->login($user);

        $sessionId = Str::random(32);

        return $sessionId;
    }

    public function getUserLogged(): ?User
    {
        return auth()->user();
    }
}
