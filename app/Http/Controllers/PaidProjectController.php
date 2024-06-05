<?php

namespace App\Http\Controllers;

use App\Models\PaidProject;
use App\Models\Project;
use Illuminate\Http\Request;

class PaidProjectController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:paid-project-index')->only('index');
        $this->middleware('permission:paid-project-create')->only('create');
        $this->middleware('permission:paid-project-show')->only('show');
        $this->middleware('permission:paid-project-edit')->only('edit');
        $this->middleware('permission:paid-project-delete')->only('delete');
    }

    public function index(Request $request){
        $project = Project::find($request->id);
        $paidProjects = PaidProject::where('project_id', $project->id)->where('status', 1)->get();
        return view('pages.paid-project.index', compact(
            'project',
            'paidProjects',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'project_id' => 'required',
            'keterangan' => 'required',
            'tanggal_pembayaran' => 'required',
            'nominal_pembayaran' => 'required',
        ]);

        $nominal_pembayaran = preg_replace('/\D/', '', $request->nominal_pembayaran);
        $nominal_pembayaran = trim($nominal_pembayaran);

        $array = [
            'project_id' => $request['project_id'],
            'keterangan' => $request['keterangan'],
            'tanggal_pembayaran' => $request['tanggal_pembayaran'],
            'nominal_pembayaran' => $nominal_pembayaran,
        ];

        PaidProject::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $paidProject = PaidProject::find($id);
        
        $request->validate([
            'project_id' => 'required',
            'keterangan' => 'required',
            'tanggal_pembayaran' => 'required',
            'nominal_pembayaran' => 'required',
        ]);

        $nominal_pembayaran = preg_replace('/\D/', '', $request->nominal_pembayaran);
        $nominal_pembayaran = trim($nominal_pembayaran);

        $array = [
            'project_id' => $request['project_id'],
            'keterangan' => $request['keterangan'],
            'tanggal_pembayaran' => $request['tanggal_pembayaran'],
            'nominal_pembayaran' => $nominal_pembayaran,
        ];

        $paidProject->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $paidProject = PaidProject::find($id);

        $paidProject->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
