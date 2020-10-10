<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sale;

class SaleReportController extends Controller
{
    public function index(){
    	$page_name = 'Sale Report';
    	return view('admin.sale_report.sale_report_manage',compact('page_name'));
    }

    public function daily_sale(){
        $items = 50;
        $page_name = 'Daily Sale History';
    	$daily_sale = Sale::select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as count'))->groupBy('date')->orderBy('date','desc')->paginate($items);
    	return view('admin.sale_report.daily_sale',compact('page_name','daily_sale','items'));
    }

    public function daily_sale_details($date){
        $items = 50;
    	$page_name = "Sales History of ". date('d-M-Y', strtotime($date));
    	$sale_all = Sale::where('created_at','like',$date.'%')->orderBy('created_at','desc')->paginate($items);
    	return view('admin.sale.sale_manage',compact('page_name','sale_all','items'));
    }

    public function monthly_sale(){
        $items = 50;
        $page_name = 'Monthly Sale History';
        $monthly_sale = Sale::select(DB::raw('MONTH(created_at) as month'),DB::raw('YEAR(created_at) as year'),DB::raw('count(*) as count'))
            ->groupBy('month','year')->orderBy('month','desc')->orderBy('year','desc')->paginate($items);
        return view('admin.sale_report.monthly_sale',compact('page_name','monthly_sale','items'));
      }

    public function monthly_sale_details($year,$month){
        $items = 50;
        $page_name = "Sales History of ". date('M-', strtotime($month)) . date('Y', strtotime($year));
        $sale_all = Sale::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)
                    ->orderBy('created_at','desc')->paginate($items);
        return view('admin.sale.sale_manage',compact('page_name','sale_all','items'));
    }

    public function yearly_sale(){
        $items = 50;
        $page_name = 'Yearly Sale History';
        $yearly_sale = Sale::select(DB::raw('YEAR(created_at) as year'),DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year','desc')->paginate($items);
        return view('admin.sale_report.yearly_sale',compact('page_name','yearly_sale','items'));
    }

    public function yearly_sale_details($year){
        $items = 50;
        $page_name = "Sales History of " . date('Y', strtotime($year));
        $sale_all = Sale::whereYear('created_at', '=', $year)->orderBy('created_at','desc')->paginate($items);
        return view('admin.sale.sale_manage',compact('page_name','sale_all','items'));
    }
}
