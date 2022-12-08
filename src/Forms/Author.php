<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Auth;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rule;

class Author
{
    public static function make(): Select
    {
        $isSupport = user()->isSupport();

        return Select::make('user_id')->label(__('fields.user'))
            ->relationship('author', 'name')
            ->searchable($isSupport)
            ->getSearchResultsUsing(fn (string $search) => $isSupport
                ? User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')
                : user()->currentTeam->allUsers()->pluck('name', 'id'))
            ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name)
            ->disablePlaceholderSelection()
            ->default(Auth::id())
            ->rule($isSupport
                ? Rule::exists('users', 'id')
                : Rule::in([Auth::id()])
            )
            ->required();
    }
}
