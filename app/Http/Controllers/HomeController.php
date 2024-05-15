<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sections = Section::count();
        $products = Product::count();
        $total_invoices = Invoice::sum('Total');
        $count_invoices = Invoice::count();
        $invoices_paid = Invoice::where('Value_Status', '1')->sum('Total');
        $count_invoices_paid = Invoice::where('Value_Status', '1')->count();
        $invoices_unpaid = Invoice::where('Value_Status', '2')->sum('Total');
        $count_invoices_unpaid = Invoice::where('Value_Status', '2')->count();
        $invoices_partial = Invoice::where('Value_Status', '3')->sum('Total');
        $count_invoices_partial = Invoice::where('Value_Status', '3')->count();

        if ($count_invoices == 0) {
            $AllData = 0;
        } else {
            $AllData = number_format($count_invoices / $count_invoices * 100);
        }

        if ($count_invoices_paid == 0) {
            $data1 = 0;
        } else {
            $data1 = number_format($count_invoices_paid / $count_invoices * 100);
        }
        if ($count_invoices_unpaid == 0) {
            $data2 = 0;
        } else {
            $data2 = number_format($count_invoices_unpaid / $count_invoices * 100);
        }
        if ($count_invoices_partial == 0) {
            $data3 = 0;
        } else {
            $data3 = number_format($count_invoices_partial / $count_invoices * 100);
        }
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 150])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#F8637C'],
                    'data' => [$data2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#26B788'],
                    'data' => [$data1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#F38846'],
                    'data' => [$data3]
                ],
            ])
            ->options([]);
        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 300, 'height' => 170])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#F8637C', '#26B788', '#F38846'],
                    'data' => [$data2, $data1, $data3]
                ]
            ])
            ->options([]);
        return view('home', compact(
            'sections',
            'products',
            'total_invoices',
            'count_invoices',
            'invoices_paid',
            'count_invoices_paid',
            'invoices_unpaid',
            'count_invoices_unpaid',
            'invoices_partial',
            'count_invoices_partial',
            'AllData',
            'data1',
            'data2',
            'data3',
            'chartjs',
            'chartjs2',
        ));
    }
}
