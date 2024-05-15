<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachments;
use App\Models\InvoiceDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        // $this->middleware('permission:', ['only' => ['index']]);

    }
    public function index()
    {
        //
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
    public function show(InvoiceDetails $invoiceDetails)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $details = InvoiceDetails::where('invoice_id', $id)->get();
        $attachments = InvoiceAttachments::where('invoice_id', $id)->get();
        return view('invoices.details_invoice', compact('invoice', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceDetails $invoiceDetails)
    {
        //
    }
    public function getUser($id)
    {
        $products = DB::table('Users')->where("id", $id)->pluck("name", "id");
        return json_encode($products);
    }
}
