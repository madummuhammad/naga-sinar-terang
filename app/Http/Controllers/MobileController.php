<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\HistoryStock;
use App\Models\Material;
use App\Models\SuratJalan;
use App\Models\Production;
use App\Models\DeliveredStock;
use App\Models\Qc;
use Illuminate\Support\Facades\Auth;
use PDF;

class MobileController extends Controller
{
    public function index()
    {
        $stock_location=auth()->user()->hak_akses;

        if($stock_location=='production'){            
            $item = Stock::where('stock_location', $stock_location)
            ->with('material')
            ->whereIn('id', function ($subQuery) {
                $subQuery->select('stock_id')
                ->from('productions')
                ->distinct();
            })
            ->latest()
            ->get();
        } else {
            $item = Stock::where('stock_location', $stock_location)
            ->with('material')
            ->latest()
            ->get();
        }

        return view('pages.mobile.index',[
            'item'=>$item
        ]);
    }
    
    public function login()
    {
        return view('pages.mobile.login',[
            'title' => 'Login'
        ]);
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            if (Auth::user()->hak_akses !== 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('m');
            } else {
                Auth::logout();
            }
        }

        return back()->with('loginError', 'Login Gagal! Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/m/login');
    }

    public function accept($id)
    {
        Stock::where('id',$id)->update(['status'=>1]);
        return back()
        ->with('success','Data berhasil di Accept');
    }

    public function production($id)
    {
        $material=Stock::where('id',$id)->where('stock_location','production')->with('material')->first();
        return view('pages.mobile.production.index',[
            'item'=>$material
        ]);
    }

    public function ajukan_production(Request $request,$id)
    {
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

        $validatedData['stock_location']='qc';
        $validatedData['user_id']=auth()->user()->id;
        $validatedData['project_id']=$request->project_id;

        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('public/assets/foto');
        }

        $material=Material::findOrFail($validatedData['material_id']);
        $stock=Stock::where('stock_location','production')->where('id',$id)->first();
        $currentQty=$stock->qty;
        $validatedData['qty'];
        $qty=$currentQty-$validatedData['qty'];
        $stock->update(['qty'=>$qty]);
        $proses=false;
        if($qty<=0){
            $proses=true;
            $stock->delete();
        }

        $link=Stock::create($validatedData);
        $this->history($validatedData);
        $this->insert_production($validatedData,$id,$proses);
        return back()
        ->with('success','Sukses! Data Berhasil Diajukan')
        ->with('link',url('m/qc').'/'.$link->id);
    }

    public function history($validatedData)
    {
        HistoryStock::create($validatedData);
    }

    public function insert_production($validatedData,$id,$proses)
    {
        $production=Production::where('stock_id',$id)->first();

        $qty=$production->qty+$validatedData['qty'];
        $status=$production->proses;
        if($proses){
            $status='Finish';
        }

        Production::where('stock_id',$id)->update(['qty'=>$qty,'proses'=>$status]);
    }

    public function qc($id)
    {
        $material=Stock::where('id',$id)->where('stock_location','qc')->with('material')->first();
        return view('pages.mobile.qc.index',[
            'item'=>$material
        ]);
    }

    public function ajukan_ncp(Request $request,$id)
    {
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

        $validatedData['stock_location']='ncp';
        $validatedData['material_condition']='NCP';
        $validatedData['user_id']=auth()->user()->id;
        $validatedData['project_id']=$request->project_id;

        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('public/assets/foto');
        }

        $material=Material::findOrFail($validatedData['material_id']);
        $stock=Stock::where('stock_location','qc')->where('id',$id)->first();
        $currentQty=$stock->qty;
        $qty=$currentQty-$validatedData['qty'];
        $stock->update(['qty'=>$qty]);

        if($qty<=0){
            $stock->delete();
        }

        $link=Stock::create($validatedData);
        $this->history($validatedData);
        $this->report_qc($validatedData,$id,'NCP');
        return back()
        ->with('success','Sukses! Data Berhasil Diajukan');
    }

    public function report_qc($validatedData,$id,$status)
    {
        $qc=Qc::where('stock_id',$id)->where('user_id',auth()->user()->id)->first();
        if($status=='NCP'){
            if($qc){
                $qty=$qc->ncp+$validatedData['qty'];
            } else {
                $qty=$validatedData['qty'];
            }
            $data=[
                'ncp'=>$qty,
                'stock_id'=>$id,
                'user_id'=>auth()->user()->id,
                'ncp_description'=>$validatedData['description']
            ];

        }

        if($status=='FG'){
         if($qc){
            $qty=$qc->fg+$validatedData['qty'];
        } else {
            $qty=$validatedData['qty'];
        }
        $data=[
            'fg'=>$qty,
            'stock_id'=>$id,
            'user_id'=>auth()->user()->id,
            'fg_description'=>$validatedData['description']
        ];

    }

    if($status=='Repair'){
       if($qc){
        $qty=$qc->repair+$validatedData['qty'];
    } else {
        $qty=$validatedData['qty'];
    }
    $data=[
        'repair'=>$qty,
        'stock_id'=>$id,
        'user_id'=>auth()->user()->id,
        'repair_description'=>$validatedData['description']
    ];

}

$qc=Qc::where('stock_id',$id)->where('user_id',auth()->user()->id)->first();

if($qc){
    Qc::where('stock_id',$id)->where('user_id',auth()->user()->id)->update($data);
} else {
    Qc::create($data);
}
}

