<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Schemas\Components\Component;

class TodoField extends Component
{
    protected string $view = 'filament-extras::components.todo-field';

    final public function __construct(
        public readonly string $task
    ) {
    }

    public static function make(string $task): static
    {
        if (app()->isLocal()) {
            throw new \RuntimeException("Incomplete TODO: $task. (Search for 'TodoField::make' in your Filament forms)");
        }

        return new static($task);
    }
}
