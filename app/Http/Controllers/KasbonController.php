<?php

namespace App\Http\Controllers;

use App\Models\Kasbon;
use App\Models\User;
use Illuminate\Http\Request;

class KasbonController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:kasbon-index')->only('index');
        $this->middleware('permission:kasbon-create')->only('create');
        $this->middleware('permission:kasbon-show')->only('show');
        $this->middleware('permission:kasbon-edit')->only('edit');
        $this->middleware('permission:kasbon-delete')->only('delete');
    }

    public function index(Request $request){
        if ($request->id == null) {
            $searchKaryawan = $request->input('karyawan_id');
            $searchTanggal = $request->input('tanggal');

            $kasbons = Kasbon::with('karyawan')
                ->where('status', 1);

            if ($searchKaryawan) {
                $kasbons = $kasbons->where('karyawan_id', $searchKaryawan);
            }

            if ($searchTanggal) {
                $kasbons = $kasbons->whereDate('tanggal', $searchTanggal);
            }

            $kasbons = $kasbons->get();
            $users = User::where('status', 1)->get();
            return view('pages.kasbon.index', compact(
                'request',
                'kasbons',
                'users',
            ));
        } else {
            $user = User::with('karyawan')->find($request->id);
            $kasbons = Kasbon::where('karyawan_id', $user->id)->where('status', 1)->get();
            return view('pages.kasbon.index', compact(
                'request',
                'user',
                'kasbons',
            ));
        }
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'karyawan_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
            'bulan' => 'required',
            'nominal_cicilan' => 'required',
            'sisa' => 'required',
        ]);

        $nominal = preg_replace('/\D/', '', $request->nominal);
        $nominal = trim($nominal);
        $bulan = preg_replace('/\D/', '', $request->bulan);
        $bulan = trim($bulan);
        $nominal_cicilan = preg_replace('/\D/', '', $request->nominal_cicilan);
        $nominal_cicilan = trim($nominal_cicilan);
        $nominal_yang_dibayarkan = preg_replace('/\D/', '', $request->nominal_yang_dibayarkan);
        $nominal_yang_dibayarkan = trim($nominal_yang_dibayarkan);
        $sisa = preg_replace('/\D/', '', $request->sisa);
        $sisa = trim($sisa);

        $array = [
            'karyawan_id' => $request['karyawan_id'],
            'keterangan' => $request['keterangan'],
            'tanggal' => $request['tanggal'],
            'nominal' => $nominal,
            'bulan' => $bulan,
            'nominal_cicilan' => $nominal_cicilan,
            'nominal_yang_dibayarkan' => $nominal_yang_dibayarkan,
            'sisa' => $sisa,
        ];

        Kasbon::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $kasbon = Kasbon::find($id);
        
        $request->validate([
            'karyawan_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
            'bulan' => 'required',
            'nominal_cicilan' => 'required',
            'sisa' => 'required',
        ]);

        $nominal = preg_replace('/\D/', '', $request->nominal);
        $nominal = trim($nominal);
        $bulan = preg_replace('/\D/', '', $request->bulan);
        $bulan = trim($bulan);
        $nominal_cicilan = preg_replace('/\D/', '', $request->nominal_cicilan);
        $nominal_cicilan = trim($nominal_cicilan);
        $nominal_yang_dibayarkan = preg_replace('/\D/', '', $request->nominal_yang_dibayarkan);
        $nominal_yang_dibayarkan = trim($nominal_yang_dibayarkan);
        $sisa = preg_replace('/\D/', '', $request->sisa);
        $sisa = trim($sisa);

        $array = [
            'karyawan_id' => $request['karyawan_id'],
            'keterangan' => $request['keterangan'],
            'tanggal' => $request['tanggal'],
            'nominal' => $nominal,
            'bulan' => $bulan,
            'nominal_cicilan' => $nominal_cicilan,
            'nominal_yang_dibayarkan' => $nominal_yang_dibayarkan,
            'sisa' => $sisa,
        ];

        $kasbon->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $kasbon = Kasbon::find($id);

        $kasbon->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