public function ajukan_fg(Request $request,$id)
{
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

    $validatedData['stock_location']='delivery';
    $validatedData['material_condition']='FG';
    $validatedData['user_id']=auth()->user()->id;
    $validatedData['project_id']=$request->project_id;

    if($request->file('foto')){
        $validatedData['foto'] = $request->file('foto')->store('public/assets/foto');
    }

    $material=Material::findOrFail($validatedData['material_id']);
    $stock=Stock::where('stock_location','qc')->where('id',$id)->first();
    $currentQty=$stock->qty;
    $qty=$currentQty-$validatedData['qty'];
    $stock->update(['qty'=>$qty]);

    if($qty<=0){
        $stock->delete();
    }

    $link=Stock::create($validatedData);
    $this->history($validatedData);
    $this->report_qc($validatedData,$id,'FG');
    return back()
    ->with('success','Sukses! Data Berhasil Diajukan')
    ->with('link',url('m/delivery').'/'.$link->id);
}

public function ajukan_repair(Request $request,$id)
{
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
    $validatedData['material_condition']='Repair';
    $validatedData['user_id']=auth()->user()->id;
    $validatedData['project_id']=$request->project_id;

    if($request->file('foto')){
        $validatedData['foto'] = $request->file('foto')->store('public/assets/foto');
    }

    $material=Material::findOrFail($validatedData['material_id']);
    $stock=Stock::where('stock_location','qc')->where('id',$id)->first();
    $currentQty=$stock->qty;
    $qty=$currentQty-$validatedData['qty'];
    $stock->update(['qty'=>$qty]);

    if($qty<=0){
        $stock->delete();
    }

    $link=Stock::create($validatedData);
    $this->history($validatedData);
    $this->report_qc($validatedData,$id,'Repair');
    return back()
    ->with('success','Sukses! Data Berhasil Diajukan')
    ->with('link',url('m/production').'/'.$link->id);
}

public function delivery($id)
{
    $material=Stock::where('id',$id)->where('stock_location','delivery')->with('material')->first();
    return view('pages.mobile.delivery.index',[
        'item'=>$material
    ]);
}

public function masukan(Request $request,$id)
{
    $validatedData = $request->validate([
        'qty' => 'required|numeric',
        'material_id' => 'required|exists:materials,id',
    ], [
        'qty.numeric' => 'Qty harus berupa angka',
        'material_id.exists' => 'Material tidak valid',
    ]);

    $validatedData = $request->validate([
        'qty' => [
            'required',
            'numeric',
            function ($attribute, $value, $fail) {
                $material = Stock::find(request('stock_id'));
                if ($material && $value > $material->qty) {
                    $fail('Qty tidak boleh melebihi jumlah yang ada!');
                }
            },
        ],
        'material_id' => 'required|exists:materials,id',
    ], [
        'qty.numeric' => 'Qty harus berupa angka',
        'material_id.exists' => 'Material tidak valid',
    ]);

    $validatedData['stock_location']='delivered';
    $validatedData['material_condition']=null;
    $validatedData['user_id']=auth()->user()->id;
    $validatedData['project_id']=$request->project_id;

    $stock=Stock::where('stock_location','delivery')->where('id',$id)->first();
    $currentQty=$stock->qty;
    $qty=$currentQty-$validatedData['qty'];
    $stock->update(['qty'=>$qty]);

    if($qty<=0){
        $stock->delete();
    }

    $link=Stock::create($validatedData);
    $suratjalanexists=SuratJalan::where('status','pending')->get();
    if ($suratjalanexists->count() == 0) {
        SuratJalan::create([
            'no_sj' => null,
            'status' => 'pending'
        ]);

        $suratJalanId = SuratJalan::latest()->first()->id;
    } else {
        $suratJalanId = $suratjalanexists->first()->id;
    }

    DeliveredStock::create([
        'stock_id' => $link->id,
        'surat_jalan_id' => $suratJalanId,
    ]);

    $this->history($validatedData);
    return back()
    ->with('success','Sukses! Data Berhasil Dimasukan ke Surat Jalan')
    ->with('link',url('m/production').'/'.$link->id);
}

public function surat_jalan()
{
    $surat_jalan=SuratJalan::where('status','pending')->with('delivered_stock.stock.material')->first();
    return view('pages.mobile.delivery.surat-jalan',[
        'item'=>$surat_jalan
    ]);
}

public function unduh_surat_jalan(Request $request)
{
   $validatedData=$request->validate([
    'no_sj'=>'required',
    'no_doc'=>'required',
    'to'=>"required",
    'address'=>'required',
    'phone'=>'required|numeric',
    'date'=>'required'
]);
   $sj=SuratJalan::where('status','pending')->with('delivered_stock.stock.material');

   $item=$sj->first();

   if(!$item){
    return back()->with('error','Surat Jalan sudah di unduh');
}

$validatedData['status']='delivered';
$sj->update($validatedData);

$pdf = PDF::loadview('pages.mobile.delivery.surat-jalan-pdf',[
    'item'=>$item
]);
return $pdf->download('surat-jalan.pdf');
}
}
