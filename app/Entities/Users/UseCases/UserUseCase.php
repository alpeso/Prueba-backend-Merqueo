<?php

namespace App\Entities\Users\UseCases;

use App\Entities\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Entities\Users\UseCases\Interfaces\UserUseCaseInterface;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserUseCase
 * 
 * @author Alexander Pedrozo Solano
 */
class UserUseCase implements UserUseCaseInterface
{

    /**
     * @var UserRepositoryInterface
     */
    protected $userInterface;

    /**
     * UserUseCase constructor.
     * 
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userInterface = $userRepositoryInterface;
    }

    /**
     * @param array $data
     * 
     * @return JsonResponse
     */
    public function createUser(array $data): JsonResponse
    {
        $this->userInterface->createUser($data);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * @param array $data
     * 
     * @return JsonResponse
     * 
     * @throws InvalidFormatException
     */
    public function loginUser(array $data): JsonResponse
    {
        if (!Auth::attempt($data)) {
            return response()->json([
                'message' => "Unauthorized"
            ], 401);
        }

        $user = request()->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->add('hour', 10);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }
    
}
