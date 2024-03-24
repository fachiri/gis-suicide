<?php

namespace App\Http\Requests;

use App\Constants\UserGender;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePerpetratorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => 'required|string',
            'age' => 'required|integer|min:0',
            'education' => 'required|string',
            'address' => 'required|string|max:255',
            'marital_status' => 'required|string',
            'occupation' => 'required|string|max:255',
            'economic_status' => 'required|string',
            'incident_date' => 'required|date',
            'suicide_method' => 'required|string|max:255',
            'suicide_tool' => 'required|string|max:255',
            'motive' => 'required|string',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }
}
