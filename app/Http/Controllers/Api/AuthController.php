<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\PasswordReset;
use App\Models\Template;
use App\Models\User;
use App\Services\Confirmation\Confirmation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        Arr::set($data, 'role', 'user');

        $data['password'] = bcrypt($request->password);

        $user = User::query()->create($data);

        $accessToken = $user->createToken('UserToken')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $accessToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function confirmRegister(User $user): \Illuminate\Http\JsonResponse
    {
        Confirmation::build('register_phone_number', $user, Template::$SING_IN);

        return response()->json(['error' => trans('messages.success_confirm')], 200);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verifyRegister(User $user, Request $confirm): \Illuminate\Http\JsonResponse
    {
        $this->validate($confirm, [
            'confirm' => 'required|integer',
        ]);

        $userId = Cache::pull('register_phone_number' . Arr::get($confirm, 'confirm'));
        if ($user->id == $userId) {
            $user->verify();
            $user->save();
            return response()->json(['error' => trans('messages.accept_confirm')], 200);
        } else {
            return response()->json(['error' => trans('messages.error_confirm')], 400);
        }
    }

    public function login(LoginUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            if (Arr::get($data, 'phoneNumber')) {
                return response()->json([
                    'error' => trans('messages.phone_login_error')
                ], 422);
            } else {
                return response()->json([
                    'error' => trans('messages.email_login_error')
                ], 422);
            }
        }

        $user = auth()->user();

        if (!$user->isVerify()) {
            return response()->json([
                'user' => $user,
                'verify' => false
            ]);
        }

        if ($user->isActive()) {
            $tokenResult = $user->createToken('userToken');
            $tokenModel = $tokenResult->token;

            if ($request->remember_me) {
                $tokenModel->expires_at = Carbon::now()->addWeeks(1);
            }

            $tokenModel->save();

            return response()->json([
                'user' => new UserResource($user),
                'token' => $tokenResult->accessToken,
                'token_type' => 'Bearer'
            ]);
        } else {
            return response()->json([
                'error' => trans('messages.deactivate_user')
            ], 422);
        }

    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user
         */
        $request->user()->token()->revoke();
        return response()->json([
            'error' => trans('messages.logout_success')
        ], 200);
    }

    public function changePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'password' => 'required|string|confirmed',
        ]);

        auth('api')->user()->password = bcrypt($request->password);
        auth('api')->user()->save();
        return response()->json(['error' => trans('messages.change_password_success')], 200);
    }

    public function forgotPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'phoneNumber' => 'required|exists:users,phoneNumber',
        ]);

        $user = User::query()->where('phoneNumber', $request->phoneNumber)->firstOrFail();
        $user->update(['phone_verified_at' => null]);

        $resetPassword = PasswordReset::query()->updateOrCreate(
            ['phoneNumber' => $user->phoneNumber],
            [
                'phoneNumber' => $user->phoneNumber,
                'token' => Confirmation::build('reset_password_phone_number', $user, Template::$RESET_PASSWORD, false)
            ]
        );

        if ($resetPassword) {
            return response()->json(['error' => trans('messages.success_confirm')], 200);
        } else {
            return response()->json(['error' => trans('messages.system_error')], 404);
        }
    }

    public function verifyForgotPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'phoneNumber' => 'required|exists:users,phoneNumber',
            'password' => 'required|string|confirmed',
        ]);
        $resetPassword = PasswordReset::query()->where('token', $request->code)->first();
        if (!$resetPassword || $resetPassword->phoneNumber !== $request->phoneNumber) {
            return response()->json(['error' => trans('messages.error_confirm')], 400);
        }
        if (Carbon::parse($resetPassword->updated_at)->addMinutes(2000)->isPast()) {
            $resetPassword->delete();
            return response()->json(['error' => trans('messages.error_confirm')], 400);
        }

        $user = User::query()->where('phoneNumber', $resetPassword->phoneNumber)->firstOrFail();
        $user->password = bcrypt($request->password);
        $user->verify();
        $user->save();
        $resetPassword->delete();

        $accessToken = $user->createToken('Personal Client')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $accessToken,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws ErrorException
     */
    public function assignRole(User $user, Request $ability): UserResource
    {
        $this->authorize('assignRole', $user);

        $this->validate($ability, [
            'ability' => 'required|string|in:user,admin,superAdmin',
        ]);

        $user->role = $ability->ability;

        if (Auth::id() !== $user->id) {
            $user->save();
        } else {
            throw new ErrorException(trans('messages.unpossible_operation'));
        }

        return new UserResource($user);

    }

    public function userRole(User $user)
    {
        return $user->role;
    }

    public function user(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('viewAny', User::class);

        return UserResource::collection(
            User::filter(request())->paginate(request('per_page'), ['*'], 'page', request('page'))
        );
    }

    public function show(User $user): UserResource
    {
        $this->authorize('show', User::class);

        return new UserResource($user);
    }

    public function update(User $user, UpdateUserRequest $request): UserResource
    {
        $this->authorize('update', User::class);

        $user->update($request->validated());
        return new UserResource($user);
    }

    public function active(Request $request, User $user): UserResource
    {
        $this->validate($request, [
            'active' => 'required|boolean',
        ]);

        if (Auth::id() !== $user->id) {
            $user->update(['active' => $request->get('active')]);
        } else {
            throw new ErrorException(trans('messages.unpossible_operation'));
        }

        return new UserResource($user);
    }
}
