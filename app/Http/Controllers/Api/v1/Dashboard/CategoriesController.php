<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Models\Category;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{

    private $categories;

    public function __construct(CategoriesRepository $categories)
    {
        $this->categories = $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::success('', $this->categories->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        $category = $this->categories->create($request->only(
            $this->categories->getFillable()
        ));

        return Response::success('created successfully', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, Category $category)
    {
        if (! $request->in_home_page) {
            $request->request->add(['in_home_page' => false]);
        }

        $category = $this->categories->update($category, $request->only(
            $this->categories->getFillable()
        ));

        return Response::success('edited successfully', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return Response::success('deleted successfully');
    }
}
