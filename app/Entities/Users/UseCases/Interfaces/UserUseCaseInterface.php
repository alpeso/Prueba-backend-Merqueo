<?php

namespace App\Entities\Users\UseCases\Interfaces;

use Illuminate\Http\JsonResponse;

/**
 * Class UserUseCaseInterface
 * 
 * @author Alexander Pedrozo Solano
 */
interface UserUseCaseInterface
{
    /**
     * @param array $data
     * 
     * @return JsonResponse
     */
    public function createUser(array $data): JsonResponse;

    /**
     * @param array $data
     * 
     * @return JsonResponse
     */
    public function loginUser(array $data): JsonResponse;

}
