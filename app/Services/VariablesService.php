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
    private $variables;
    private $user_variables;

    public function __construct(Group $group, ?User $user = null)
    {
        $this->variables = $group->variables()->orderByTranslation('description')->get();
        $user_variables = $user ? $user->variables() : Auth::user()->variables();

        $this->user_variables = $user_variables->where('group_id', $group->id)->orderByTranslation('description')->get();
    }

    public function get()
    {
        $collection = new Collection();
        foreach ($this->variables as $key => $variable) {
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
    public function storeForUser(array $user_variables)
    {
        $variables = $this->variables->pluck('default_val', 'id')->toArray();
        $user_variables = array_diff($user_variables, $variables);
        $variables = $this->variables->whereIn('id', array_keys($user_variables));

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

        DB::transaction(function () use ($attach) {
                Auth::user()->variables()->detach($this->variables);
                Auth::user()->variables()->sync($attach, false);
        });

    }
}