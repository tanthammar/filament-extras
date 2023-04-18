<?php

namespace Tanthammar\FilamentExtras\Tables;

/** Features I miss in Filament v3 */
class ExtendedTable extends \Filament\Tables\Table
{
    public function prependActions(array $actions): static
    {
        $this->actions = \Arr::prepend($this->actions, $actions);

        return $this;
    }

    public function prependBulkActions(array $actions): static
    {
        $this->bulkActions = \Arr::prepend($this->bulkActions, $actions);

        return $this;
    }

    public function prependHeaderActions(array $actions): static
    {
        $this->headerActions = \Arr::prepend($this->headerActions, $actions);

        return $this;
    }

    public function appendActions(array $actions): static
    {
        $this->actions = array_merge($this->actions, $actions);

        return $this;
    }

    public function appendBulkActions(array $actions): static
    {
        $this->bulkActions = array_merge($this->bulkActions, $actions);

        return $this;
    }

    public function appendHeaderActions(array $actions): static
    {
        $this->headerActions = array_merge($this->headerActions, $actions);

        return $this;
    }
}
