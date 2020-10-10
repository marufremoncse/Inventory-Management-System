<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Purchase;

class PurchaseReportController extends Controller
{
    public function index(){
    	$page_name = 'Purchase Report';
    	return view('admin.purchase_report.purchase_report_manage',compact('page_name'));
    }

    public function daily_purchase(){
        $items = 50;
        $page_name = 'Daily Purchase History';
    	$daily_purchase = Purchase::select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as count'))->groupBy('date')->orderBy('date','desc')->paginate($items);
    	return view('admin.purchase_report.daily_purchase',compact('page_name','daily_purchase','items'));
    }

    public function daily_purchase_details($date){
        $items = 50;
    	$page_name = "Purchases History of ". date('d-M-Y', strtotime($date));
    	$purchase_all = Purchase::where('created_at','like',$date.'%')->orderBy('created_at','desc')->paginate($items);
    	return view('admin.purchase.purchase_manage',compact('page_name','purchase_all','items'));
    }

    public function monthly_purchase(){
        $items = 50;
        $page_name = 'Monthly Purchase History';
        $monthly_purchase = Purchase::select(DB::raw('MONTH(created_at) as month'),DB::raw('YEAR(created_at) as year'),DB::raw('count(*) as count'))
            ->groupBy('month','year')->orderBy('month','desc')->orderBy('year','desc')->paginate($items);
        return view('admin.purchase_report.monthly_purchase',compact('page_name','monthly_purchase','items'));
      }

    public function monthly_purchase_details($year,$month){
        $items = 50;
        $page_name = "Purchases History of ". date('M-', strtotime($month)) . date('Y', strtotime($year));
        $purchase_all = Purchase::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)
                    ->orderBy('created_at','desc')->paginate($items);
        return view('admin.purchase.purchase_manage',compact('page_name','purchase_all','items'));
    }

    public function yearly_purchase(){
        $items = 50;
        $page_name = 'Yearly Purchase History';
        $yearly_purchase = Purchase::select(DB::raw('YEAR(created_at) as year'),DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year','desc')->paginate($items);
        return view('admin.purchase_report.yearly_purchase',compact('page_name','yearly_purchase','items'));
    }

    public function yearly_purchase_details($year){
        $items = 50;
        $page_name = "Purchases History of " . date('Y', strtotime($year));
        $purchase_all = Purchase::whereYear('created_at', '=', $year)->orderBy('created_at','desc')->paginate($items);
        return view('admin.purchase.purchase_manage',compact('page_name','purchase_all','items'));
    }
}
