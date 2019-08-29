<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Reply;
use App\Exceptions\ThrottleException;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !\Gate::denies('create', new Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException("Can't make reply now.");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "body" => "required|spamfree"
        ];
    }
}
