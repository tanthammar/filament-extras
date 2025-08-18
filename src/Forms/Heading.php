<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Concerns\HasName;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

/** @see https://filamentphp.com/docs/2.x/forms/layout#placeholder */
class Heading extends Component
{
    use HasName;

    protected string $view = 'filament-extras::components.heading';

    protected ?string $icon = null;

    protected string $hintIcon = 'heroicon-o-question-mark-circle';

    protected string $design = 'plain';

    protected ?string $color = 'gray';

    protected bool $iconModal = false;

    protected bool $hintModal = false;

    protected ?string $modalView = null;

    protected string $modalTitle = 'Info';

    protected mixed $content = null;

    final public function __construct(string $name)
    {
        $this->name($name);
        $this->statePath($name);
    }

    public static function make(string $uniqueKey): static
    {
        $static = app(static::class, ['name' => $uniqueKey]);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    protected function shouldEvaluateWithState(): bool
    {
        return false;
    }

    /** string or new HtmlString('') */
    public function content($content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->evaluate($this->content);
    }

    public function getLabel(): string | Htmlable | null
    {
        return parent::getLabel() ?? (string) Str::of($this->getName())
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();
    }

    /** blade icon name */
    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon ?: match ($this->color) {
            'danger', 'red' => 'heroicon-o-shield-exclamation',
            'success', 'green' => 'heroicon-o-check-circle',
            'warning', 'orange' => 'heroicon-o-exclamation-triangle',
            'yellow' => 'heroicon-o-exclamation-circle',
            default => 'heroicon-o-information-circle',
        };
    }

    /** blade icon name */
    public function hintIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getHintIcon(): string
    {
        return $this->hintIcon;
    }

    /**
     * open a modal when clicking on the icon <br>
     * blade view, not component. <br>
     * overrides hintModalView
     */
    public function iconModalView(string $view): static
    {
        $this->iconModal = true;
        $this->modalView = $view;

        return $this;
    }

    /**
     * open a modal when clicking on the hintIcon <br>
     * blade view, not component <br>
     * overrides iconModalView
     */
    public function hintModalView(string $view): static
    {
        $this->hintModal = true;
        $this->modalView = $view;

        return $this;
    }

    public function getModalView(): ?string
    {
        return $this->modalView;
    }

    /** default: Info */
    public function modalTitle(string $title): static
    {
        $this->modalTitle = $title;

        return $this;
    }

    public function getModalTitle(): string
    {
        return $this->modalTitle;
    }

    public function getIconModal(): bool
    {
        return $this->iconModal;
    }

    public function getHintModal(): bool
    {
        return $this->hintModal;
    }

    /** options: plain, border-top, border-left */
    public function design(string $design = 'plain'): static
    {
        $this->design = $design;

        return $this;
    }

    public function getDesign(): ?string
    {
        if ($this->design === 'plain') {
            return ' rounded-lg';
        }

        $borderColor = match ($this->color) {
            'danger' => 'border-danger-300 dark:border-danger-800',
            'success' => 'border-success-300 dark:border-success-800',
            'warning' => 'border-warning-300 dark:border-warning-800',
            'info' => 'border-info-300 dark:border-info-800',
            'primary' => 'border-primary-300 dark:border-primary-800',
            'blue' => 'border-blue-300 dark:border-blue-800',
            'green' => 'border-green-300 dark:border-green-800',
            'indigo' => 'border-indigo-300 dark:border-indigo-800',
            'orange' => 'border-orange-300 dark:border-orange-800',
            'pink' => 'border-pink-300 dark:border-pink-800',
            'purple' => 'border-purple-300 dark:border-purple-800',
            'red' => 'border-red-300 dark:border-red-800',
            'teal' => 'border-teal-300 dark:border-teal-800',
            'yellow' => 'border-yellow-300 dark:border-yellow-800',
            'gray' => 'border-gray-300 dark:border-gray-800',
            default => null,
        };

        if ($this->design === 'border-top') {
            return ' border-t-4' . ' ' . $borderColor;
        }

        if ($this->design === 'border-left') {
            return ' border-l-4' . ' ' . $borderColor;
        }

        return null;

    }

    /** default: gray <br>
     * options: any css classes or one of the presets<br>
     * presets: danger, success, warning, info, primary, blue, green, indigo, orange, pink, purple, red, teal, yellow, gray
     */
    public function color(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getStyling(): ?string
    {
        $color = match ($this->color) {
            'danger' => 'text-danger-700 bg-danger-100 dark:bg-gray-800 dark:text-danger-400',
            'success' => 'text-success-700 bg-success-100 dark:bg-gray-800 dark:text-success-400',
            'warning' => 'text-warning-700 bg-warning-100 dark:bg-gray-800 dark:text-warning-400',
            'info' => 'text-info-700 bg-info-100 dark:bg-gray-800 dark:text-info-400',
            'primary' => 'text-primary-700 bg-primary-100 dark:bg-gray-800 dark:text-primary-400',
            'blue' => 'text-blue-700 bg-blue-100 dark:bg-gray-800 dark:text-blue-400',
            'green' => 'text-green-700 bg-green-100 dark:bg-gray-800 dark:text-green-400',
            'indigo' => 'text-indigo-700 bg-indigo-100 dark:bg-gray-800 dark:text-indigo-400',
            'orange' => 'text-orange-700 bg-orange-100 dark:bg-gray-800 dark:text-orange-400',
            'pink' => 'text-pink-700 bg-pink-100 dark:bg-gray-800 dark:text-pink-400',
            'purple' => 'text-purple-700 bg-purple-100 dark:bg-gray-800 dark:text-purple-400',
            'red' => 'text-red-700 bg-red-100 dark:bg-gray-800 dark:text-red-400',
            'teal' => 'text-teal-700 bg-teal-100 dark:bg-gray-800 dark:text-teal-400',
            'yellow' => 'text-yellow-700 bg-yellow-100 dark:bg-gray-800 dark:text-yellow-300',
            'gray' => 'text-gray-700 bg-gray-100 dark:bg-gray-800 dark:text-gray-400',
            default => $this->color,
        };

        return $color . $this->getDesign();
    }
}
