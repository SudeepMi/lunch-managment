<?php

namespace App\Http\Controllers;

use App\Item;
use App\Menu;
use App\Cook;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuController;
use App\Http\Requests\Request\AddEmployeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Hash;

class AdminController extends Controller
{
    public $byitem;
    public function __construct()
    {
        $this->middleware('auth:admin', ['only' => ['index','menuforadmin', 'orders', 'ordersbyitem', 'edit','oldermenu' ,'update', 'delete', 'search', 'destroy']]);
    }

    public function index(){
        $menu = Menu::whereDate('created_at',Carbon::now()->toDateString())->first();
        $item = array();
        if($menu){
        $item['item'] = explode(',',$menu->menu);
        $item['diff'] =  Carbon::parse($menu->updated_at)->diffForHumans(Carbon::now());
        }
        return view('admin.home',compact('item'));
    }

    public function StaffList(){
        $staffs = Cook::all();

        return view('admin.stafflist', compact('staffs'));
    }
    public function ChangeStatusCook(Request $request){

        $model = Cook::find($request->id);
        $model->active = ($model->active == 0) ? 1 : 0;
        if($model->update()){
        return response()->json(['status' => 'success','successMsg' => 'Successfully Updated Kitchen Staff Status!']); die;
        }
        return response()->json(['status' => 'failed', 'errorMsg' => 'Something went wrong. Please try again!']);
    }

    public function ChangeStatusEmploye(Request $request){

        $model = Employee::find($request->id);
        $model->active = ($model->active == 0) ? 1 : 0;
        if($model->update()){
        return response()->json(['status' => 'success','successMsg' => 'Successfully Updated  Employee Status!']); die;
        }
        return response()->json(['status' => 'failed', 'errorMsg' => 'Something went wrong. Please try again!']);
    }

    public function UpdateCooks(Request $request){
       $bag = $this->ExtractAjaxData($request);
        $model = Cook::find($bag['id']);
        $model->name = $bag['name'];
        $model->email = $bag['email'];
        if ($model->update()) {
            return "ok";
        }
    }

    public function UpdateEmploye(Request $request){
        $bag = $this->ExtractAjaxData($request);
         $model = Employee::find($bag['id']);
         $model->name = $bag['name'];
         $model->address = $bag['address'];
         $model->phone = $bag['phone'];
         $model->email = $bag['email'];
         if ($model->update()) {
             return "ok";
         }
     }


    public function AddEmploye(AddEmployeRequest $request){

        $bag['name'] = $request->name;
        $bag['email'] = $request->email;
        $bag['address'] = $request->address;
        $bag['phone'] = $request->phone;
        $bag['password'] = Hash::make($request->password);
        if(Employee::create($bag)){
            return redirect()->back();
        }
    }

    public function menuforadmin(){
        $menu = \App\Http\Controllers\MenuController::menus();
        return view('admin.menus',compact('menu'));
    }

    public function orders(){
        $recent = DB::table('orders')
            ->orderBy('created_at','asc')
            ->get();
        return view('admin.orders',compact('recent'));
    }

    public function oldermenu(){
       $older =  Menu::all();
       return view('admin.oldermenus',compact('older'));
    }

    public function ordersbyitem(){
        $items = Item::all();
        foreach ($items as $e){
            $item[]= $e->item;
        }
        $new = array();
        $name = array();
        $recent = DB::table('orders')
           ->get();

        foreach ($recent as $rec) {
            $itym = $rec->items;
            $byitem = explode(',', $itym);

                    foreach ($item as $i){
                        foreach ($byitem as $by){
                    if($i == $by){
                        $name[$by] = [$rec->name];

                    }
                }

            }
 }
        dd($name);

        return view('admin.ordersbyitems',compact('new'));
    }

}
