<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Pet extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => 'required|string|max:255',
            // 'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'age' => 'required|integer',
            'informations' => 'required|string|max:2048',
            'city' => 'required|string|max:150',
            'state' => 'required|string|max:2',
            'status' => 'nullable|string|in:lost,found,communicated',
            // 'pet_owners_id' => 'required|exists:pet_owners,id'
        ];
    }
}
