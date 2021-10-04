<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Tag;
use Azuriom\Plugin\Staff\Requests\TagRequest;
use Illuminate\Support\Facades\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff::admin.tags.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Plugin\Staff\Requests\TagRequest  $tagRequest
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $tagRequest)
    {
        Tag::create($tagRequest->validated());

        return redirect()->route('staff.admin.tags.index')
            ->with('success', trans('staff::admin.tags.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Response $response, Tag $tag)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\Staff\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
    }
}
