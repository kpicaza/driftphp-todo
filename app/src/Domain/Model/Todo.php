<?php

declare(strict_types=1);

namespace App\Domain\Model;

use DateTimeImmutable;

class Todo
{
    private $todoId;
    private $message;
    private $existSince;

    private function __construct(TodoId $todoId, TodoMessage $message, DateTimeImmutable $existSince)
    {
        $this->todoId = $todoId;
        $this->message = $message;
        $this->existSince = $existSince;
    }

    public static function fromTodoIdAndMessage(TodoId $todoId, TodoMessage $message): self
    {
        return new self($todoId, $message, new DateTimeImmutable());
    }

    public function id(): TodoId
    {
        return $this->todoId;
    }

    public function message(): TodoMessage
    {
        return $this->message;
    }

    public function existSince()
    {
        return $this->existSince;
    }
}
