<?php

namespace App\Services;

use App\Exceptions\ResourceConflictException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\UserDetailRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     * @var UserRepositoryInterface $userRepository
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var UserDetailRepositoryInterface $userDetailRepository
     */
    protected UserDetailRepositoryInterface $userDetailRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserDetailRepositoryInterface $userDetailRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userDetailRepository = $userDetailRepository;
    }

    public function createUser(User $user, array $userDetailInputs)
    {
        try {
            $this->userRepository->beginTransaction();
            $id = $this->userRepository->save($user);

            $this->createdUserDetail($id, $userDetailInputs);

            $this->userRepository->commit();

            return $id;
        } catch (Exception $e) {
            throw new ResourceConflictException('email has already register');
        }
    }

    private function createdUserDetail(int $id, array $userDetailInputs): void
    {
        $userDetailInputs['user_id'] = $id;
        $userDetail = new UserDetail($userDetailInputs);

        $this->userDetailRepository->save($userDetail);
    }

    public function getUserById(int $id, int $userId): User
    {
        if ($id !== $userId) {
            throw new ResourceNotFoundException('User Not Found');
        }

        $user = $this->userRepository->findById($id);

        if (is_null($user)) {
            throw new ResourceNotFoundException('User Not Found');
        }

        return $user;
    }

    public function updatedUser(int $id, array $inputs, int $userId): void
    {
        $user = $this->getUserById($id, $userId);

        $user->name = $inputs['name'];

        $this->userRepository->save($user);
    }

    public function deletedUser(int $id, int $userId): void
    {
        $user = $this->getUserById($id, $userId);

        $user->tokens()->delete();

        $user->delete();
    }
}
