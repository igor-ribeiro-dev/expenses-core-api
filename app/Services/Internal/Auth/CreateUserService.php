<?php

namespace App\Services\Internal\Auth;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Sanctum\NewAccessToken;
use Throwable;

class CreateUserService {
    /**
     * @param CreateUserParam $createUserParam
     * @return array{User, NewAccessToken}
     * @throws Throwable
     */
    public function run(CreateUserParam $createUserParam) {

        try {
            DB::beginTransaction();

            $user = new User();

            $user->fill([
                'name' => $createUserParam->getName(),
                'last_name' => $createUserParam->getLastName(),
                'email' => $createUserParam->getEmail(),
                'password' => $createUserParam->getPassword(),
            ]);

            $user->markEmailAsVerified();

            $token = $user->createToken('default');

            DB::commit();

            return [$user, $token];
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}