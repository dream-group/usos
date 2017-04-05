<?php

namespace Dream\USOS\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApplicantsController extends Controller
{
    public function get()
    {
        return new JsonResponse(['message' => 'test']);
    }
}
