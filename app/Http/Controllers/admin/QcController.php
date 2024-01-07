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

class QcController extends Controller
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
                <a class="btn btn-primary btn-xs" href="' . route('qc.show', $item->id) . '">
                <i class="fas fa-edit"></i> &nbsp; Detail
                </a>
                ';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action'])
            ->make();
        }
        return view('pages.admin.qc.index');
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
            $query = Stock::where('project_id',$id)->where('stock_location','qc')->with('material')->latest()->get();

            return Datatables::of($query)
            // ->addColumn('action', function ($item) {
            //     $buttons='
            //     <a class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#modalPengajuan'.$item->material->id.'">
            //     <i class="fas fa-paper-plane"></i> &nbsp; Ajukan
            //     </a>';
            //     return $buttons;
            // })
            ->addColumn('link', function ($item) {
                return '<a class="btn btn-primary btn-xs copy" data-link="'.url('m/qc/').'/'.$item->id.'">
                <i class="far fa-copy"></i> &nbsp; Copy Link
                </a>';
            })
            ->addIndexColumn()
            ->removeColumn('id')
            ->rawColumns(['action','link'])
            ->make();
        }

        $stock = Stock::where('project_id',$id)->where('stock_location','qc')->with('material')->latest()->get();
        return view('pages.admin.qc.show',[
            'id'=>$id,
            'item'=>$stock
        ]);
    }


    public function history_stock(string $id)
    {
        if (request()->ajax()) {
            $query = HistoryStock::where('project_id', $id)->where('material_condition', 'NCP')->orWhere('material_condition','FG')->orWhere('material_condition','Repair')->with('material')->latest()->get();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
