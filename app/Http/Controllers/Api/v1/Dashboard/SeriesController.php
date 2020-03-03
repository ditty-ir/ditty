<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use Exception;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesRequest;
use App\Repositories\Series as Repository;
use Illuminate\Support\Facades\Cache;

class SeriesController extends Controller
{

    private $series;

    public function __construct(Repository $series)
    {
        $this->series = $series;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->success('', $this->series->all()->load('posts.info'));
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
    public function store(SeriesRequest $request)
    {
        try {
            DB::beginTransaction();
            $item = $this->series->create($request->all());
            $this->series->attachPosts($item, $request->post_ids);
            DB::commit();

            return response()->success('Series created successfully.', $item->load('posts.info'));
        } catch(Exception $e) {
            DB::rollBack();
            return response()->error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function edit(Series $series)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(SeriesRequest $request, Series $series)
    {
        try {
            DB::beginTransaction();
            $series = $this->series->update($series, $request->all());
            $this->series->syncPosts($series, $request->post_ids);
            Cache::forget('series_' . $series->id);
            DB::commit();

            return response()->success('Series updated successfully.', $series->load('posts.info'));
        } catch(Exception $e) {
            DB::rollBack();
            return response()->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series $series)
    {
        try {
            DB::beginTransaction();
            $series->delete();
            $this->series->detachPosts($series);
            Cache::forget('series_' . $series->id);
            DB::commit();

            return response()->success('Series deleted.');
        } catch(Exception $e) {
            DB::rollBack();
            return response()->error($e->getMessage());
        }
    }
}
