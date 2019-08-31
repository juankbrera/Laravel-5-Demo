<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\userResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Auth factory
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Carbon class
     *
     * @var Carbon\Carbon
     */
    protected $carbon;

    /**
     * User Model
     *
     * @var App\Models\User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param  Carbon\Carbon                      $carbon
     * @param  Illuminate\Contracts\Auth\Factory  $auth
     * @param  App\Models\User                    $user
     */
    public function __construct(
        Carbon $carbon,
        Factory $auth,
        User $user
    ) {
        $this->auth  = $auth;
        $this->carbon = $carbon;
        $this->user = $user;
    }

    /**
     * Signup a new user.
     *
     * @param  App\Http\Requests\SignupRequest $request
     * @return string
     */
    public function signup(SignupRequest $request)
    {
        $validated_data = $request->validated();
        $validated_data['password'] = bcrypt($request->password);

        $user = $this->user->create($validated_data);

        return new UserResource($user);
    }

    /**
     * Login - Creates and return a new token.
     *
     * @param  App\Http\Requests\LoginRequest $request
     * @return string
     */
    public function login(LoginRequest $request)
    {
        $validated_data = $request->validated();

        if (!$this->auth->attempt($validated_data)) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }

        $user        =  $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token       = $tokenResult->token;

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => $this->carbon->parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ]);
    }

    /**
     * Revoke the user token.
     *
     * @param  Illuminate\Http\Request $request
     * @return string
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' =>
            'Successfully logged out'], 200);
    }


    /**
     * Return the user data.
     *
     * @param  Illuminate\Http\Request $request
     * @return string
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }
}
