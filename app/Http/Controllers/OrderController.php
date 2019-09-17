<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:employee', ['only' => ['createorder','storeorder','ordenotify'],'except' =>['menuforadmin','menus','allorders','orderdone','orders']]);
    }

    public function createorder(){
        return view('employee.createorder');
    }

    public function storeorder(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',]);
        if ($validator->fails()) {
            return redirect('admin/addempl')
                ->withErrors($validator)
                ->withInput();
        }else{

                 $name = $request->user;
                $items = implode(',',$request->item);

                Order::create(['name'=>$name,'items'=>$items]);
                return redirect(url('employee/home'))->with('success','order done');

        }
    }

    public function ordenotify(){
        $user = $this->employeer();
      $completed = DB::table('orders')
            ->where('name', $user)
          ->orderByDesc('created_at')
            ->get();
      return  view('employee.notifications',compact('completed'));
    }

    public static function allorders(){
        $recent = DB::table('orders')
            ->where('status', '0')
            ->orderBy('created_at','desc')
            ->get();
        return $recent;
    }

    public function orderdone(Request $request){
        $model = Order::find($request->id);
        $model->status = ($model->status==0) ? 1 : 0 ;
        if($model->update()){
            return response()->json(['status' => 'success','successMsg' => 'Successfully Updated  Employee Status!']); die;
            }
            return response()->json(['status' => 'failed', 'errorMsg' => 'Something went wrong. Please try again!']);
  

    }


}
