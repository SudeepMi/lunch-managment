<?php

namespace App\Http\Controllers;

use App\Cook;
use App\Http\Requests\Item\AddItemRequest;
use App\Item;
use App\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $items;

    public function __construct(Item $items)
    {
        $this->items = $items;
        $this->middleware('auth:cook',['except' =>['menuforadmin','menus']]);
    }


    public static function  menus()
    {
        $dt = Carbon::now()->toDateString();
        $menus =DB::table('menus')->get();
        foreach ($menus as $menu){
            $date = $menu->created_at;
            $menudate = Carbon::parse($date)->toDateString();
             $posted = $menu->updated_at;
            $posted  = Carbon::parse($posted);
           $now = Carbon::now();
            $diff = $posted->diffForHumans($now);
            if ($dt == $menudate){
                $menu->diff = $diff;
                return $menu;
            }
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $items = $this->items::all();
        return view('cook.addmenu',compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Menu::create(['menu' => $request->item])){
            return "ok";
        }
        else{
            return $message = "failed to set menu. try again later";
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
    public function edit(Request $request)
    {
        $menus = Menu::find($request->id);
        $menus->item = explode(',',$menus->menu);
        $items = $this->items::all();

        return  view('cook.editmenu',compact('menus','items'));

    }

    public function updateItem(Request $request){
        $model = Item::find($request->id);
        $model->item = $request->item;
        $model->unit = $request->unit;
        if ($model->update()) {
            return "ok";
        }else{
            return $message = "failed to save";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            $menu = $request->item;
           $model = Menu::find($request->id);
           $model->menu = $menu;

           if ($model->update()) {
             return "ok";
           }
           else{
               return $message = "failed to update";
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeitems( AddItemRequest $request){
        if (Item::create($request->all())){
            return "ok";
        }
        else{
            return json_encode($message = 'failed to add menu item');
        }
    }


    public  function additems(){
        return view('cook.additems');
    }


    public function items(){
        $items = Item::all();
        return view('cook.items', compact('items'));
    }
}
