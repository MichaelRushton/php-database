<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Interfaces\SQL\Components;

interface OutfileInterface
{
    public function characterSet(string $name): static;

    public function fieldsTerminatedBy(string $string): static;

    public function fieldsEnclosedBy(string $char): static;

    public function fieldsOptionallyEnclosedBy(string $char): static;

    public function fieldsEscapedBy(string $char): static;

    public function linesStartingBy(string $string): static;

    public function linesTerminatedBy(string $string): static;

    public function pipe(callable $callback): mixed;

    public function through(callable $callback): static;

    public function when(
        mixed $value,
        ?callable $if_true = null,
        ?callable $if_false = null
    ): static;
}
