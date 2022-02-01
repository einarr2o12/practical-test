<?php

namespace App\Repositories;

use App\Models\UserDetail;

/**
 * Interface UserDetailRepositoryInterface
 */
interface UserDetailRepositoryInterface
{
    /**
     * store user Detial.
     * @param UserDetail $userDetail
     */
    public function save(UserDetail $userDetail): int;

    /**
     * update user by param.     
     * @param string $value
     * @param string $key
     */
    public function update(UserDetail $userDetail, array $inputs): void;

    /**
     * get user detail by param.     
     * @param int $id
     * @param int $userId
     */
    public function findById(int $id, int $userId): ?UserDetail;

    /**
     * get user detail by user id.     
     * @param int $id
     * @param int $userId
     */
    public function getUserDetailByUserId(int $userId): ?UserDetail;
}
