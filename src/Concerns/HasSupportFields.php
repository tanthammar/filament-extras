<?php

namespace Tanthammar\FilamentExtras\Concerns;

trait HasSupportFields
{

    abstract protected function supportFields(): array;
    abstract protected function userFields(): array;

    protected function roleFields(): array
    {
        if (\Auth::user()?->isSupport()) {
            return $this->supportFields();
        }
        return $this->userFields();
    }
}
