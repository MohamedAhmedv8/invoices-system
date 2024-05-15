<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:تقارير العملاء', ['only' => ['index', 'search_customers']]);
    }
    public function index()
    {
        $sections = Section::all();
        return view('reports.customers_report', compact('sections'));
    }
    public function search_customers(Request $request)
    {
        if ($request->section && $request->product && $request->start_at == '' && $request->end_at == '') {
            $invoices = Invoice::select('*')->where('section_id', '=', $request->section)->where('product', '=', $request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report', compact('invoices', 'sections'));
        } else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = Invoice::whereBetween('invoice_Date', [$start_at, $end_at])->where('section_id', '=', $request->section)->where('product', '=', $request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report', compact('invoices', 'sections', 'start_at', 'end_at'));
        }
    }
}
