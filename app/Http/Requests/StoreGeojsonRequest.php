<?php

namespace App\Http\Requests;

use App\Rules\GeojsonFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreGeojsonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'area' => 'required|unique:geojsons,area',
            'file' => ['required', 'file', new GeojsonFile, 'max:10240']
        ];
    }

    public function messages(): array
    {
        return [
            'area.required' => 'Nama Wilayah harus diisi.',
            'file.file' => 'File tidak valid.'
        ];
    }
}
