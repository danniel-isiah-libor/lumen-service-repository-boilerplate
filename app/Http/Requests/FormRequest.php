<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class FormRequest extends BaseController
{
    /**
     * Request represents an HTTP request.
     * 
     * @var mixed
     */
    public $request;

    /**
     * Create the abstract class instance.
     * 
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->validator();
    }

    /**
     * Validate the given request with the given rules and return the validated data from the request.
     * 
     * @return mixed
     */
    public function validated()
    {
        return $this->validate($this->request, $this->rules(), $this->messages());
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Set the custom validation.
     * 
     * @return void
     */
    public function validator()
    {
        return $this;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
