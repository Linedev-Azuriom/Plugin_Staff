<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Staff;
use Azuriom\Plugin\Staff\Models\Tag;
use Azuriom\Plugin\Staff\Requests\TagRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function updateOrder(Request $request)
    {
        $this->validate($request, [
            'tags' => ['required', 'array'],
        ]);

        $position = 1;
        foreach ($request->input('tags') as $tag) {
            Tag::whereKey($tag['id'])->update(['position' => $position++]);
        }
    }

    public function store(TagRequest $request)
    {
        Tag::create($request->validated());

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.tag.created'));
    }

    public function edit(Tag $tag)
    {
        return view('staff::admin.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.tag.updated'));
    }

    public function destroy(Tag $tag)
    {
        Staff::all()->each(fn($staff) => $staff->tags()->detach($tag));
        $tag->delete();

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.tag.deleted'));
    }
}
