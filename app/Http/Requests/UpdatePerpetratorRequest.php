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
            'gender' => 'required|string|in:'.UserGender::MALE.','.UserGender::FEMALE,
            'age' => 'required|integer|min:0',
            'education' => 'required|string',
            'address' => 'required|string|max:255',
            'marital_status' => 'required|string|in:Belum Menikah,Sudah Menikah',
            'occupation' => 'required|string|max:255',
            'incident_date' => 'required|date',
            'suicide_method' => 'required|string|max:255',
            'suicide_tool' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }
}
