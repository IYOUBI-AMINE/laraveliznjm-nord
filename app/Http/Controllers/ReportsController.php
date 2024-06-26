<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use DB;
use Carbon\Carbon;
use PDF;
use App;

class ReportsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::Paginate(4);
        return view('reports.index')->with('employees',$employees);
    }

    /**
     * 
     * @return \Illuminate\Http\Response
     */
    public function makeReport(Request $request){
        $this->validate($request,[
            'date_from' => 'required',
            'date_to'   => 'required'
        ]);
        
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $employees = Employee::whereBetween('join_date' ,[new Carbon($date_from),new Carbon($date_to)])->get();

        $pdf = PDF::loadView('reports.report',['employees' => $employees])->setPaper('a4', 'landscape');
        return $pdf->stream('Employee_hired_report_from_'.$date_from.'_to_'.$date_to.'.pdf');
    }
}
