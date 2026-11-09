<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsistenDosen;
use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AsistenDosenController extends Controller
{
    public function index(Request $request): View
    {
        $asdos = AsistenDosen::query()
            ->with('dosen')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%")
                        ->orWhere('nrp', 'like', "%{$search}%");
                });
            })
            ->when($request->dosen_id, fn ($q, $id) => $q->where('dosen_id', $id))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $dosens = Dosen::orderBy('nama')->get();

        return view('admin.asdos.index', compact('asdos', 'dosens'));
    }

    public function destroy(AsistenDosen $asdos): RedirectResponse
    {
        $asdos->user?->delete();
        $asdos->delete();

        return redirect()->route('admin.asdos.index')
            ->with('success', "Asisten Dosen \"{$asdos->nama}\" berhasil dihapus.");
    }
}
