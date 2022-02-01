<?php

namespace App\Services;

use App\Exceptions\ResourceNotFoundException;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\UserDetailRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class UserDetailService
{
    /**
     * @var UserRepositoryInterface $userDetailRepository
     */
    protected UserDetailRepositoryInterface $userDetailRepository;

    public function __construct(UserDetailRepositoryInterface $userDetailRepository)
    {
        $this->userDetailRepository = $userDetailRepository;
    }

    public function createdUserDetail(array $inputs, int $userId): int
    {
        $userDetail = $this->userDetailRepository->getUserDetailByUserId($userId);
        
        if (is_null($userDetail)) {
            $inputs['user_id'] = $userId;
            $userDetail = new UserDetail($inputs);

            $id = $this->userDetailRepository->save($userDetail);
        } else {
            $this->userDetailRepository->update($userDetail, $inputs);

            $id = $userDetail->id;
        }
        $this->sendMail(request()->user());
        return $id;
    }

    private function sendMail(User $user): void
    {
        Mail::send('emails.sendMail', ['name' => $user->name], function ($message) use ($user) {
            $message->to($user->email)->subject('Test');
        });
    }

    public function updatedUserDetail(array $inputs, int $id, int $userId): void
    {
        $userDetail = $this->getUserDetailById($id, $userId);

        $this->userDetailRepository->update($userDetail, $inputs);
    }

    public function getUserDetailById(int $id, int $userId): UserDetail
    {
        $userDetail = $this->userDetailRepository->findById($id, $userId);

        if (is_null($userDetail)) {
            throw new ResourceNotFoundException('User Detail Not Found');
        }

        return $userDetail;
    }

    public function deletedUserDetail(int $id, int $userId): void
    {
        $userDetail = $this->getUserDetailById($id, $userId);

        $userDetail->delete();
    }
}
