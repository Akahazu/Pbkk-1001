<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(Request $request): View
    {
        $dosens = Dosen::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dosen.index', compact('dosens'));
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        $dosen->user?->delete();
        $dosen->delete();

        return redirect()->route('admin.dosen.index')
            ->with('success', "Dosen \"{$dosen->nama}\" berhasil dihapus.");
    }
}
