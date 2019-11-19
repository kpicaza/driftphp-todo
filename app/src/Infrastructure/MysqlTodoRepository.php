<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Model\Todo;
use App\Domain\Model\TodoId;
use App\Domain\TodoRepository;
use Exception;
use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\Deferred;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use React\Promise\PromisorInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

class MysqlTodoRepository implements TodoRepository
{
    /** @var ConnectionInterface * */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function save(Todo $todo): PromiseInterface
    {
        $query = <<<SQL
INSERT INTO todos (todo_id, message, created_at) VALUES (?, ?, ?);
SQL;

        return $this->connection->query($query, [
            $todo->id()->value(),
            $todo->message()->value(),
            $todo->existSince()->format('Y-m-d H:i:s')
        ])->then(
            function (QueryResult $command) {
                echo $command->insertId;
            },
            function (Exception $error) {
                echo 'Error: ' . $error->getMessage() . PHP_EOL;
            }
        );
    }

    public function get(TodoId $todoId): PromiseInterface
    {
        $query = <<<SQL
SELECT * FROM todos WHERE todo_id = ?;
SQL;

        return $this->connection->query($query, [
            $todoId->value(),
        ]);
    }
}
