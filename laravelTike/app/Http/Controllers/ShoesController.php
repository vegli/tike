<?php

namespace App\Http\Controllers;

use App\Models\Shoes;
use App\Http\Resources\ShoesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static $wrap = 'shoes';

    public function index()
    {
        $shoes = Shoes::all();

        $my_shoes=array();
        foreach($shoes as $shoe){
            array_push($my_shoes,new ShoesResource($shoes));
        }

        return $my_shoes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getByBrand($brand_id){
        $shoes=Shoes::get()->where('brand_id',$brand_id);

        if(count($shoes)==0){
            return response()->json('Ne postoji brend sa ovim ID-jem!');
        }

        $my_shoes=array();
        foreach($shoes as $shoe){
            array_push($my_shoes,new ShoesResource($shoe));
        }

        return $my_shoes;
    }

    public function myShoes(Request $request){
        $shoes=Shoes::get()->where('user_id',Auth::user()->id);
        if(count($shoes)==0){
            return 'Nemate sacuvanih patika!';
        }
        $my_shoes=array();
        foreach($shoes as $shoe){
            array_push($my_shoes,new SkiResource($shoe));
        }

        return $my_shoes;
    }

    public function getByType($type_id){
        $shoes=Shoes::get()->where('type_id',$type_id);

        if(count($shoes)==0){
            return response()->json('ID ovog tipa ne postoji!');
        }

        $my_shoes=array();
        foreach($shoes as $shoe){
            array_push($my_shoes,new ShoesResource($shoe));
        }

        return $my_shoes;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'model'=>'required|String|max:255',
            'color'=>'required|String|max:255',
            'length'=>'required|Integer|max:190',
            'brand_id'=>'required',
            'type_id'=>'required'


        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $shoe=new Ski;
        $shoe->model=$request->model;
        $shoe->color=$request->color;
        $shoe->length=$request->length;
        $shoe->user_id=Auth::user()->id;
        $shoe->type_id=$request->type_id;
        $shoe->brand_id=$request->brand_id;

        $shoe->save();

        return response()->json(['Patike su uspesno sacuvane!',new ShoeResource($shoe)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shoes  $shoes
     * @return \Illuminate\Http\Response
     */
    public function show(Shoes $shoes)
    {
        return new ShoesResource($shoes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shoes  $shoes
     * @return \Illuminate\Http\Response
     */
    public function edit(Shoes $shoes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shoes  $shoes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shoes $shoes)
    {
        $validator=Validator::make($request->all(),[
            'model'=>'required|String|max:255',
            'color'=>'required|String|max:255',
            'length'=>'required|Integer|max:190',
            'brand_id'=>'required',
            'type_id'=>'required'


        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $shoe->model=$request->model;
        $shoe->color=$request->color;
        $shoe->length=$request->length;
        $shoe->user_id=Auth::user()->id;
        $shoe->type_id=$request->type_id;
        $shoe->brand_id=$request->brand_id;

        $result=$shoe->update();

        if($result==false){
            return response()->json('Poteskoce pri azuriranju!');
        }
        return response()->json(['Patike su uspesno azirirane!',new ShoeResource($shoe)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shoes  $shoes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shoes $shoes)
    {
        $shoes->delete();

        return response()->json('Patike '.$auto->model .' su uspesno obrisane!');
    }
}
