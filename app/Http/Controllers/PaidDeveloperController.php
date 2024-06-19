<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\PaidDeveloper;
use App\Models\PriceDeveloper;

class PaidDeveloperController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:paid-developer-index')->only('index');
        $this->middleware('permission:paid-developer-create')->only('create');
        $this->middleware('permission:paid-developer-show')->only('show');
        $this->middleware('permission:paid-developer-edit')->only('edit');
        $this->middleware('permission:paid-developer-delete')->only('delete');
    }

    public function index(Request $request){
        $priceDeveloper = PriceDeveloper::find($request->id);
        $paidDevelopers = PaidDeveloper::with('file', 'file.attachments')->where('price_developer_id', $priceDeveloper->id)->where('status', 1)->get();
        return view('pages.paid-developer.index', compact(
            'priceDeveloper',
            'paidDevelopers',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'price_developer_id' => 'required',
            'keterangan' => 'required',
            'tanggal_pembayaran' => 'required',
            'nominal_pembayaran' => 'required',
        ]);

        $nominal_pembayaran = preg_replace('/\D/', '', $request->nominal_pembayaran);
        $nominal_pembayaran = trim($nominal_pembayaran);

        $file = File::create([
            'name' => 'paid-developers' . PaidDeveloper::latest()->value('id'),
            'table_reference' => 'paid_developers',
            'pk_reference' => 'id',
        ]);

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $attachment) {
                $fileNameWithoutExtension = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $attachment->getClientOriginalExtension();
                $fileHash = hash('sha256', $fileNameWithoutExtension);
                $fileName = date('YmdHis') . '-' . $fileHash . '.' . $fileExtension;
                $publicPath = public_path('attachments/paid-developers/');
                $filePath = url('/attachments/paid-developers/');
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
            'price_developer_id' => $request['price_developer_id'],
            'keterangan' => $request['keterangan'],
            'tanggal_pembayaran' => $request['tanggal_pembayaran'],
            'nominal_pembayaran' => $nominal_pembayaran,
            'file_id' => $file->id,
        ];

        $paidDeveloper = PaidDeveloper::create($array);

        $priceDeveloper = PriceDeveloper::where('id', $paidDeveloper->price_developer_id)->first();
        $project = Project::with('priceDevelopers')->where('id', $priceDeveloper->project_id)->first();

        $arrayProject = [
            'paid' => $priceDeveloper->paidDevelopers->where('status', 1)->sum('nominal_pembayaran'),
        ];

        $project->update($arrayProject);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $paidDeveloper = PaidDeveloper::find($id);
        
        $request->validate([
            'price_developer_id' => 'required',
            'keterangan' => 'required',
            'tanggal_pembayaran' => 'required',
            'nominal_pembayaran' => 'required',
        ]);

        $nominal_pembayaran = preg_replace('/\D/', '', $request->nominal_pembayaran);
        $nominal_pembayaran = trim($nominal_pembayaran);

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $attachment) {
                $fileNameWithoutExtension = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $attachment->getClientOriginalExtension();
                $fileHash = hash('sha256', $fileNameWithoutExtension);
                $fileName = date('YmdHis') . '-' . $fileHash . '.' . $fileExtension;
                $publicPath = public_path('attachments/paid-developers/');
                $filePath = url('/attachments/paid-developers/');
                $attachment->move($publicPath, $fileName);

                Attachment::create([
                    'file_id' => $paidDeveloper->file->id,
                    'file_name' => $fileNameWithoutExtension . '.' . $fileExtension,
                    'file_path' => $filePath,
                    'file_hash' => $fileName,
                ]);
            }
        }

        $array = [
            'price_developer_id' => $request['price_developer_id'],
            'keterangan' => $request['keterangan'],
            'tanggal_pembayaran' => $request['tanggal_pembayaran'],
            'nominal_pembayaran' => $nominal_pembayaran,
            'file_id' => $paidDeveloper->file->id,
        ];

        $paidDeveloper->update($array);

        $priceDeveloper = PriceDeveloper::where('id', $paidDeveloper->price_developer_id)->first();
        $project = Project::with('priceDevelopers')->where('id', $priceDeveloper->project_id)->first();

        
        $arrayProject = [
            'paid' => $priceDeveloper->paidDevelopers->where('status', 1)->sum('nominal_pembayaran'),
        ];

        $project->update($arrayProject);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $paidDeveloper = PaidDeveloper::find($id);

        $paidDeveloper->update([
            'status' => 0,
        ]);

        $priceDeveloper = PriceDeveloper::where('id', $paidDeveloper->price_developer_id)->first();
        $project = Project::with('priceDevelopers')->where('id', $priceDeveloper->project_id)->first();
        
        $arrayProject = [
            'paid' => $priceDeveloper->paidDevelopers->where('status', 1)->sum('nominal_pembayaran'),
        ];

        $project->update($arrayProject);

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
