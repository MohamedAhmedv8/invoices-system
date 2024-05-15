<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:تقارير الفواتير', ['only' => ['index', 'search_invoice']]);
    }
    public function index()
    {
        return view('reports.invoices_report');
    }
    public function search_invoice(Request $request)
    {
        if ($request->radio == 1) {
            if ($request->type && $request->start_at == '' && $request->end_at == '') {
                $invoices = Invoice::select('*')->where('status', '=', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('invoices', 'type'));
            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = Invoice::whereBetween('invoice_Date', [$start_at, $end_at])->where('status', '=', $request->type)->get();
                return view('reports.invoices_report', compact('invoices', 'start_at', 'end_at', 'type'));
            }
        } else {
            $invoices = Invoice::where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_report', compact('invoices'));
        }
    }
}
