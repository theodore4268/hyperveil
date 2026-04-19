<?php

namespace Pterodactyl\Http\Controllers\Admin\Extensions\hyperveil;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Pterodactyl\Http\Controllers\Controller;

class hyperveilExtensionController extends Controller
{
    /**
     * Show the HyperVeil admin page.
     */
    public function index(): View
    {
        $announcement = DB::table('hyperveil_announcement')->first();

        return view('admin.extensions.hyperveil.index', [
            'announcement' => $announcement,
        ]);
    }

    /**
     * Save announcement settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'message'   => 'required|string|max:500',
            'type'      => 'required|in:info,warning,danger,success',
            'link'      => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:60',
        ]);

        DB::table('hyperveil_announcement')->where('id', 1)->update([
            'visible'    => $request->has('visible') ? true : false,
            'type'       => $request->input('type'),
            'message'    => $request->input('message'),
            'link'       => $request->input('link') ?: null,
            'link_text'  => $request->input('link_text') ?: null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.extensions.hyperveil.index')
            ->with('success', 'Announcement updated successfully.');
    }
}
