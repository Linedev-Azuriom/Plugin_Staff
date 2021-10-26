<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Link;
use Azuriom\Plugin\Staff\Models\Setting;
use Azuriom\Plugin\Staff\Models\Staff;
use Azuriom\Plugin\Staff\Models\Tag;
use Azuriom\Plugin\Staff\Requests\StaffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    /**
     * The storage path for uploaded images.
     *
     * @var string
     */
    protected $imagesPath = 'staff';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $setting = Setting::first();
        $staffs = Staff::orderBy('position')->get();
        $tags = Tag::orderBy('position')->get();
        $pendingId = old('pending_id', Str::uuid());
        return view('staff::admin.staff.index', compact('staffs', "tags", 'pendingId', 'setting'));
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
            'staffs' => ['required', 'array'],
        ]);

        $staffs = $request->input('staffs');

        $staffPosition = 1;

        foreach ($staffs as $staff) {
            $id = $staff['id'];
            Staff::whereKey($id)->update([
                'position' => $staffPosition++,
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
     * @param \Azuriom\Plugin\staff\Requests\StaffRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $staff = Staff::create(Arr::except($request->validated(), 'image'));


        if ($request->hasFile('image')) {
            $staff->storeImage($request->file('image'), true);
        }

        $staff->persistPendingAttachments($request->input('pending_id'));

        $staff->tags()->sync($request->tags);

        foreach ($request->input('link') as $link) {
            if (!empty($link['name']) && !empty($link['url']) && !empty($link['icon'])) {
                Link::create([
                    'name'     => $link['name'],
                    'url'      => $link['url'],
                    'icon'     => $link['icon'],
                    'staff_id' => $staff->id
                ]);
            }
        }

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.staff.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Azuriom\Plugin\Staff\Models\Staff $staff
     */
    public function edit(Staff $staff)
    {
        return view('staff::admin.staff.edit', [
            'tags'  => Tag::all(),
            'staff' => $staff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Azuriom\Plugin\Staff\Requests\StaffRequest $request
     * @param \Azuriom\Plugin\Staff\Models\Staff          $category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        if ($request->hasFile('image')) {
            $staff->storeImage($request->file('image'));
        }

        $staff->update(Arr::except($request->validated(), 'image'));

        $staff->tags()->sync($request->tags);

        foreach ($request->input('link') as $link) {
            if (!empty($link['name']) && !empty($link['url']) && !empty($link['icon'])) {
                Link::updateOrCreate([
                    'name'     => $link['name'],
                    'url'      => $link['url'],
                    'icon'     => $link['icon'],
                    'staff_id' => $staff->id
                ]);
            }
        }

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.staff.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Azuriom\Plugin\Staff\Models\Staff $staff
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Staff $staff)
    {
        foreach ($staff->links as $link) {
            $link->delete();
        }
        $staff->delete();

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.staff.deleted'));
    }
}
