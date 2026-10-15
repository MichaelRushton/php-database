<?php

declare(strict_types=1);

namespace MichaelRushton\Database;

use MichaelRushton\Database\Interfaces\SQL\Components\SubqueryInterface;
use MichaelRushton\Database\Interfaces\SQL\Statements\SelectInterface;
use MichaelRushton\Database\SQL\Components\Raw;
use Stringable;

abstract class SQL
{
    public static function identifier(
        string|Stringable|int|float|bool|array|null $value
    ): string|Raw|Stringable|SubqueryInterface|array {

        return match (true) {
            \is_array($value) => array_map(static::identifier(...), $value),
            \is_string($value) => $value,
            \is_scalar($value ?? true) => new Raw('?', $value),
            $value instanceof SelectInterface => $value->toSubquery(),
            default => $value,
        };

    }

    public static function value(
        string|Stringable|int|float|bool|array|null $value
    ): string|Raw|Stringable|SubqueryInterface|array {

        return match (true) {
            \is_array($value) => array_map(static::value(...), $value),
            \is_scalar($value ?? true) => new Raw('?', $value),
            $value instanceof SelectInterface => $value->toSubquery(),
            default => $value,
        };

    }

    public static function bind(string|int|float|bool|null $value): Raw
    {
        return new Raw('?', $value);
    }

    public static function escape(string $string): string
    {
        return str_replace("'", "''", $string);
    }
}
