<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariableRequest;
use App\Models\Variables\Category;
use App\Models\Variables\Group;
use App\Models\Variables\Variable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VariablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::query()->with('variables.translations', 'facilityTypes.translations')->get();

        return view('admin.variables.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $variable = new Variable();
        $categories = Category::all();
        $var_types = Variable::VAR_TYPES;
        $groups = Group::query()->with('variables.translations', 'facilityTypes.translations')->get();
        $route = route('admin.facilities.variables.store');

        return view('admin.variables.form',
            compact('variable', 'categories', 'var_types', 'groups', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VariableRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariableRequest $request)
    {
        $variable = new Variable([
            'slug' => trim($request->input('name')),
            'min_val' => floatval($request->input('min_val')),
            'max_val' => floatval($request->input('max_val')),
            'default_val' => floatval($request->input('default_val')),
            'type' => strtoupper(trim($request->input('type'))),
            'ru' => [
                'description' => trim($request->input('description.ru')),
                'unit' => trim($request->input('unit.ru'))
            ],
            'en' => [
                'description' => trim($request->input('description.en')),
                'unit' => trim($request->input('unit.en'))
            ],
        ]);
        $variable->category_of_variable_id = $request->input('category');
        $variable->group_id = $request->input('group');

        if (!$variable->save()) {
            Log::error('Ошибка добавления переменной', $request->toArray());

            Session::flash('error', "Не удалось создать переменную. Пожалуйста попробуйте позже");

            return redirect()->back();
        }

        return redirect()->route('admin.facilities.variables.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variables\Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function show(Variable $variable)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variables\Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function edit(Variable $variable)
    {
        $categories = Category::all();
        $var_types = Variable::VAR_TYPES;
        $groups = Group::query()->with('variables.translations', 'facilityTypes.translations')->get();
        $route = route('admin.facilities.variables.update', $variable);

        return view('admin.variables.form',
            compact('variable', 'categories', 'var_types', 'groups', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VariableRequest $request
     * @param  \App\Models\Variables\Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function update(VariableRequest $request, Variable $variable)
    {
        try {
            $variable->slug = trim($request->input('name'));
            $variable->min_val = floatval($request->input('min_val'));
            $variable->max_val = floatval($request->input('max_val'));
            $variable->default_val = floatval($request->input('default_val'));
            $variable->type = strtoupper(trim($request->input('type')));
            $variable->category_of_variable_id = $request->input('category');
            $variable->group_id = $request->input('group');

            foreach (config('app.locales') as $locale) {
                $variable->translate($locale)->description = trim($request->input("description.$locale"));
                $variable->translate($locale)->unit = trim($request->input("unit.$locale"));
            }

            if (!$variable->save()) {
                Log::error('Произошла ошибка при редактировании переменной', [
                    'variable' => $variable->toArray(),
                    'request' => $request->except(['_token', '_method'])
                ]);

                Session::flash('error', "При редактировании переменной возникли проблемы. Пожалуйста попробуйте позже");

                return redirect()->back();
            }
        } catch (\Exception $e) {
            Log::error('Произошла ошибка при редактировании переменной', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'traace' => $e->getTrace(),
                'variable' => $variable->toArray(),
                'request' => $request->except(['_token', '_method'])
            ]);

            Session::flash('error', "При редактировании переменной возникли проблемы. Пожалуйста попробуйте позже");

            return redirect()->back();
        }

        return redirect()->route('admin.facilities.variables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variables\Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variable $variable)
    {
        try {
            if (!$variable->delete()) {
                Log::error('Не удалось удалить переменную', $variable->toArray());

                Session::flash('error', "Произошла ошибка при попытке удалить переменную. Пожалуйста попробуйте позже");
            }
        } catch (\Exception $e) {
            Log::error('Не удалось удалить переменную', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTrace(),
                'variable' => $variable->toArray()
            ]);

            Session::flash('error', "Произошла ошибка при попытке удалить переменную. Пожалуйста попробуйте позже");
        } finally {
            return redirect()->back();
        }
    }

    public function excelStore(Request $request)
    {
        $group = $request->input('group');
        $group = Group::query()->find($group);

        $tmpname = $request->file('file')->getPathname();
        $spreadsheet = IOFactory::load($tmpname);
        $worksheet = $spreadsheet->getActiveSheet();
        $categories = Category::all();
        $last_row = $worksheet->getHighestRow();

        $variables = new Collection();
        for ($i = 2; $i <= $last_row; $i++) {
            $name = $worksheet->getCell("A$i")->getValue();
            if (!$name) {
                continue;
            }

            $description_ru = $worksheet->getCell("B$i")->getValue();
            $description_en = $worksheet->getCell("C$i")->getValue();
            $unit_ru = $worksheet->getCell("D$i")->getValue();
            $unit_en = $worksheet->getCell("E$i")->getValue();
            $default_value = $worksheet->getCell("F$i")->getValue();
            $type = $worksheet->getCell("G$i")->getValue();
            $category = $worksheet->getCell("H$i")->getValue();

            $category = $categories->where('slug', strtolower($category))->first();

            $variable = new Variable([
                'ru' => ['description' => $description_ru, 'unit' => $unit_ru],
                'en' => ['description' => $description_en, 'unit' => $unit_en],
            ]);
            $variable->slug = trim($name);
            $variable->category_of_variable_id = $category->id;
            $variable->min_val = 0;
            $variable->max_val = 100000000;
            $variable->default_val = floatval($default_value);
            $variable->type = strtoupper($type);

            $variables->put($i, $variable);
        }

        $group->variables()->saveMany($variables);

        return redirect()->back();
    }
}
