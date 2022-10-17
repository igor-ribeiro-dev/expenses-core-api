<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Internal\Auth\CreateUserParam;
use App\Services\Internal\Auth\CreateUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            'password' => 'required',
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
}
