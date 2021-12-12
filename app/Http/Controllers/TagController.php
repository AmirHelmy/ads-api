<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Repositories\TagRepository;


class TagController extends Controller
{
    protected $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return TagResource::collection(
            $this->repository->all()
        );
    }

    public function store(TagRequest $request)
    {
        return new TagResource(
            $this->repository->create($request->validated())
        );
    }

    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    public function update(TagRequest $request, Tag $tag)
    {
        return new TagResource(
            $this->repository->update($tag, $request->validated())
        );
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
