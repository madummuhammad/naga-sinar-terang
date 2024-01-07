<?php

namespace App\Http\Controllers\qc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Project;
use App\Models\Qc;
use App\Models\Material;

class DashboardController extends Controller
{
    public function index()
    {
        $material_in = Material::get()->sum('qty');
        $fg = Stock::where('stock_location', 'delivery')->sum('qty');
        $delivered = Stock::where('stock_location', 'delivered')->sum('qty');

        $item=Qc::with('stock.material','user','stock.project')->orderBy('created_at','DESC')->get();


        return view('pages.qc.dashboard', [
            'material_in' => $material_in,
            'fg' => $fg,
            'delivered' => $delivered,
            'item' => $item,
        ]);
    }
}
