<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Karyawan;
use App\Models\PriceSubmit;
use Illuminate\Http\Request;

class PriceSubmitController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index', 'create', 'show', 'edit', 'delete']);
        $this->middleware('permission:price-submit-index')->only('index');
        $this->middleware('permission:price-submit-create')->only('create');
        $this->middleware('permission:price-submit-show')->only('show');
        $this->middleware('permission:price-submit-edit')->only('edit');
        $this->middleware('permission:price-submit-delete')->only('delete');
    }

    public function index(Request $request){
        $project = Project::find($request->id);
        $categories = Category::where('status', 1)->get();
        $priceSubmits = PriceSubmit::where('project_id', $project->id)->where('status', 1)->get();
        return view('pages.price-submit.index', compact(
            'project',
            'categories',
            'priceSubmits',
        ));
    }

    public function create(){
    }

    public function store(Request $request){
        $request->validate([
            'project_id' => 'required',
            'fitur' => 'required',
            'price_satuan' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'final_price' => 'required',
        ]);

        $price_satuan = preg_replace('/\D/', '', $request->price_satuan);
        $price_satuan = trim($price_satuan);
        $price = preg_replace('/\D/', '', $request->price);
        $price = trim($price);
        $discount_price = preg_replace('/\D/', '', $request->discount_price);
        $discount_price = trim($discount_price);
        $final_price = preg_replace('/\D/', '', $request->final_price);
        $final_price = trim($final_price);

        $array = [
            'project_id' => $request['project_id'],
            'fitur' => $request['fitur'],
            'price_satuan' => $price_satuan,
            'qty' => $request['qty'],
            'category_id' => $request['category_id'],
            'price' => $price,
            'discount_percent' => $request['discount_percent'],
            'discount_price' => $discount_price,
            'final_price' => $final_price,
        ];

        PriceSubmit::create($array);

        return back()->with('success', 'Success');
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
        $priceSubmit = PriceSubmit::find($id);
        
        $request->validate([
            'project_id' => 'required',
            'fitur' => 'required',
            'price_satuan' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'final_price' => 'required',
        ]);

        $price_satuan = preg_replace('/\D/', '', $request->price_satuan);
        $price_satuan = trim($price_satuan);
        $price = preg_replace('/\D/', '', $request->price);
        $price = trim($price);
        $discount_price = preg_replace('/\D/', '', $request->discount_price);
        $discount_price = trim($discount_price);
        $final_price = preg_replace('/\D/', '', $request->final_price);
        $final_price = trim($final_price);

        $array = [
            'project_id' => $request['project_id'],
            'fitur' => $request['fitur'],
            'price_satuan' => $price_satuan,
            'qty' => $request['qty'],
            'category_id' => $request['category_id'],
            'price' => $price,
            'discount_percent' => $request['discount_percent'],
            'discount_price' => $discount_price,
            'final_price' => $final_price,
        ];

        $priceSubmit->update($array);

        return back()->with('success', 'Success');
    }

    public function destroy($id){
        $priceSubmit = PriceSubmit::find($id);

        $priceSubmit->update([
            'status' => 0,
        ]);

        return back()->with('success', 'Success');
    }
}
