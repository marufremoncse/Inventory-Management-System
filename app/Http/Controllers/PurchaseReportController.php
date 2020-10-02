<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    public function index(){
    	$page_name = 'Purchase Report';
    	return view('admin.purchase_report.purchase_report_manage',compact('page_name'));
    }
}
