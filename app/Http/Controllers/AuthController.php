<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Internal\Auth\CreateUserParam;
use App\Services\Internal\Auth\CreateUserService;
use App\Services\Internal\Auth\LoginUserService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {
    /**
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function register(Request $request, CreateUserService $service, CreateUserParam $createUserParam): Response {

        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', $this->getPasswordStrength()],
        ]);

        $createUserParam
            ->setName($request->name)
            ->setLastName($request->last_name)
            ->setEmail($request->email)
            ->setPassword($request->password);

        [$createdUser, $createdToken] = $service->run($createUserParam);

        $createdUser->token = $createdToken->plainTextToken;

        return response($createdUser, 201);
    }

    /**
     * @param Request $request
     * @param LoginUserService $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|void
     * @throws ValidationException
     */
    public function login(Request $request, LoginUserService $service)
    {
        $this->validate($request, [
            'email' => ['email', 'required'],
            'password' => ['required', $this->getPasswordStrength()]
        ]);

        try {
            [$user, $token] = $service->run($request->email, $request->password);

            $user->token = $token;

            return response($user, 201);
        } catch (\Exception $e) {
            abort(401, 'The credentials provided are not valid.');
        }
    }

    private function getPasswordStrength(): Rule
    {
        return Password::min(8)->letters()->numbers();
    }
}
