<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salary;

class SalariesController extends Controller
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

        
        $salaries = Salary::paginate(5);
        return view('sys_mg.salaries.index')->with('salaries',$salaries);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sys_mg.salaries.create');
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            's_amount' => 'required|min:3'
        ]);
        $salary = new Salary();
        $salary->s_amount = $request->input('s_amount');
        $salary->save();
        return redirect('/salaries')->with('info','Salary has been created!');
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salary = Salary::find($id);
        return view('sys_mg.salaries.edit')->with('salary',$salary);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            's_amount' => 'required|min:3'
        ]);
        $salary = Salary::find($id);
        $salary->s_amount = $request->input('s_amount');
        $salary->save();
        return redirect('/salaries')->with('info','Selected salary has been updated!');
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salary = Salary::find($id);
        $salary->delete();
        return redirect('/salaries')->with('info','Selected salary has been deleted!');
    }

    /**
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $this->validate($request,[
            'search' => 'required'
        ]);
        $str = $request->input('search');
        $salaries = Salary::where( 's_amount' , 'LIKE' , '%'.$str.'%' )
            ->orderBy('s_amount','asc')
            ->paginate(4);
        return view('sys_mg.salaries.index')->with([ 'salaries' => $salaries ,'search' => true ]);
    }
}
