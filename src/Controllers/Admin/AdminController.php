<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Shop\Models\Category;
use Azuriom\Plugin\Shop\Requests\CategoryRequest;
use Azuriom\Plugin\Staff\Models\Link;
use Azuriom\Plugin\Staff\Models\Staff;
use Azuriom\Plugin\Staff\Models\Tag;
use Azuriom\Plugin\Staff\Requests\StaffRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::all();
        $tags = Tag::all();
        return view('staff::admin.staff.index', compact('staffs', "tags"));
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
     * @param \Azuriom\Plugin\staff\Requests\StaffRequest $staffRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StaffRequest $staffRequest)
    {
        $staff = Staff::create($staffRequest->validated());

        $staff->tags()->sync($staffRequest->tags);
        $staff->save();

        foreach ($staffRequest->input('link') as $link) {
            Link::create([
                'name' => $link['name'],
                'url' => $link['url'],
                'icon' => $link['icon'],
                'staff_id' => $staff->id
            ]);
        }

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Azuriom\Plugin\Satff\Models\Staff $staff
     */
    public function edit(Staff $staff)
    {
        return view('staff::admin.staff.edit', [
            'tags' => Tag::all(),
            'staff' => $staff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Azuriom\Plugin\Shop\Requests\CategoryRequest $request
     * @param \Azuriom\Plugin\Shop\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
//        $category->update($request->validated());
//
//        return redirect()->route('shop.admin.packages.index')
//            ->with('success', trans('shop::admin.categories.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Azuriom\Plugin\Staff\Models\Staff $staff
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('shop.admin.packages.index')
            ->with('success', trans('shop::admin.categories.status.deleted'));
    }
}
