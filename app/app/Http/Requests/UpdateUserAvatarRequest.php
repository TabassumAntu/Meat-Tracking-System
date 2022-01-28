<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserAvatarRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('users_avatar_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'avatar'       => ['required', 'mimes:jpeg,jpg,png,gif', 'max:10000'],
        ];
    }
}
