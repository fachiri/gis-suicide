<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GeojsonFile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value->getClientMimeType() !== 'application/geo+json' && $value->getClientMimeType() !== 'application/octet-stream') {
            $fail(':attribute tidak valid. Format file harus application/geo+json');
        }        
    }
}
