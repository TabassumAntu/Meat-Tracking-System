<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price' =>              ['required', 'integer'],
            'name'  =>              ['required', 'string'],
            'duration' =>           ['required', 'integer'],
            'start_date' =>         ['required', 'date', 'after:' . date('Y-m-d')],
            'description' =>        ['required', 'string'],
        ];
    }
}
