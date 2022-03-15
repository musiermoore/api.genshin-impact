<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\Account;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    /**
     * Display accounts of the user.
     *
     * @return JsonResponse|object
     */
    public function index()
    {
        $user = $this->getAuthenticatedUser();

        $data = [
            'account' => Account::getAccountsByUser($user)
        ];

        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AccountStoreRequest $request
     * @return JsonResponse|object
     */
    public function store(AccountStoreRequest $request)
    {
        $user = $this->getAuthenticatedUser();

        $data = $request->validated();

        $account = $user->accounts()->create($data);

        if (empty($account)) {
            return $this->errorResponse(400, 'The account saving error.');
        }

        return $this->successResponse(null, 'The account created successfully');
    }

    /**
     * Display the specific account of the user
     *
     * @param int $id
     * @return JsonResponse|object
     */
    public function show(int $id)
    {
        $data = [
            'account' => Account::getAccountById($id)
        ];

        return $this->successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountUpdateRequest $request
     * @param int $id
     * @return JsonResponse|object
     */
    public function update(AccountUpdateRequest $request, int $id)
    {
        Account::query()
            ->where('id', $id)
            ->update($request->validated());

        return $this->successResponse(null, 'The account has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|object
     */
    public function destroy(int $id)
    {
        Account::query()
            ->where('id', $id)
            ->delete();

        return $this->successResponse(null, 'The account has been deleted');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|object
     */
    public function restore(int $id)
    {
        Account::onlyTrashed()
            ->where('id', $id)
            ->restore();

        return $this->successResponse(null, 'The account has been restored');
    }
}
