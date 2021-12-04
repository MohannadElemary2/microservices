<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends BaseController
{
    protected $resource = UserResource::class;

    protected $storeRequestFile = RegisterRequest::class;

    public function __construct(AuthService $service)
    {
        parent::__construct($service);
    }
}
