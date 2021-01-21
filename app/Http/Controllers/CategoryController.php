<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::query()->orderByTranslation('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $params = [
            'slug'      => strtolower(preg_replace('/\s+/', '_', $request->input('name_en'))),
            'parent_id' => $request->input('parent_category'),
            'en'        => ['name' => $request->input('name_en')],
            'ru'        => ['name' => $request->input('name_ru')],
        ];

        if (Category::create($params)) {
            Session::flash('message', __('knowledgebase.CategoryAdded'));
        } else {
            Session::flash('message', __('knowledgebase.errors.storeCategory'));
            Log::error('Не удалось создать категорию', $params);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            if (!$category->delete()) {
                Session::flash('error', __('knowledgebase.errors.deleteCategory'));

                Log::error("Не удалось удалить категорию", ['category' => $category->toArray()]);
            }
        } catch (\Exception $e) {
            Session::flash('error', __('knowledgebase.errors.deleteCategory'));

            Log::error("Не удалось удалить категорию", [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'trace'    => $e->getTrace(),
                'category' => $category->toArray()
            ]);
        }

        return back();
    }
}
