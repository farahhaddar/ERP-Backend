<?php

namespace App\Http\Controllers;
use DB;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)

    {
        $searchn = $searchd ="";
        
        if (isset($_GET['name'])) {
            $searchn = $_GET['name'];
        }
       
        if (isset($_GET['date'])) {
            $searchd = $_GET['date'];
        }
        
            $project = DB::table('projects');
            $project = $project->where('name', 'LIKE', '%' . $searchn . '%')
                ->where('date', 'LIKE', '%' . $searchd . '%');

            return $project->paginate($rowNb);
       
    }
    public function count()
    {
        return Project::count();

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
            'name' => 'required|unique:projects|max:255',
            'date'=>'required|date|date_format:Y/m/d' 
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
        $data=$request->all(); 
        $project= new Project();
        $project->fill($data); 
        $project->save();
        return response()-> json(['status'=> 200,'project'=> $project]);
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Project :: where('id',$id)->first();
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all() ,[
            'name' => 'required|unique:projects|max:255',
            'date'=>'required|date|date_format:Y/m/d'                                        
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
        $data= $request->all();
        $project= Project::where('id',$id)-> first();
        $date=  $project->date;
        $project->update($data); //changing everything
        $project->date=$date;
        $project->save(); 
        return response()-> json(['status'=> 200,'project'=> $project]);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project :: where('id',$id)->delete();
        return response()-> json(['status'=>200,"message"=>"Record has been deleted successfuly"]);
    }
}
