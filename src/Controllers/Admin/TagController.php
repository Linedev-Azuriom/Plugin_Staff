<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Staff;
use Azuriom\Plugin\Staff\Models\Tag;
use Azuriom\Plugin\Staff\Requests\TagRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('position')->get();
        return view('staff::admin.tags.index', compact('tags'));
    }

    /**
     * Update the order of the resources.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateOrder(Request $request)
    {
        $this->validate($request, [
            'tags' => ['required', 'array'],
        ]);

        $tags = $request->input('tags');

        $tagPosition = 1;

        foreach ($tags as $tag) {
            $id = $tag['id'];
            Tag::whereKey($id)->update([
                'position' => $tagPosition++,
            ]);
        }
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
            ->with('success', trans('staff::admin.tag.created'));
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
        $tag->update($request->validated());
        return redirect()->route('staff.admin.tags.index')
            ->with('success', trans('staff::admin.tag.updated'));
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
        $staffs = Staff::all();
        foreach ($staffs as $staff) {
            $staff->tags()->detach($tag);
        }
        $tag->delete();

        return redirect()->route('staff.admin.tags.index')
            ->with('success', trans('staff::admin.tag.deleted'));
    }
}
