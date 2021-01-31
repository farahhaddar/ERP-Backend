<?php

namespace App\Http\Controllers;
use DB;
use App\TeamProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchti= $searchpi = $searchtn =$searchpn ="";
       
        if (isset($_GET['teamId'])) {
            $searchti = $_GET['teamId'];
        }
        if (isset($_GET['projectId'])) {
            $searchpi= $_GET['projectId'];
        }
        if (isset($_GET['team_name'])) {
            $searchtn= $_GET['team_name'];
        }
        if (isset($_GET['project_name'])) {
            $searchpn= $_GET['project_name'];
        }
        if(isset($_GET['projectId']) &&isset($_GET['teamId']) ){
            $teamProject = DB::select("select team_projects.*,teams.id as team_id,teams.name as team_name,projects.id as project_id,projects.name as project_name,projects.date as project_date from projects join teams join team_projects on projects.id = projectId and teams.id = teamId where teamId like '%$searchti%' and projectId like '%$searchpi%' and teams.name like '%$searchtn%' and projects.name like '%$searchpn%'");
        }
        else
        if(isset($_GET['projectId']))
        $teamProject = DB::select("select team_projects.*,teams.id as team_id,teams.name as team_name,projects.id as project_id,projects.name as project_name,projects.date as project_date from projects join teams join team_projects on projects.id = projectId and teams.id = teamId where teamId like '%$searchti%' and projectId like '$searchpi' and teams.name like '%$searchtn%' and projects.name like '%$searchpn%'");
        else if(isset($_GET['teamId']))
        $teamProject = DB::select("select team_projects.*,teams.id as team_id,teams.name as team_name,projects.id as project_id,projects.name as project_name,projects.date as project_date from projects join teams join team_projects on projects.id = projectId and teams.id = teamId where teamId like '$searchti' and projectId like '%$searchpi%' and teams.name like '%$searchtn%' and projects.name like '%$searchpn%'");
        else
        $teamProject = DB::select("select team_projects.*,teams.id as team_id,teams.name as team_name,projects.id as project_id,projects.name as project_name,projects.date as project_date from projects join teams join team_projects on projects.id = projectId and teams.id = teamId where teamId like '%$searchti%' and projectId like '%$searchpi%' and teams.name like '%$searchtn%' and projects.name like '%$searchpn%'");

            // $teamProject = DB::table('team_projects')->join('projects', 'projects.id', '=', 'team_projects.id')
            // ->join('teams', 'teams.id', '=', 'team_projects.id');
            return $teamProject;
            // $teamProject = $teamProject->where('teamId', 'LIKE', '%' . $searchti . '%')
            //                            ->where('projectId', 'LIKE', '%' . $searchpi . '%');
                    
            // return $teamProject->paginate($rowNb);
       
    }
    public function teamProjectAssigned($rowNb){
        $searchti= $searchpi = $searchtn =$searchpn ="";
       
        if (isset($_GET['teamId'])) {
            $searchti = $_GET['teamId'];
        }
        if (isset($_GET['projectId'])) {
            $searchpi= $_GET['projectId'];
        }
        if (isset($_GET['team_name'])) {
            $searchtn= $_GET['team_name'];
        }
        if (isset($_GET['project_name'])) {
            $searchpn= $_GET['project_name'];
        }
        $teamProject = DB::table('projects')
        ->join('team_projects','projects.id','=','projectId')
        ->join('teams','teams.id','=','teamId')
        ->select('team_projects.*','teams.id as team_id','teams.name as team_name','projects.id as project_id','projects.name as project_name','projects.date as project_date')
        ->where('teamId','Like',"$searchti")
        ->where('projectId','Like',"%$searchpi%")
        ->where('teams.name','Like',"%$searchtn%")
        ->where('projects.name','Like',"%$searchpn%");
        return $teamProject->paginate($rowNb);
    }
    public function teamsNotAssigned(){
        $searchpi="";
        if (isset($_GET['projectId'])) {
            $searchpi= $_GET['projectId'];
        }
        return DB::select("select * from teams where id not in (select teamId from team_projects join teams on teams.id = team_projects.teamId where projectId = $searchpi)");
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
            'teamId' => 'required',
            'projectId' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{


        $data=$request->all(); 
        $teamProject= new TeamProject();
        $teamProject->fill($data); 
        $teamProject->save();
        return response()-> json(['status'=> 200,'teamProject'=>$teamProject]);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeamProject  $teamProject
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TeamProject :: where('id',$id)->first();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeamProject  $teamProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all() ,[
            'teamId' => 'required',
            'projectId' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
            $data= $request->all();
            $teamProject= TeamProject::where('id',$id)-> first();
            $teamProject->update($data); //changing everything
            $teamProject->save(); 
            return response()-> json(['status='=> 200,'teamProject'=> $teamProject]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeamProject  $teamProject
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId,$teamId)
    {
        // TeamProject :: where('id',$id)->delete();
        DB::table('team_projects')
        ->where('projectId',$projectId)
        ->where('teamId',$teamId)
        ->delete();
        // DB::delete("delete from team_projects where projectId = "+$projectId+" and teamId = "+$teamId);
        return response()-> json(['status'=>200,'message'=>"Record has been deleted successfuly"]);

    }
}
