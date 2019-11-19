<?php

declare(strict_types=1);

namespace App\Application\Http\Request;

use React\Promise\FulfilledPromise;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class AddTodoValidator
{
    public function getFormData(Request $request): PromiseInterface
    {
        $form = $request->request->all();
        Assert::notEmpty($form);
        Assert::keyExists($form, 'todo_message');

        return new FulfilledPromise(AddTodoRequest::withMessage($form['todo_message']));
    }
}
