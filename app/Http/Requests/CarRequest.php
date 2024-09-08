<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class CarRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule','array<mixed>','string>
     */
    public function rules()
    {
        return [
            'make' => ['required','string','max:255'],
            'model' => ['required','string','max:255'],
            'year' => ['required','integer','min:1900','max:' . date('Y')],
            'price' => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048']
        ];
    }
}
