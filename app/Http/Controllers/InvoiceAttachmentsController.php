<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:اضافة مرفق', ['only' => ['store']]);
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
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
        $data = $request->validate([
            'file_name' => 'required|mimes:png,jpg,jpeg,pdf',
        ], [
            'file_name.required' => 'برجاء تحديد المرفق',
            'file_name.mimes' => 'برجاء ادخال صيغة الملف png , jpg , jpeg , pdf',
        ]);
        $data['file'] = Storage::putFile("$request->invoice_number", $data['file_name']);
        InvoiceAttachments::create([
            'file_name' => $data['file'],
            'invoice_number' => $request->invoice_number,
            'Created_by' => Auth::user()->id,
            'invoice_id' => $request->invoice_id,
        ]);
        session()->flash('Add_attachment');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id_file;
        $attachment = InvoiceAttachments::FindOrFail($id);
        Storage::delete($attachment->file_name);
        $attachment->delete();
        session()->flash('delete_attachment');
        return back();
    }

    // public function openFile(Request $request)
    // {
    // }
    // public function downloadFile(Request $request)
    // {
    // }
}
