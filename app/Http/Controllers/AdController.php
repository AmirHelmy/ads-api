<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdResource;
use App\Repositories\AdRepository;

class AdController extends Controller
{

    protected $repository;

    public function __construct(AdRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return AdResource::collection($this->repository->all());
    }
}
