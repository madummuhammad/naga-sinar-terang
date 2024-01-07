<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Models\Project;
use App\Models\Material;
use App\Models\Stock;
use App\Models\HistoryStock;

class ReceiverController extends Controller
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
                <a class="btn btn-primary btn-xs" href="' . route('receiver.show', $item->id) . '">
                <i class="fas fa-edit"></i> &nbsp; Detail
                </a>
                ';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action','link'])
            ->make();
        }
        return view('pages.admin.receiver.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required',
            'date_come' => 'required',
            'part_no' => 'required',
            'name' => 'required',
            'lot' => 'required',
            'qty' => 'required|numeric',
            'satuan' => 'required',
            'plant' => 'required',
            'lokasi_simpan' => 'required',
            'no_sj' => 'required',
            'no_mobil' => 'required',
            'driver' => 'required',
            'keterangan' => 'required',
            'category' => 'required',
        ]);

        $material=Material::create($validatedData);
        Stock::create([
            'material_id'=>$material->id,
            'project_id'=>$validatedData['project_id'],
            'qty'=>$validatedData['qty'],
            'user_id'=>auth()->user()->id,
            'description'=>'Created by receiver',
            'foto'=>null,
            'stock_location'=>'receiver'
        ]);

        return redirect()
        ->route('receiver.show',$validatedData['project_id'])
        ->with('success', 'Sukses! Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (request()->ajax()) {
            $query = Stock::where('project_id',$id)->where('stock_location','receiver')->with('material')->latest()->get();
            return Datatables::of($query)
            ->addColumn('action', function ($item) {
                $buttons='
                <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#updateModal'.$item->material->id.'">
                <i class="fas fa-edit"></i> &nbsp; Ubah
                </a>
                <a class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#modalPengajuan'.$item->material->id.'">
                <i class="fas fa-paper-plane"></i> &nbsp; Ajukan
                </a>
                <form action="' . route('receiver.destroy', $item->material->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                ' . method_field('delete') . csrf_field() . '
                <button class="btn btn-danger btn-xs">
                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                </button>
                </form>';
                return $buttons;
            })
            ->addColumn('link', function ($item) {
                return '<a class="btn btn-primary btn-xs copy" data-link="'.url('m/receiver/').'/'.$item->id.'">
                <i class="far fa-copy"></i> &nbsp; Copy Link
                </a>';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action','link'])
            ->make();
        }

        $stock=Stock::where('project_id',$id)->where('stock_location','receiver')->with('material')->latest()->get();
        return view('pages.admin.receiver.show',[
            'id'=>$id,
            'item'=>$stock
        ]);
    }

    public function history_stock(string $id)
    {
        if (request()->ajax()) {
            $query = HistoryStock::where('project_id', $id)
            ->where('stock_location', 'production')
            ->where('material_condition', null) 
            ->with('material')
            ->latest()
            ->get();
            return Datatables::of($query)
            ->addIndexColumn()
            ->removeColumn('id')
            ->make();
        }
    }

    public function ajukan(Request $request)
    {
        $project_id=$request->project_id;

        if($request->type && $request->type=='all'){            
            $material=Material::where('project_id',$project_id);

            foreach ($material->get() as $key => $value) {
                Stock::create([
                    'material_id'=>$value->id,
                    'qty'=>$value->qty,
                    'user_id'=>auth()->user()->id
                ]);
            }

        } else {
            $validatedData = $request->validate([
                'qty' => 'required|numeric',
                'material_id' => 'required|exists:materials,id',
                'foto' => 'mimes:jpg,png,jpeg|file',
                'description' => 'required',
            ], [
                'qty.numeric' => 'Qty harus berupa angka',
                'material_id.exists' => 'Material tidak valid',
            ]);

            $validatedData = $request->validate([
                'qty' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) {
                        $material = Material::find(request('material_id'));
                        if ($material && $value > $material->qty) {
                            $fail('Qty tidak boleh melebihi jumlah yang ada di tabel material.');
                        }
                    },
                ],
                'material_id' => 'required|exists:materials,id',
                'description' => 'required',
            ], [
                'qty.numeric' => 'Qty harus berupa angka',
                'material_id.exists' => 'Material tidak valid',
            ]);

            $validatedData['stock_location']='production';
            $validatedData['user_id']=auth()->user()->id;
            $validatedData['project_id']=$request->project_id;

            if($request->file('foto')){
                $validatedData['foto'] = $request->file('foto')->store('public/assets/foto');
            }

            $material=Material::findOrFail($validatedData['material_id']);
            $stock=Stock::where('stock_location','receiver')->where('material_id',$material->id)->first();
            $currentQty=$stock->qty;
            $qty=$currentQty-$validatedData['qty'];
            $stock->update(['qty'=>$qty]);

            if($qty<=0){
                $stock->delete();
            }

            Stock::create($validatedData);
        }

        $this->history($validatedData);
        return redirect()
        ->route('receiver.show',$project_id)
        ->with('success','Sukses! Data Berhasil Diajukan');
    }

    public function history($validatedData)
    {
        HistoryStock::create($validatedData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $item = Material::findOrFail($id);
        $validatedData = $request->validate([
            'project_id' => 'required',
            'part_no' => 'required',
            'name' => 'required',
            'dimensi' => 'required',
            'lot' => 'required',
            'qty' => 'required|numeric',
            'satuan' => 'required',
            'plant' => 'required',
            'lokasi_simpan' => 'nullable',
            'dari' => 'required',
            'no_sj' => 'required',
            'total_box' => 'nullable|numeric',
            'no_mobil' => 'nullable',
            'driver' => 'nullable',
            'keterangan' => 'nullable',
            'category' => 'required',
        ]);

        $item->update($validatedData);

        return redirect()
        ->route('receiver.show',$validatedData['project_id'])
        ->with('success', 'Sukses! Data telah diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Material::findorFail($id);

        $item->delete();

        return redirect()
        ->route('receiver.show',$item->project_id)
        ->with('success', 'Sukses! Data telah dihapus');
    }
}
