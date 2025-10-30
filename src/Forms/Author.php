<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Author
{
    public static function make(): Select
    {
        //Support staff can search for any user in db
        //users can see members of all teams they belong to, but they are only allowed to select themselves

        $field = Select::make('user_id')->label(__('fields.user'))
            ->relationship(
                name: 'author',
                titleAttribute: 'name',
                modifyQueryUsing: fn (Builder $query) => user()?->isSupport()
                    ? $query
                    : $query->whereRelation('ownedTeams', 'id', userTeamId())
                        ->orWhereRelation('teams', 'team_id', userTeamId())
            )
            ->default(Auth::id())
            ->required();

        return user()?->isSupport()
            ? $field
                ->searchable(['name', 'email'])
                ->rules('exists:users,id')
            : $field
                ->rule(Rule::in(
                    auth()->teamMembers()->pluck("users.id")->toArray()
                ));
    }
}
