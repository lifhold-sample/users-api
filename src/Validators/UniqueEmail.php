<?php

declare(strict_types=1);

namespace Lifhold\Users\Api\Validators;

use Illuminate\Contracts\Validation\Rule;
use Lifhold\Users\Contracts\UsersService;
use Lifhold\Users\Exceptions\UserModuleException;
use Lifhold\Users\Exceptions\UserNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UniqueEmail implements Rule
{
    protected UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $this->usersService->findByEmail($value);
            return true;
        } catch (UserNotFoundException | UserModuleException $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return "The :attribute already exists.";
    }
}
