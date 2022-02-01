<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserDetailRequest;
use App\Http\Requests\UpdateUserDetailRequest;
use App\Services\UserDetailService;
use App\Traits\ResponserTraits;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    use ResponserTraits;

    /**
     * @var UserDetailService $userDetailService
     */
    protected UserDetailService $userDetailService;

    public function __construct(UserDetailService $userDetailService)
    {
        $this->userDetailService = $userDetailService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserDetailRequest $request)
    {
        $userId = $request->user()->id;

        $id = $this->userDetailService->createdUserDetail($request->validated(), $userId);

        return $this->responseCreated('success', [
            "id" => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserDetailRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserDetailRequest $request, $id)
    {
        $this->userDetailService->updatedUserDetail($request->validated(), $id, $request->user()->id);

        return $this->responseSuccess('success', [
            "updated" => $id
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
        $this->userDetailService->deletedUserDetail($id, request()->user()->id);

        return $this->responseSuccess('success', [
            "deleted" => $id
        ]);
    }
}
