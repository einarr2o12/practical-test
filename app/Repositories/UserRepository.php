<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    /**
     * store user.
     * @param User $user
     */
    public function save(User $user): int
    {
        $user->save();
        return $user->id;
    }

    /**
     * get user by param.
     * @param string $value
     * @param string $key
     */
    public function findBy(string $key, string $value): ?User
    {
        return User::where($key, $value)->first();
    }

    /**
     * get user by param.     
     * @param int $id
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Begin DB transaction.
     */
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    /**
     * DB transaction rollback.
     */
    public function rollback(): void
    {
        DB::rollback();
    }

    /**
     * DB transaction commit.
     */
    public function commit(): void
    {
        DB::commit();
    }
}
