<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'section_id' => 'required',
        ], [
            'product_name.required' => 'برجاء ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج موجود مسبقا',
        ]);
        Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
        ]);
        session()->flash('Add');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|unique:products,product_name',
        ], [
            'product_name.required' => 'برجاء ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج موجود مسبقا',
        ]);
        $id = Section::where('section_name', $request->section_name)->first()->id;
        $product = Product::findOrFail($request->pro_id);
        $product->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);
        session()->flash('Edit');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Product = Product::findOrFail($request->pro_id);
        $Product->delete();
        session()->flash('Delete');
        return redirect('/products');
    }
}
