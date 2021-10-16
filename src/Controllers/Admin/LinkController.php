<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Link;
use Illuminate\Support\Facades\Redirect;

class LinkController extends Controller
{

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
