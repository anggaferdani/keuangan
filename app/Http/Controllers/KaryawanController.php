<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:karyawan-index')->only('index');
        $this->middleware('permission:karyawan-create')->only('create');
        $this->middleware('permission:karyawan-show')->only('show');
        $this->middleware('permission:karyawan-edit')->only('edit');
        $this->middleware('permission:karyawan-delete')->only('delete');
    }

    public function index(Request $request){
        $search = $request->input('search');
        $users = User::with('karyawan')->where('status', 1);
        if (!empty($search)) {
            $users->where('name', 'like', '%' . $search . '%');
        }
        $users = $users->get();
        $karyawanCount = $users->count();
        return view('pages.karyawan.index', compact(
            'users',
            'karyawanCount',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'nip' => 'required',
            'npwp' => 'required',
            'nominal_gaji' => 'required',
            'nominal_tunjangan_hari_raya' => 'required',
        ]);

        $array = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => 2,
        ];

        $user = User::create($array);

        if ($user) {
            $nominal_gaji = preg_replace('/\D/', '', $request->nominal_gaji);
            $nominal_gaji = trim($nominal_gaji);
            $nominal_tunjangan_hari_raya = preg_replace('/\D/', '', $request->nominal_tunjangan_hari_raya);
            $nominal_tunjangan_hari_raya = trim($nominal_tunjangan_hari_raya);

            Karyawan::create([
                'user_id' => $user->id,
                'nip' => $request['nip'],
                'npwp' => $request['npwp'],
                'nominal_gaji' => $nominal_gaji,
                'nominal_tunjangan_hari_raya' => $nominal_tunjangan_hari_raya,
                'no_rekening_bca' => $request['no_rekening_bca'],
                'no_rekening_mandiri' => $request['no_rekening_mandiri'],
            ]);
        }

        return redirect()->route('karyawan.index')->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id.",id",
        ]);

        $array = [
            'name' => $request['name'],
            'email' => $request['email'],
        ];

        if($request['password']){
            $array['password'] = bcrypt($request['password']);
        }

        $user->update($array);

        $nominal_gaji = preg_replace('/\D/', '', $request->nominal_gaji);
        $nominal_gaji = trim($nominal_gaji);
        $nominal_tunjangan_hari_raya = preg_replace('/\D/', '', $request->nominal_tunjangan_hari_raya);
        $nominal_tunjangan_hari_raya = trim($nominal_tunjangan_hari_raya);

        $user->karyawan->update([
            'user_id' => $user->id,
            'nip' => $request['nip'],
            'npwp' => $request['npwp'],
            'nominal_gaji' => $nominal_gaji,
            'nominal_tunjangan_hari_raya' => $nominal_tunjangan_hari_raya,
            'no_rekening_bca' => $request['no_rekening_bca'],
            'no_rekening_mandiri' => $request['no_rekening_mandiri'],
        ]);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $karyawan = User::find($id);

        $karyawan->update([
            'status' => 0,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Success');
    }
}
