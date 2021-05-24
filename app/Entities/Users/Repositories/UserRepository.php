<?php

namespace App\Entities\Users\Repositories;

use App\Entities\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Entities\Users\User;

/**
 * Class UserRepository
 * 
 * @author Alexander Pedrozo Solano
 */
class UserRepository implements UserRepositoryInterface
{
    
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     * 
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $data
     * 
     * @return User
     */
    public function createUser(array $data): User
    {
        return $this->user->create($data);
    }

}
