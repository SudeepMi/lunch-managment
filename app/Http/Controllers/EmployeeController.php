<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin', ['only' => ['index', 'create', 'store', 'edit', 'update', 'delete', 'search', 'destroy']]);
    }



        public function index(){
        $emps = Employee::all();

        return view('admin.emplist', compact('emps'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addempl');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|email',

        ]);

        if ($validator->fails()) {
            return redirect('admin/addempl')
                ->withErrors($validator)
                ->withInput();
        }else{
            try {
                $email = $request->email;

                DB::table('employees')->insert(array(['email' => "$email"]));
                return redirect()->route('emplist')->with('success','added');

            } catch(QueryException $ex){
                if($ex->getMessage() !== ""){
                    return redirect()
                        ->back()
                        ->withErrors(['email' => 'email already exist']);
                }
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        $emp = DB::table('employees')->where('id',$id)->get();

        return view('admin.editempl',compact('emp'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|email',
            'name' => 'sometimes|required|string',
            'status' =>'sometimes|required|boolean'

        ]);

        if ($validator->fails()) {
            return redirect('admin/addemp')
                ->withErrors($validator)
                ->withInput();
        } else {
            $emails = $request->email;
            $r = DB::table('employees')
                ->where('id', $id)
                ->update(['email' => $emails,
                    'name' => $request->name,
                    'active' =>$request->status
                ]);
            return redirect()->route('emplist')->with('success', 'added');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id){
        Employee::destroy($id);
        return redirect()->back()->with('success','deleted');
    }
}
