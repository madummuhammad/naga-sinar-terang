<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Models\Project;
use App\Models\Material;
use App\Models\Stock;
use App\Models\HistoryStock;
use App\Models\Production;

class ProductionInsert extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query =Stock::where('stock_location', 'production')
            ->with('material')
            ->where(function ($query) {
                $query->whereNotIn('id', function ($subQuery) {
                    $subQuery->select('stock_id')
                    ->from('productions')
                    ->whereRaw('productions.stock_id = stocks.id');
                });
            })
            ->latest()
            ->get();


            return Datatables::of($query)
            ->addColumn('link', function ($query) {
                return '<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#insert'.$query->id.'">
                <i class="far fa-copy"></i> &nbsp; Insert
                </a>';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action','link'])
            ->make();
        }

        $stock = Stock::where('stock_location','production')->with('material')->latest()->get();
        return view('pages.production.insert.index',[
            'item'=>$stock
        ]);
    }

    public function store(Request $request,$id)
    {
       $validatedData=$request->validate([
          "name"=>'required',
          "shift"=>'required',
          "start_time"=>'required',
          "finish_time"=>'required',
          "machine"=>'required',
          "proses"=> "required",
          'production_target' => [
            'required',
            'numeric',
            function ($attribute, $value, $fail) use ($id) {
                $material = Stock::find($id);
                if ($material && $value > $material->qty) {
                    $fail('Qty tidak boleh melebihi jumlah yang ada.');
                }
            },
        ],
        "description"=>'required'
    ]);

       $stock=Stock::where('id',$id)->first();
       $validatedData['user_id']=auth()->user()->id;
       $validatedData['stock_id']=$id;
       $validatedData['material_id']=$stock->material_id;

       Production::create($validatedData);

       return back()->with('success','Success! Data berhasil di insert');
   }
}
