<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Project;
use App\Models\Production;
use App\Models\Material;

class DashboardController extends Controller
{
    public function index()
    {
        $material_in = Material::get()->sum('qty');
        $fg = Stock::where('stock_location', 'delivery')->sum('qty');
        $delivered = Stock::where('stock_location', 'delivered')->sum('qty');

        $item=Production::with('material')->orderBy('created_at','DESC')->get();


        return view('pages.production.dashboard', [
            'material_in' => $material_in,
            'fg' => $fg,
            'delivered' => $delivered,
            'item' => $item,
        ]);
    }
}
