<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\Jobdesk;
use App\Models\Project;
use Illuminate\Http\Request;

class JobdeskController extends Controller
{
    public function karyawan(Request $request){
        $search = $request->input('search');
        $users = User::with('karyawan', 'jobdesks')->where('status', 1);
        if (!empty($search)) {
            $users->where('name', 'like', '%' . $search . '%');
        }
        $users = $users->paginate(10);
        return view('new.jobdesk.karyawan', compact(
            'users',
        ));
    }

    public function index(Request $request){
        $user = User::find($request->user_id);
        $query = Jobdesk::with('user', 'project', 'statusBelongsTo')
            ->where('user_id', $request->user_id)
            ->where('status', 1);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('project', function ($q) use ($search) {
                $q->where('nama_project', 'LIKE', "%{$search}%");
            });
        }

        $jobdesks = $query->latest()->paginate(10);
        $projects = Project::where('status', 1)->get();
        $statuses = Status::all();
        return view('new.jobdesk.index', compact(
            'user',
            'jobdesks',
            'projects',
            'statuses',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => 'required',
            'project_id' => 'required',
            'status_id' => 'required',
        ]);

        $array = [
            'user_id' => $request['user_id'],
            'project_id' => $request['project_id'],
            'keterangan' => $request['keterangan'],
            'status_id' => $request['status_id'],
            'tanggal_mulai_pengerjaan' => $request['tanggal_mulai_pengerjaan'],
            'tanggal_selesai_pengerjaan' => $request['tanggal_selesai_pengerjaan'],
        ];

        Jobdesk::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $jobdesk = Jobdesk::find($id);

        $request->validate([
            'user_id' => 'required',
            'project_id' => 'required',
            'status_id' => 'required',
        ]);

        $array = [
            'user_id' => $request['user_id'],
            'project_id' => $request['project_id'],
            'keterangan' => $request['keterangan'],
            'status_id' => $request['status_id'],
            'tanggal_mulai_pengerjaan' => $request['tanggal_mulai_pengerjaan'],
            'tanggal_selesai_pengerjaan' => $request['tanggal_selesai_pengerjaan'],
        ];

        $jobdesk->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $jobdesk = Jobdesk::find($id);

        $jobdesk->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
