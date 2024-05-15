<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:ارشيف الفواتير', ['only' => ['index']]);
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:استرجاع فاتورة', ['only' => ['update']]);
    }
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.invoices_archive', compact('invoices'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = Invoice::withTrashed()->where('id', $id)->restore();
        session()->flash('unarchive');
        return back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $invoice->delete();
        session()->flash('archive_invoice');
        return back();
    }
}
