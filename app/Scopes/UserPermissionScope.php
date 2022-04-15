<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserPermissionScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $authUser = User::query()->findOrFail(Auth::id());
        if ($authUser->role !== 'admin' && $authUser->role !== 'superAdmin') {
            return $builder->where('user_id', Auth::id());
        } else {
            return $builder;
        }
    }
}
