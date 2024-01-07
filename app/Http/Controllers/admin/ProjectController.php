<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Project::latest()->get();

            return Datatables::of($query)
            ->addColumn('action', function ($item) {
                return '
                <a class="btn btn-primary btn-xs" href="' . route('project.edit', $item->id) . '">
                <i class="fas fa-edit"></i> &nbsp; Ubah
                </a>
                <form action="' . route('project.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
                ' . method_field('delete') . csrf_field() . '
                <button class="btn btn-danger btn-xs">
                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                </button>
                </form>
                ';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action','name'])
            ->make();
        }
        return view('pages.admin.project.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.project.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_po' => 'required|max:255',
            'customer' => 'required|max:255',
        ]);
        Project::create($validatedData);

        return redirect()
        ->route('project.index')
        ->with('success', 'Sukses! Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Project::findOrFail($id);
        return view('pages.admin.project.edit',[
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Project::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $item->update($validatedData);

        return redirect()
        ->route('project.index')
        ->with('success', 'Sukses! Data telah diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Project::findorFail($id);

        $item->delete();

        return redirect()
        ->route('project.index')
        ->with('success', 'Sukses! Data telah dihapus');
    }
}
