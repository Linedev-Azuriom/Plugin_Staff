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
        $tags = Tag::all();
        return view('staff::admin.tags.index', compact('tags'));
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
     * @param \Azuriom\Plugin\Staff\Requests\TagRequest $tagRequest
     *
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
    public function edit(Tag $tag)
    {
        return view('staff::admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        dump($request);
        die();
        $tag->update($request->validated());
        return redirect()->route('staff.admin.tags.index')
            ->with('success', trans('staff::admin.tags.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Azuriom\Plugin\Staff\Models\Tag $tag
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {

        $tag->delete();

        return redirect()->route('staff.admin.tags.index')
            ->with('success', trans('staff::admin.tags.deleted'));
    }
}
