<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Models\Page;
use App\Classes\Response;
use App\Repositories\Pages;
use Illuminate\Http\Request;
use App\Http\Requests\PagesRequest;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    private $pages;

    public function __construct(Pages $pages)
    {
        $this->pages = $pages;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::success('', $this->pages->all()->load('post'));
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
    public function store(PagesRequest $request)
    {
        $page = $this->pages->create($request->only(
            $this->pages->getFillable()
        ));

        if ($page instanceof Page) {
            return Response::success('با موفقیت ثبت شده', $page->load('post'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PagesRequest $request, Page $page)
    {
        $page = $this->pages->update($page, $request->only(
            $this->pages->getFillable()
        ));

        if ($page instanceof Page) {
            return Response::success('با موفقیت ویرایش شده!', $page->load('post'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return Response::success('با موفقیت ویرایش شده :)');
    }
}
