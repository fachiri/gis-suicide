<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GeojsonFile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value->getClientMimeType() !== 'application/geo+json') {
            $fail(':attribute tidak valid.');
        }
    }
}
