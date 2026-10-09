<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

trait OrOnConflict
{
    protected string $or = '';

    public function orFail(): static
    {

        $this->or = 'OR FAIL';

        return $this;

    }

    public function orIgnore(): static
    {

        $this->or = 'OR IGNORE';

        return $this;

    }

    public function orReplace(): static
    {

        $this->or = 'OR REPLACE';

        return $this;

    }

    public function orRollBack(): static
    {

        $this->or = 'OR ROLLBACK';

        return $this;

    }
}
