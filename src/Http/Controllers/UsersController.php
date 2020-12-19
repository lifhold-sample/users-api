<?php

declare(strict_types=1);

namespace Lifhold\Users\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Lifhold\Users\Api\Http\Resources\UserResource;
use Lifhold\Users\Api\Validators\UniqueEmail;
use Lifhold\Users\Contracts\UsersService;
use Lifhold\Users\Exceptions\UserModuleException;
use Lifhold\Users\Exceptions\UserNotFoundException;

class UsersController extends Controller
{
    protected UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse|JsonResource
     */
    public function getOne(Request $request, int $id)
    {
        try {
            return new UserResource($this->usersService->getOne($id));
        } catch (UserNotFoundException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (UserModuleException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * @param Request $request
     * @return JsonResource|JsonResponse
     */
    public function create(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make($formData, [
            "email" => ["required", new UniqueEmail($this->usersService)],
            "password" => ['required']
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            return new UserResource($this->usersService->create(
                $formData['email'],
                $formData['password'])
            );
        } catch (UserModuleException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     */
    public function delete(Request $request, int $id)
    {
        return new JsonResponse($this->usersService->delete($id), Response::HTTP_OK);
    }
}
