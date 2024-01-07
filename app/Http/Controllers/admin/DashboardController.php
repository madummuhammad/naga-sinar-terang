<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Project;
use App\Models\Material;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $material_in = Material::get()->sum('qty');
        $fg = Stock::where('stock_location', 'delivery')->sum('qty');
        $delivered = Stock::where('stock_location', 'delivered')->sum('qty');

        $projects = Project::with('material.qc', 'material.production', 'material.receiver', 'material.ncp', 'material.fg')->get();

// Menambahkan hasil perhitungan ke dalam array $project
        $projects = $projects->map(function ($project) {
    // Inisialisasi jumlah produksi dan QC untuk proyek tertentu
            $project->material->each(function ($material) {
                $material->productionQtySum = $material->production->sum('qty');
                $material->qcQtySum = $material->qc->sum('qty');
                $material->receiverQtySum = $material->receiver->sum('qty');
                $material->ncpQtySum = $material->ncp->sum('qty');
                $material->fgQtySum = $material->fg->sum('qty');
            });

            return $project;
        });

        return view('pages.admin.dashboard', [
            'material_in' => $material_in,
            'fg' => $fg,
            'delivered' => $delivered,
            'project' => $projects,
        ]);

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
        //
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
