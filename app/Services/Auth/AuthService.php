<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * AuthService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle user registration.
     *
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        $user = $this->userRepository->create($data);

        event(new Registered($user));

        $user->sendEmailVerificationNotification();

        Auth::login($user);

        return $user;
    }
}
