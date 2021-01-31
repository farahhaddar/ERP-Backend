<?php

namespace App\Http\Controllers;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class TeamController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchn ="";
        
        if (isset($_GET['name'])) {
            $searchn = $_GET['name'];
        }
        
            $team = DB::table('teams');
            $team = $team->where('name', 'LIKE', '%' . $searchn . '%');
                
            return $team->paginate($rowNb);

    }

    public function upload(Request $request)
    {
        $image = $request->file('file');
        $path = Storage::disk('public')->put('images',$image);
         return response($path);
    }

    public function count()
    {
        return Team::count();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'name' => 'required|unique:teams|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{


        $data=$request->all(); 
        $team= new Team();
        $team->fill($data); 
        $team->save();
        return response()-> json(['status'=> 200,'team'=>$team]);
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Team :: where('id',$id)->first();

    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all() ,[
            'name' => 'required|unique:teams|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
            $data= $request->all();
            $team= Team::where('id',$id)-> first();
            $team->update($data); //changing everything
            $team->save(); 
            return response()-> json(['status='=> 200,'team'=> $team]);

           
    }
}

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        Team :: where('id',$id)->delete();
        return response()-> json(['status'=>200,'message'=>"Record has been deleted successfuly"]);

    }
}
