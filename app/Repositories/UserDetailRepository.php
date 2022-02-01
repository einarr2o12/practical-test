<?php

namespace App\Repositories;

use App\Models\UserDetail;

class UserDetailRepository implements UserDetailRepositoryInterface
{
    /**
     * get user detail by user id.     
     * @param int $id
     * @param int $userId
     */
    public function getUserDetailByUserId(int $userId): ?UserDetail
    {
        return UserDetail::where('user_id', $userId)->first();
    }

    /**
     * store user detail.
     * @param UserDetail $userDetail
     */
    public function save(UserDetail $userDetail): int
    {
        $userDetail->save();
        return $userDetail->id;
    }

    /**
     * update user by param.
     * @param UserDetail $userDetail
     * @param array $inputs
     */
    public function update(UserDetail $userDetail, array $inputs): void
    {
        $userDetail->update($inputs);
    }

    /**
     * get user by param.     
     * @param int $id
     * @param int $userId
     */
    public function findById(int $id, int $userId): ?UserDetail
    {
        return UserDetail::where('id', $id)->where('user_id', $userId)->first();
    }
}
