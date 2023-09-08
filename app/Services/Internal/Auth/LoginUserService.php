<?php

namespace App\Services\Internal\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class LoginUserService
{

    public function run($email, $password)
    {
        $user = User::query()->where('email', $email)->firstOrFail();

        if(!Hash::check($password, $user->password)) {
            throw new UnauthorizedException('Invalid password');
        }

        return [$user, $user->createToken('desktop')->plainTextToken];
    }
}
