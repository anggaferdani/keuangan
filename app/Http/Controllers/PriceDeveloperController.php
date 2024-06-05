<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\PriceDeveloper;
use App\Models\User;
use Illuminate\Http\Request;

class PriceDeveloperController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:price-developer-index')->only('index');
        $this->middleware('permission:price-developer-create')->only('create');
        $this->middleware('permission:price-developer-show')->only('show');
        $this->middleware('permission:price-developer-edit')->only('edit');
        $this->middleware('permission:price-developer-delete')->only('delete');
    }

    public function index(Request $request){
        $project = Project::find($request->id);
        $users = User::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $priceDevelopers = PriceDeveloper::where('project_id', $project->id)->where('status', 1)->get();
        return view('pages.price-developer.index', compact(
            'project',
            'users',
            'categories',
            'priceDevelopers',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'project_id' => 'required',
            'jobdesk' => 'required',
            'price_satuan' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
            'final_price' => 'required',
            'paid' => 'required',
            'remnant' => 'required',
        ]);

        $price_satuan = preg_replace('/\D/', '', $request->price_satuan);
        $price_satuan = trim($price_satuan);
        $discount_price = preg_replace('/\D/', '', $request->discount_price);
        $discount_price = trim($discount_price);
        $final_price = preg_replace('/\D/', '', $request->final_price);
        $final_price = trim($final_price);
        $paid = preg_replace('/\D/', '', $request->paid);
        $paid = trim($paid);
        $remnant = preg_replace('/\D/', '', $request->remnant);
        $remnant = trim($remnant);

        $array = [
            'project_id' => $request['project_id'],
            'user_id' => $request['user_id'],
            'jobdesk' => $request['jobdesk'],
            'price_satuan' => $price_satuan,
            'qty' => $request['qty'],
            'category_id' => $request['category_id'],
            'discount_percent' => $request['discount_percent'],
            'discount_price' => $discount_price,
            'final_price' => $final_price,
            'paid' => $paid,
            'remnant' => $remnant,
        ];

        PriceDeveloper::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $priceDeveloper = PriceDeveloper::find($id);
        
        $request->validate([
            'project_id' => 'required',
            'jobdesk' => 'required',
            'price_satuan' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
            'final_price' => 'required',
            'paid' => 'required',
            'remnant' => 'required',
        ]);

        $price_satuan = preg_replace('/\D/', '', $request->price_satuan);
        $price_satuan = trim($price_satuan);
        $discount_price = preg_replace('/\D/', '', $request->discount_price);
        $discount_price = trim($discount_price);
        $final_price = preg_replace('/\D/', '', $request->final_price);
        $final_price = trim($final_price);
        $paid = preg_replace('/\D/', '', $request->paid);
        $paid = trim($paid);
        $remnant = preg_replace('/\D/', '', $request->remnant);
        $remnant = trim($remnant);

        $array = [
            'project_id' => $request['project_id'],
            'user_id' => $request['user_id'],
            'jobdesk' => $request['jobdesk'],
            'price_satuan' => $price_satuan,
            'qty' => $request['qty'],
            'category_id' => $request['category_id'],
            'discount_percent' => $request['discount_percent'],
            'discount_price' => $discount_price,
            'final_price' => $final_price,
            'paid' => $paid,
            'remnant' => $remnant,
        ];

        $priceDeveloper->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $priceDeveloper = PriceDeveloper::find($id);

        $priceDeveloper->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
