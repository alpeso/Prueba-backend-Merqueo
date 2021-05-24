<?php

namespace App\Entities\Users\Repositories\Interfaces;

use App\Entities\Users\User;

/**
 * Class UserRepositoryInterface
 * 
 * @author Alexander Pedrozo Solano
 */
interface UserRepositoryInterface
{

    /**
     * @param array $data
     * 
     * @return User
     */
    public function createUser(array $data): User;

}
