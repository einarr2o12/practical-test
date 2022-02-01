<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * store user.
     * @param User $user
     */
    public function save(User $user): int;

    /**
     * get user by param.     
     * @param string $value
     * @param string $key
     */
    public function findBy(string $key, string $value): ?User;

    /**
     * get user by param.     
     * @param int $id
     */
    public function findById(int $id): ?User;

    /**
     * Begin DB transaction.
     */
    public function beginTransaction(): void;

    /**
     * DB transaction rollback.
     */
    public function rollback(): void;

    /**
     * DB transaction commit.
     */
    public function commit(): void;
}
