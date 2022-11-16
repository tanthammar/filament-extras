<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rule;
use App\Models\Team;

class JetstreamAuthorSection
{
    public static function make(): Section
    {
        $allowedTeams = user()->isSupport() ? Team::all()->pluck('name', 'id') : user()->allTeams()->pluck('name', 'id');
        return Section::make(__('fields.authors'))
            ->schema([
                Select::make('user_id')->label(__('fields.user'))
                    ->relationship('author', 'name')
                    ->searchable(user()->isSupport())
                    ->default(\Auth::id())
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if(!user()->isSupport() && $value !== \Auth::id) {
                                    $fail("Only auth id can be selected");
                                }
                            };
                        },
                    ]),
                Select::make('team_id')->label(__('fields.team'))
                    ->relationship('team', 'name')
                    ->default(user()->current_team_id)
                    ->options($allowedTeams)
                    ->searchable(user()->isSupport())
                    ->rules([Rule::in(array_values($allowedTeams->toArray()))])
            ])->columns(2)
            ->collapsible();
    }
}
