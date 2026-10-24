<?php

declare(strict_types=1);

namespace MichaelRushton\Database\Traits\SQL;

use MichaelRushton\Database\Interfaces\SQL\HasBindings;
use Stringable;

trait FrameSpec
{
    protected array $frame_spec = [];

    public function range(): static
    {

        $this->frame_spec[0] = 'RANGE';

        return $this;

    }

    public function rows(): static
    {

        $this->frame_spec[0] = 'ROWS';

        return $this;

    }

    public function groups(): static
    {

        $this->frame_spec[0] = 'GROUPS';

        return $this;

    }

    protected function between(): static
    {

        $this->frame_spec[1] = 'BETWEEN';

        return $this;

    }

    public function currentRow(): static
    {

        $this->frame_spec[2] = 'CURRENT ROW';

        return $this;

    }

    public function unboundedPreceding(): static
    {

        $this->frame_spec[2] = 'UNBOUNDED PRECEDING';

        return $this;

    }

    public function unboundedFollowing(): static
    {

        $this->frame_spec[2] = 'UNBOUNDED FOLLOWING';

        return $this;

    }

    public function preceding(int|string|Stringable $expression): static
    {

        $this->frame_spec[2] = [$expression, 'PRECEDING'];

        return $this;

    }

    public function following(int|string|Stringable $expression): static
    {

        $this->frame_spec[2] = [$expression, 'FOLLOWING'];

        return $this;

    }

    public function betweenCurrentRow(): static
    {
        return $this->between()->currentRow();
    }

    public function betweenUnboundedPreceding(): static
    {
        return $this->between()->unboundedPreceding();
    }

    public function betweenUnboundedFollowing(): static
    {
        return $this->between()->unboundedFollowing();
    }

    public function betweenPreceding(int|string|Stringable $expression): static
    {
        return $this->between()->preceding($expression);
    }

    public function betweenFollowing(int|string|Stringable $expression): static
    {
        return $this->between()->following($expression);
    }

    protected function and(): static
    {

        $this->frame_spec[3] = 'AND';

        return $this;

    }

    public function andCurrentRow(): static
    {

        $this->frame_spec[4] = 'CURRENT ROW';

        return $this->and();

    }

    public function andUnboundedPreceding(): static
    {

        $this->frame_spec[4] = 'UNBOUNDED PRECEDING';

        return $this->and();

    }

    public function andUnboundedFollowing(): static
    {

        $this->frame_spec[4] = 'UNBOUNDED FOLLOWING';

        return $this->and();

    }

    public function andPreceding(int|string|Stringable $expression): static
    {

        $this->frame_spec[4] = [$expression, 'PRECEDING'];

        return $this->and();

    }

    public function andFollowing(int|string|Stringable $expression): static
    {

        $this->frame_spec[4] = [$expression, 'FOLLOWING'];

        return $this->and();

    }

    public function excludeCurrentRow(): static
    {

        $this->frame_spec[5] = 'EXCLUDE CURRENT ROW';

        return $this;

    }

    public function excludeGroup(): static
    {

        $this->frame_spec[5] = 'EXCLUDE GROUP';

        return $this;

    }

    public function excludeNoOthers(): static
    {

        $this->frame_spec[5] = 'EXCLUDE NO OTHERS';

        return $this;

    }

    public function excludeTies(): static
    {

        $this->frame_spec[5] = 'EXCLUDE TIES';

        return $this;

    }

    protected function getFrameSpec(): string
    {

        if (empty($this->frame_spec)) {
            return '';
        }

        ksort($this->frame_spec);

        foreach ($this->frame_spec as $part) {

            $frame_spec[] = implode(' ', (array) $part);

            if ($part[0] instanceof HasBindings) {
                $this->mergeBindings($part[0]);
            }

        }

        return implode(' ', $frame_spec ?? []);

    }
}
