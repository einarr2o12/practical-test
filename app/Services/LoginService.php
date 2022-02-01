<?php

namespace App\Services;

use App\Exceptions\ResourceForbiddenException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    /**
     * @var UserRepositoryInterface $userRepository
     */
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $inputs): string
    {
        $user = $this->userRepository->findBy('email', $inputs['email']);

        if (is_null($user)) {
            throw new ResourceNotFoundException('User Not Found');
        }

        if (!Hash::check($inputs['password'], $user->password)) {
            throw new ResourceForbiddenException('password was worng');
        }

        return $user->createToken('User-Token')->plainTextToken;
    }
}
