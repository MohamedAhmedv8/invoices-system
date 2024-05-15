<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetails;
use App\Models\Invoice;
use App\Models\InvoiceAttachments;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use App\Notifications\NewInvoice;
use App\Notifications\NotificationNewInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['updateStatus']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['print_invoice']]);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => ['invoices_paid']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['invoices_unpaid']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['invoices_partial']]);
    }
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact('invoices'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice', compact('sections'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',
        ], [
            'invoice_number.required' => 'برجاء ادخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة مسجل مسبقا',
            'invoice_Date.required' => 'برجاء ادخال التاريخ',
            'invoice_Date.date' => 'برجاء ادخال التاريخ بشكل صحيح',
            'Due_date.required' => 'برجاء ادخال التاريخ',
            'Due_date.date' => 'برجاء ادخال التاريخ بشكل صحيح',
            'Amount_collection.required' => 'برجاء ادخال قيمة التحصيل',
            'Amount_Commission.required' => 'برجاء ادخال قيمة العمولة',
            'Discount.required' => 'برجاء ادخال قيمة الخصم',
            'Rate_VAT.required' => 'برجاء تحديد نسبة القيمة المضافة',
        ]);
        invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        $invoice_id = Invoice::latest()->first()->id;
        InvoiceDetails::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => "غير مدفوعة",
            'Value_Status' => 2,
            'note' => $request->note,
            'user_id' => (Auth::user()->id),
        ]);
        if ($request->hasFile('file')) {
            $data = $request->validate([
                'file' => 'required',
            ]);
            $invoice_id = Invoice::latest()->first()->id;
            $data['file'] = Storage::putFile("Files/$request->invoice_number", $data['file']);
            InvoiceAttachments::create([
                'file_name' => $data['file'],
                'invoice_number' => $request->invoice_number,
                'Created_by' => Auth::user()->id,
                'invoice_id' => $invoice_id,
            ]);
        }
        $user = User::first();
        $user->notify(new AddInvoice($invoice_id));
        $user = User::first();
        $user->notify(new NotificationNewInvoice($invoice_id));
        session()->flash('Add_invoices');
        return redirect(url('invoices'));
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $sections = Section::all();
        return view('invoices.status_update', compact('invoice', 'sections'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $sections = Section::all();
        return view('invoices.edit_invoice', compact('invoice', 'sections'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',
        ], [
            'invoice_Date.required' => 'برجاء ادخال التاريخ',
            'invoice_Date.date' => 'برجاء ادخال التاريخ بشكل صحيح',
            'Due_date.required' => 'برجاء ادخال التاريخ',
            'Due_date.date' => 'برجاء ادخال التاريخ بشكل صحيح',
            'Amount_collection.required' => 'برجاء ادخال قيمة التحصيل',
            'Amount_Commission.required' => 'برجاء ادخال قيمة العمولة',
            'Discount.required' => 'برجاء ادخال قيمة الخصم',
            'Rate_VAT.required' => 'برجاء تحديد نسبة القيمة المضافة',
        ]);
        $invoice = Invoice::FindOrFail($id);
        $invoice->update([
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        session()->flash('edit_invoices');
        return redirect(url('invoices'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = Invoice::findOrFail($id);
        $details = InvoiceDetails::where('invoice_id', $id)->get();
        $attachments = InvoiceAttachments::where('invoice_id', $id)->get();
        if (!empty($attachments->invoice_number)) {
            Storage::delete($attachments->file_name);
            $attachments->delete();
        }
        $invoice->forceDelete();
        session()->flash('Delete_invoice');
        return redirect(url('invoices'));
    }

    public function updateStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        if ($request->status === "مدفوعة") {
            $invoice->update([
                'Value_Status' => 1,
                'Status' => $request->status,
                'Payment_Date' => $request->payment_Date,
            ]);
            InvoiceDetails::create([
                'invoice_id' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->section,
                'Status' => "مدفوعة",
                'Value_Status' => 1,
                'Payment_Date' => $request->payment_Date,
                'note' => $request->note,
                'user_id' => (Auth::user()->id),
            ]);
            session()->flash('update_Status');
            return redirect(url('invoices'));
        } elseif ($request->status === "مدفوعة جزئيا") {
            $invoice->update([
                'Value_Status' => 3,
                'Status' => $request->status,
                'Payment_Date' => $request->payment_Date,
            ]);
            InvoiceDetails::create([
                'invoice_id' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->section,
                'Status' => "مدفوعة جزئيا",
                'Value_Status' => 3,
                'Payment_Date' => $request->payment_Date,
                'note' => $request->note,
                'user_id' => (Auth::user()->id),
            ]);
            session()->flash('update_Status');
            return redirect(url('invoices'));
        }
    }
    public function invoices_paid()
    {
        $invoices = Invoice::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    public function invoices_unpaid()
    {
        $invoices = Invoice::where('Value_Status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }
    public function invoices_partial()
    {
        $invoices = Invoice::where('Value_Status', 3)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }
    public function print_invoice($id)
    {
        $invoice = Invoice::FindOrFail($id);
        return view('invoices.print_invoice', compact('invoice'));
    }
    public function getProducts($id)
    {
        $products = DB::table('Products')->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
}
