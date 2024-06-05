<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\EndUser;
use App\Models\User;
use App\Models\Status;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $statuses = Status::whereNot('status', 0)->get();
        $clients = Client::where('status', 1)->get();
        $endUsers = EndUser::where('status', 1)->get();
        $projects = Project::with('statusBelongsTo', 'priceSubmits')->where('status', 1)->get();
        $projectCount = Project::where('status', 1)->count();
        $users = User::with(['karyawan' => function($query) {
            $query->where('status', 1)
                  ->with('gajis', 'reimburses', 'kasbons', 'tunjanganHariRayas');
        }])
        ->where('status', 1)
        ->get();
        
        return view('pages.project.index', compact(
            'statuses',
            'clients',
            'endUsers',
            'projects',
            'projectCount',
            'users',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'status_id' => 'required',
            'client_id' => 'required',
            'end_user_id' => 'required',
            'nama_project' => 'required',
            'nomor_penawaran' => 'required',
            'jenis_pekerjaan' => 'required',
            'programming_language' => 'required',
            'project_entry_date' => 'required',
            'project_start_date' => 'required',
            'project_completion_date' => 'required',
        ]);

        $paid = preg_replace('/\D/', '', $request->paid_project);
        $paid = trim($paid);

        $selectedClientId = $request['client_id'];

        if ($selectedClientId) {
            $client = Client::find($selectedClientId);
            if ($client) {
                $clientId = $client->id;
            } else {
                $newClient = Client::create([
                    'name' => $request['client_id'],
                ]);
                
                $clientId = $newClient->id;
            }
        } else {
            $newClient = Client::create([
                'name' => $request['client_id'],
            ]);
            
            $clientId = $newClient->id;
        }

        $selectedEndUserId = $request['end_user_id'];

        if ($selectedEndUserId) {
            $endUser = EndUser::find($selectedEndUserId);
            if ($endUser) {
                $endUserId = $endUser->id;
            } else {
                $newEndUser = EndUser::create([
                    'name' => $request['end_user_id'],
                ]);
                
                $endUserId = $newEndUser->id;
            }
        } else {
            $newEndUser = EndUser::create([
                'name' => $request['end_user_id'],
            ]);
            
            $endUserId = $newEndUser->id;
        }

        $array = [
            'status_id' => $request['status_id'],
            'client_id' => $clientId,
            'end_user_id' => $endUserId,
            'nama_project' => $request['nama_project'],
            'nomor_penawaran' => $request['nomor_penawaran'],
            'jenis_pekerjaan' => $request['jenis_pekerjaan'],
            'programming_language' => $request['programming_language'],
            'project_entry_date' => $request['project_entry_date'],
            'project_start_date' => $request['project_start_date'],
            'project_completion_date' => $request['project_completion_date'],
            'paid' => $paid ?? 0,
        ];

        Project::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
        $statuses = Status::whereNot('status', 0)->get();
        $clients = Client::where('status', 1)->get();
        $endUsers = EndUser::where('status', 1)->get();
        $project = Project::find($id);
        $users = User::with(['karyawan' => function($query) {
            $query->where('status', 1)
                  ->with('gajis', 'reimburses', 'kasbons', 'tunjanganHariRayas');
        }])
        ->where('status', 1)
        ->get();
        return view('pages.project.show', compact(
            'statuses',
            'clients',
            'endUsers',
            'project',
            'users',
        ));
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $gaji = Project::find($id);
        
        $request->validate([
            'status_id' => 'required',
            'client_id' => 'required',
            'end_user_id' => 'required',
            'nama_project' => 'required',
            'nomor_penawaran' => 'required',
            'jenis_pekerjaan' => 'required',
            'programming_language' => 'required',
            'project_entry_date' => 'required',
            'project_start_date' => 'required',
            'project_completion_date' => 'required',
        ]);

        $paid = preg_replace('/\D/', '', $request->paid_project);
        $paid = trim($paid);

        $selectedClientId = $request['client_id'];

        if ($selectedClientId) {
            $client = Client::find($selectedClientId);
            if ($client) {
                $clientId = $client->id;
            } else {
                $newClient = Client::create([
                    'name' => $request['client_id'],
                ]);
                
                $clientId = $newClient->id;
            }
        } else {
            $newClient = Client::create([
                'name' => $request['client_id'],
            ]);
            
            $clientId = $newClient->id;
        }

        $selectedEndUserId = $request['end_user_id'];

        if ($selectedEndUserId) {
            $endUser = EndUser::find($selectedEndUserId);
            if ($endUser) {
                $endUserId = $endUser->id;
            } else {
                $newEndUser = EndUser::create([
                    'name' => $request['end_user_id'],
                ]);
                
                $endUserId = $newEndUser->id;
            }
        } else {
            $newEndUser = EndUser::create([
                'name' => $request['end_user_id'],
            ]);
            
            $endUserId = $newEndUser->id;
        }

        $array = [
            'status_id' => $request['status_id'],
            'client_id' => $clientId,
            'end_user_id' => $endUserId,
            'nama_project' => $request['nama_project'],
            'nomor_penawaran' => $request['nomor_penawaran'],
            'jenis_pekerjaan' => $request['jenis_pekerjaan'],
            'programming_language' => $request['programming_language'],
            'project_entry_date' => $request['project_entry_date'],
            'project_start_date' => $request['project_start_date'],
            'project_completion_date' => $request['project_completion_date'],
            'paid' => $paid ?? 0,
        ];

        $gaji->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $gaji = Project::find($id);

        $gaji->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
