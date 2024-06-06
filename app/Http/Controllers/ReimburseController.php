<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Reimburse;
use App\Models\Attachment;
use Illuminate\Http\Request;

class ReimburseController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:reimburse-index')->only('index');
        $this->middleware('permission:reimburse-create')->only('create');
        $this->middleware('permission:reimburse-show')->only('show');
        $this->middleware('permission:reimburse-edit')->only('edit');
        $this->middleware('permission:reimburse-delete')->only('delete');
    }

    public function index(Request $request){
        if ($request->id == null) {
            $searchKaryawan = $request->input('karyawan_id');
            $searchTanggal = $request->input('tanggal');
    
            $reimburses = Reimburse::with('file', 'file.attachments')
                ->where('status', 1);

            if ($searchKaryawan) {
                $reimburses = $reimburses->where('karyawan_id', $searchKaryawan);
            }

            if ($searchTanggal) {
                $reimburses = $reimburses->whereDate('tanggal', $searchTanggal);
            }

            $reimburses = $reimburses->get();
            $users = User::where('status', 1)->get();
            return view('pages.reimburse.index', compact(
                'request',
                'reimburses',
                'users',
            ));
        } else {
            $user = User::with('karyawan')->find($request->id);
            $reimburses = Reimburse::with('file', 'file.attachments')->where('karyawan_id', $user->id)->where('status', 1)->get();
            return view('pages.reimburse.index', compact(
                'request',
                'user',
                'reimburses',
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
            'sisa' => 'required',
        ]);

        $nominal = preg_replace('/\D/', '', $request->nominal);
        $nominal = trim($nominal);
        $nominal_yang_dibayarkan = preg_replace('/\D/', '', $request->nominal_yang_dibayarkan);
        $nominal_yang_dibayarkan = trim($nominal_yang_dibayarkan);
        $sisa = preg_replace('/\D/', '', $request->sisa);
        $sisa = trim($sisa);

        $file = File::create([
            'name' => 'reimburses' . Reimburse::latest()->value('id'),
            'table_reference' => 'reimburses',
            'pk_reference' => 'id',
        ]);

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $attachment) {
                $fileNameWithoutExtension = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $attachment->getClientOriginalExtension();
                $fileHash = hash('sha256', $fileNameWithoutExtension);
                $fileName = date('YmdHis') . '-' . $fileHash . '.' . $fileExtension;
                $publicPath = public_path('attachments/reimburses/');
                $filePath = url('/attachments/reimburses/');
                $attachment->move($publicPath, $fileName);

                Attachment::create([
                    'file_id' => $file->id,
                    'file_name' => $fileNameWithoutExtension . '.' . $fileExtension,
                    'file_path' => $filePath,
                    'file_hash' => $fileName,
                ]);
            }
        }

        $array = [
            'karyawan_id' => $request['karyawan_id'],
            'keterangan' => $request['keterangan'],
            'tanggal' => $request['tanggal'],
            'nominal' => $nominal,
            'tanggal_dibayarkan' => $request['tanggal_dibayarkan'],
            'nominal_yang_dibayarkan' => $nominal_yang_dibayarkan,
            'file_id' => $file->id,
            'sisa' => $sisa,
        ];

        Reimburse::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $reimburse = Reimburse::with('file', 'file.attachments')->find($id);
        
        $request->validate([
            'karyawan_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
            'sisa' => 'required',
        ]);

        $nominal = preg_replace('/\D/', '', $request->nominal);
        $nominal = trim($nominal);
        $nominal_yang_dibayarkan = preg_replace('/\D/', '', $request->nominal_yang_dibayarkan);
        $nominal_yang_dibayarkan = trim($nominal_yang_dibayarkan);
        $sisa = preg_replace('/\D/', '', $request->sisa);
        $sisa = trim($sisa);

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $attachment) {
                $fileNameWithoutExtension = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $attachment->getClientOriginalExtension();
                $fileHash = hash('sha256', $fileNameWithoutExtension);
                $fileName = date('YmdHis') . '-' . $fileHash . '.' . $fileExtension;
                $publicPath = public_path('attachments/reimburses/');
                $filePath = url('/attachments/reimburses/');
                $attachment->move($publicPath, $fileName);

                Attachment::create([
                    'file_id' => $reimburse->file->id,
                    'file_name' => $fileNameWithoutExtension . '.' . $fileExtension,
                    'file_path' => $filePath,
                    'file_hash' => $fileName,
                ]);
            }
        }

        $array = [
            'karyawan_id' => $request['karyawan_id'],
            'keterangan' => $request['keterangan'],
            'tanggal' => $request['tanggal'],
            'nominal' => $nominal,
            'tanggal_dibayarkan' => $request['tanggal_dibayarkan'],
            'nominal_yang_dibayarkan' => $nominal_yang_dibayarkan,
            'file_id' => $reimburse->file->id,
            'sisa' => $sisa,
        ];

        $reimburse->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $reimburse = Reimburse::find($id);

        $reimburse->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }

    public function deleteAttachment($id){
        $attachment = Attachment::find($id);

        $attachment->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
