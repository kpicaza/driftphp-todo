<?php

declare(strict_types=1);

namespace App\Application\Http;

use App\Domain\Model\Todo;
use App\Domain\Model\TodoId;
use App\Domain\Model\TodoMessage;
use App\Domain\TodoRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddTodo
{
    /** @var TodoRepository **/
    private $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request): Response
    {
        $todo = Todo::fromTodoIdAndMessage(
            TodoId::fromString('SomeUuid'),
            TodoMessage::fromString('Hola mundo')
        );

        $this->repository->save($todo);

        return new RedirectResponse('/');
    }
}
