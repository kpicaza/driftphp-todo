<?php

declare(strict_types=1);

namespace App\Application\Http;

use App\Domain\Model\Todo;
use App\Domain\Model\TodoId;
use App\Domain\TodoRepository;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DoneTodo
{
    /** @var TodoRepository * */
    private $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request, string $todoId): PromiseInterface
    {
        return $this->repository->get(TodoId::fromString($todoId))
            ->then(static function (Todo $todo) {
                $todo->done();
                return $todo;
            })
            ->then(function (Todo $todo) {
                $this->repository->save($todo);
                return new RedirectResponse('/');
            });
    }
}
