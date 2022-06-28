<?php

namespace App\Service\Core;

use Illuminate\Http\Request;

class CSRFValidator
{

    public function isValid(Request $request, $key = 'token'): bool
    {
        return $request->session()->token() === $request->input($key);
    }

}
