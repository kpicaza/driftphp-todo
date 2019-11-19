<?php

declare(strict_types=1);

namespace App\Application\Http;

use App\Application\Http\Request\AddTodoRequest;
use App\Application\Http\Request\AddTodoValidator;
use App\Domain\Model\Todo;
use App\Domain\Model\TodoId;
use App\Domain\Model\TodoMessage;
use App\Domain\TodoRepository;
use Ramsey\Uuid\Uuid;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AddTodo
{
    /** @var TodoRepository **/
    private $repository;
    /** @var AddTodoValidator **/
    private $addTodoValidator;

    public function __construct(TodoRepository $repository, AddTodoValidator $todoValidator)
    {
        $this->repository = $repository;
        $this->addTodoValidator = $todoValidator;
    }

    public function __invoke(Request $request): PromiseInterface
    {
        return $this->addTodoValidator->getFormData($request)
            ->then(static function (AddTodoRequest $todoRequest) {
                return Todo::fromTodoIdAndMessage(
                    TodoId::fromString(Uuid::uuid4()->toString()),
                    TodoMessage::fromString($todoRequest->message())
                );
            })
            ->then(function (Todo $todo) {
                $this->repository->save($todo);
                return new RedirectResponse('/');
            }, static function (\Throwable $e) {
                throw $e;
            });
    }
}
