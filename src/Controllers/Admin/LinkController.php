<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Link;
use Azuriom\Plugin\Staff\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LinkController extends Controller
{

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
            'links' => ['required', 'array'],
        ]);

        $links = $request->input('links');

        $linkPosition = 1;

        foreach ($links as $link) {
            $id = $link['id'];
            Link::whereKey($id)->update([
                'position' => $linkPosition++,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Azuriom\Plugin\Staff\Models\Link $link
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return Redirect::back()->with('success', trans('staff::admin.link.deleted'));
    }
}
