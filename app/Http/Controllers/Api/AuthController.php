<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json(';کد احراز هویت با موفقیت ارسال شد', 200);
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
            return response()->json('کد احراز هویت با موفقیت تایید شد', 200);
        } else {
            return response()->json('کد احراز هویت معتبر نیست', 400);
        }
    }

    public function login(LoginUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            if (Arr::get($data, 'phoneNumber')) {
                return response()->json('شماره تلفن همراه یا رمز عبور اشتباه است.', 422);
            } else {
                return response()->json('ایمیل یا رمز عبور اشتباه است.', 422);
            }
        }

        $user = auth()->user();

        if (!$user->isVerify()) {
            return response()->json('اهراز هویت تکمیل نشده است.', 401);
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
            return response()->json('کاربر غیر فعال است', 422);
        }

    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user
         */
        $request->user()->token()->revoke();
        return response()->json('شما با موفقیت خارج شدید.');
    }

    public function changePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'password' => 'required|string|confirmed',
        ]);

        auth('api')->user()->password = bcrypt($request->password);
        auth('api')->user()->save();
        return response()->json('رمز شما با موفقیت تغییر یافت');
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
            return response()->json('کد احراز هویت با موفقیت ارسال شد', 200);
        } else {
            return response()->json('خطای سیستمی', 404);
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
            return response()->json('کد احراز هویت معتبر نیست', 400);
        }
        if (Carbon::parse($resetPassword->updated_at)->addMinutes(2000)->isPast()) {
            $resetPassword->delete();
            return response()->json('کد احراز هویت معتبر نیست', 400);
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

    public function active(Request $request, User $user): UserResource
    {
        $this->validate($request, [
            'active' => 'required|boolean',
        ]);

        $user->update(['active' => $request->get('active')]);

        return new UserResource($user);
    }
}
