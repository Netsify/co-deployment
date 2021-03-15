<?php

namespace App\Services;
use App\Models\User;
use App\Models\Variables\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Сервис для работы с переменными
 *
 * Class VariablesService
 * @package App\Services
 */
class VariablesService
{
    private $groups;
    private $user_variables;

    public function __construct($user)
    {
        $this->groups = Group::query()->with('variables.translations')->get();
//        $this->variables = $group->variables->sortBy('description')/*()->orderByTranslation('description')->get()*/;

        $this->user_variables = $user->variables;

//        $this->user_variables = $user_variables->where('group_id', $group->id)->orderByTranslation('description')->get();
    }

    public function get(Group $group)
    {
        $variables = $this->groups->find($group)->variables;

        $collection = new Collection();
        foreach ($variables as $key => $variable) {
            if ($this->user_variables->contains($variable)) {
                $variable->value = $this->user_variables->find($variable->id)->pivot->value;
            } else {
                $variable->value = $variable->default_val;
            }

            $collection->put($variable->id, $variable);
        }

        return $collection;
    }

    /**
     * Сохраняем значения переменных для пользователя
     *
     * @param array $user_variables
     */
    public function storeForUser(array $user_variables, Group $group)
    {
        $variables = $group->variables->pluck('default_val', 'id')->toArray();

        $user_variables = array_diff_assoc($user_variables, $variables);
        $variables = $group->variables->whereIn('id', array_keys($user_variables));

        $attach = [];
        foreach ($variables as $variable) {
            switch ($variable->type) {
                case 'INT': $user_variables[$variable->id] = abs((int)$user_variables[$variable->id]); break;
                case 'FLOAT': $user_variables[$variable->id] = abs((float)$user_variables[$variable->id]); break;
            }

            if ($user_variables[$variable->id] != $variable->default_val) {
                $attach[$variable->id] = [
                    'value' => $user_variables[$variable->id]
                ];
            }
        }

        DB::transaction(function () use ($attach, $group) {
                Auth::user()->variables()->detach($group->variables);
                Auth::user()->variables()->sync($attach, false);
        });

    }
}