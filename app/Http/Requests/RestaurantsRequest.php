<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' =>['required' , 'string'],
            'email' =>['email' , 'required'] ,
            'address' => ['string' , 'required'],
            'phone' =>['required' , 'digits:10'],
            'openingHours' => ['required' , 'string'],
            // 'name_user' =>['required' , 'string'],
            // 'email_user' =>['email' , 'required' ] ,


        ];
    }
}
