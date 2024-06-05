<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\User;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:gaji-index')->only('index');
        $this->middleware('permission:gaji-create')->only('create');
        $this->middleware('permission:gaji-show')->only('show');
        $this->middleware('permission:gaji-edit')->only('edit');
        $this->middleware('permission:gaji-delete')->only('delete');
    }

    public function index(Request $request){
        $user = User::with('karyawan')->find($request->id);
        $gajis = Gaji::where('karyawan_id', $user->id)->where('status', 1)->get();
        return view('pages.gaji.index', compact(
            'user',
            'gajis',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'karyawan_id' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
            'nominal_yang_dibayarkan' => 'required',
            'sisa' => 'required',
        ]);

        $nominal = preg_replace('/\D/', '', $request->nominal);
        $nominal = trim($nominal);
        $nominal_yang_dibayarkan = preg_replace('/\D/', '', $request->nominal_yang_dibayarkan);
        $nominal_yang_dibayarkan = trim($nominal_yang_dibayarkan);
        $sisa = preg_replace('/\D/', '', $request->sisa);
        $sisa = trim($sisa);

        $array = [
            'karyawan_id' => $request['karyawan_id'],
            'tanggal' => $request['tanggal'],
            'nominal' => $nominal,
            'nominal_yang_dibayarkan' => $nominal_yang_dibayarkan,
            'sisa' => $sisa,
        ];

        Gaji::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $gaji = Gaji::find($id);
        
        $request->validate([
            'karyawan_id' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
            'nominal_yang_dibayarkan' => 'required',
            'sisa' => 'required',
        ]);

        $nominal = preg_replace('/\D/', '', $request->nominal);
        $nominal = trim($nominal);
        $nominal_yang_dibayarkan = preg_replace('/\D/', '', $request->nominal_yang_dibayarkan);
        $nominal_yang_dibayarkan = trim($nominal_yang_dibayarkan);
        $sisa = preg_replace('/\D/', '', $request->sisa);
        $sisa = trim($sisa);

        $array = [
            'karyawan_id' => $request['karyawan_id'],
            'tanggal' => $request['tanggal'],
            'nominal' => $nominal,
            'nominal_yang_dibayarkan' => $nominal_yang_dibayarkan,
            'sisa' => $sisa,
        ];

        $gaji->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $gaji = Gaji::find($id);

        $gaji->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
