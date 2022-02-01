<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Traits\ResponserTraits;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponserTraits;
    /**
     * @var UserService $userService;
     */
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = $request->toUser();
        $userDetailInputs = $request->except(['name', 'email', 'password']);

        $id = $this->userService->createUser($user, $userDetailInputs);

        return $this->responseCreated(['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->getUserById($id, request()->user()->id);

        return $this->responseSuccess('success', new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->updatedUser($id, $request->validated(), $request->user()->id);

        return $this->responseSuccess('success', [
            'updated' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->deletedUser($id, request()->user()->id);

        return $this->responseSuccess('success', [
            'deleted' => true
        ]);
    }
}
