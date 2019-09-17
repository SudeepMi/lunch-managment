<?php


namespace App\Http\Controllers;
use App\Cook;
use App\Http\Requests\Request\AddStaffRequest;
use App\Item;
use App\Menu;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class StaffController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth:admin', ['only' => ['index', 'create', 'store', 'edit', 'update', 'delete', 'search', 'destroy'],'except'=>['items']]);
    }

    public function index(){
        $staffs = Cook::all();
        return view('admin.stafflist', compact('staffs'));
    }

    public function create(){
        return view('admin.addstaff');
    }

    public function AddStaff(AddStaffRequest $request){

        $bag['name'] = $request->name;
        $bag['email'] = $request->email;
        $bag['address'] = $request->address;
        $bag['phone'] = $request->phone;
        $bag['password'] = Hash::make($request->password);
        if(Cook::create($bag)){
            return redirect()->back();
        }
    }


    public function edit($id){

        $cook = DB::table('cooks')->where('id',$id)->get();

        return view('admin.editstaff',compact('cook'));
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|email',
            'name' => 'sometimes|required|string',
            'status' =>'sometimes|required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect('admin/addstaff')
                ->withErrors($validator)
                ->withInput();
        } else {
             $emails = $request->email;
            $r = DB::table('cooks')
                ->where('id', $id)
                ->update(['email' => $emails,
                        'name' => $request->name,
                    'active' =>$request->status
                ]);
             return redirect()->route('stafflist')->with('success', 'updated');

        }
    }

    public function delete(Request $request, $id){
     Cook::destroy($id);
       return redirect()->back()->with('success','deleted');
    }

    public function home(){
        $menu = Menu::whereDate('created_at', Carbon::now())->first();
        if(!is_null($menu)){
        $menu->items = explode(',',$menu->menu);
        }
        $oder = Order::orderBy('created_at','desc')
                    ->get();
        $view = View::make('layouts.menu',[
            'menu' => $menu
        ]);
        return view('cook.home', compact('oder'))->with('menu',$view);

}



}
