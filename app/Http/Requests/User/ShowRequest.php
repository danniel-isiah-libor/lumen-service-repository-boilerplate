<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class ShowRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Set the custom validation.
     * 
     * @return void
     */
    public function validator()
    {
        //
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
