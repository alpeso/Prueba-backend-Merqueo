<?php

namespace App\Http\Controllers\Api\Auth;

use App\Entities\Users\UseCases\Interfaces\UserUseCaseInterface;
use App\Entities\Users\Requests\SignUpRequest;
use App\Entities\Users\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController
 * 
 * @author Alexander Pedrozo Solano
 */
class AuthController extends Controller
{
    /**
     * @var UserUseCaseInterface
     */
    protected $userUseCase;

    /**
     * @param UserUseCaseInterface $userUseCaseInterface
     */
    public function __construct(UserUseCaseInterface $userUseCaseInterface)
    {
        $this->userUseCase = $userUseCaseInterface;
    }

    /**
     * @param SignUpRequest $request
     * 
     * @return JsonResponse
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
        return $this->userUseCase->createUser([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);
    }

    /**
     * @param LoginRequest $request
     * 
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->userUseCase->loginUser(request(['email', 'password']));
    }
}
