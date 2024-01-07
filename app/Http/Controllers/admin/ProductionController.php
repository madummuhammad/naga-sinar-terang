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

class ProductionController extends Controller
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
                <a class="btn btn-primary btn-xs" href="' . route('production.show', $item->id) . '">
                <i class="fas fa-edit"></i> &nbsp; Detail
                </a>
                ';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action'])
            ->make();
        }
        return view('pages.admin.production.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (request()->ajax()) {
            $query = Stock::where('project_id',$id)->where('stock_location','production')->with('material')->latest()->get();

            return Datatables::of($query)
            // ->addColumn('action', function ($item) {
            //     $buttons='
            //     <a class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#modalPengajuan'.$item->material->id.'">
            //     <i class="fas fa-paper-plane"></i> &nbsp; Ajukan
            //     </a>';
            //     return $buttons;
            // })
            ->addColumn('link', function ($item) {
                return '<a class="btn btn-primary btn-xs copy" data-link="'.url('m/production/').'/'.$item->id.'">
                <i class="far fa-copy"></i> &nbsp; Copy Link
                </a>';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action','link'])
            ->make();
        }

        $stock = Stock::where('project_id',$id)->where('stock_location','production')->with('material')->latest()->get();
        return view('pages.admin.production.show',[
            'id'=>$id,
            'item'=>$stock
        ]);
    }

    public function history_stock(string $id)
    {
        if (request()->ajax()) {
            $query = HistoryStock::where('project_id', $id)->where('stock_location', 'qc')->with('material')->latest()->get();
            return Datatables::of($query)
            ->addIndexColumn()
            ->removeColumn('id')
            ->make();
        }
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
        $validatedData=$request->validate([
            'project_id'=>'required',
            'qty'=>'required|numeric'
        ]);

        Stock::updateOrCreate(
            [
                'material_id' => $id,
                'divisi' => 'production'
            ],
            [
                'user_id' => auth()->user()->id,
                'qty' => $validatedData['qty'] ?? 0
            ]
        );

        return redirect()
        ->route('production.show',$validatedData['project_id'])
        ->with('success','Success! Qty out berhasil di ubah');
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
                'foto' => 'required|mimes:jpg,png,jpeg|file',
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
                'foto' => 'required',
                'description' => 'required',
            ], [
                'qty.numeric' => 'Qty harus berupa angka',
                'material_id.exists' => 'Material tidak valid',
            ]);

            $validatedData['stock_location']='qc';
            $validatedData['user_id']=auth()->user()->id;
            $validatedData['project_id']=$request->project_id;

            if($request->file('foto')){
                $validatedData['foto'] = $request->file('foto')->store('assets/foto');
            }
            
            $stock=Stock::where('stock_location','production')->where('material_id',$validatedData['material_id'])->first();
            $currentQty=$stock->qty;
            $qty=$currentQty-$validatedData['qty'];
            $stock->update(['qty'=>$qty]);

            if($qty<=0){
                $stock->delete();
            }

            Stock::create($validatedData);
        }
        return redirect()
        ->route('production.show',$project_id)
        ->with('success','Sukses! Data Berhasil Diajukan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
