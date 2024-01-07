<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::latest()->get();

            return Datatables::of($query)
            ->addColumn('action', function ($item) {
                return '
                <a class="btn btn-primary btn-xs" href="' . route('user.edit', $item->id) . '">
                <i class="fas fa-edit"></i> &nbsp; Ubah
                </a>
                <form action="' . route('user.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
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
        return view('pages.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'hak_akses' => 'required',
            'password' => 'required|min:5|max:255',
        ]);

        // return request();

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()
        ->route('user.index')
        ->with('success', 'Sukses! Data Pengguna Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::findOrFail($id);
        return view('pages.admin.user.edit',[
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => [
                'required',
                Rule::unique('users')->ignore($item->id),
            ],
            'hak_akses' => 'required',
            'password' => 'nullable|min:5|max:255',
        ]);

        if ($request->password!==null) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $item->update($validatedData);

        return redirect()
        ->route('user.index')
        ->with('success', 'Sukses! Data Pengguna telah diperbarui');
    }


    public function destroy(string $id)
    {
        $item = User::findorFail($id);

        $item->delete();

        return redirect()
        ->route('user.index')
        ->with('success', 'Sukses! Data Pengguna telah dihapus');
    }
}
