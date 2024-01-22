<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Author
{
    public static function make(): Select
    {
        $field = Select::make('user_id')->label(__('fields.user'))
            ->relationship('author', 'name')
            ->default(Auth::id())
            ->required();

        return user()?->isSupport()
            ? $field
                ->searchable()
                ->getSearchResultsUsing(fn (string $search): Collection => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                ->rules('exists:users,id')
            : $field
                ->options(fn (): Collection => user()->currentTeam->allUsers()->pluck('name', 'id'))
                ->rule(Rule::in([Auth::id()]));
    }
}
