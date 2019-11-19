<?php

declare(strict_types=1);

namespace App\Application\Http;

use App\Domain\Model\TodoId;
use App\Domain\TodoRepository;
use React\MySQL\QueryResult;
use React\Promise\Deferred;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use function React\Promise\resolve;

class HomePage
{
    private $templateEngine;
    private $repository;

    public function __construct(Environment $template, TodoRepository $repository)
    {
        $this->templateEngine = $template;
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        return $this->repository
            ->get(TodoId::fromString('SomeUuid'))
            ->then(function (QueryResult $queryResult) use (&$todos) {
                return new Response($this->templateEngine->render('index.html.twig', [
                    'docs' => 'https://driftphp.io',
                    'message' => 'Welcome to Drift PHP Framework Starter',
                    'todos' => $queryResult->resultRows,
                ]));
            });
    }
}