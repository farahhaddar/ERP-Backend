<?php

namespace App\Http\Controllers;
use DB;
use App\EmployeeProjectRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class EmployeeProjectRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchei=$searchpi=$searchri="";
        if (isset($_GET['employeeId'])) {
            $searchei = $_GET['employeeId'];
        }
       
        if (isset($_GET['projectId'])) {
            $searchpi =$_GET['projectId'];
        }
        if (isset($_GET['roleId'])) {
            $searchri =$_GET['roleId'];
        }

        $employeeProjectRole = DB::table('employee_project_roles');
            $employeeProjectRole = $employeeProjectRole->where('employeeId', 'LIKE', '%' . $searchei . '%')
                ->where('projectId', 'LIKE', '%' . $searchpi . '%')
                ->where('roleId', 'LIKE', '%' . $searchri . '%')
                ;

            return $employeeProjectRole->paginate($rowNb);
        

    }
    //all employees that work in a specific project with roles
    public function employees($rowNb)
    {
        $searchti=$searchpi= $searchna = "";
        if (isset($_GET['teamId'])) {
            $searchti = $_GET['teamId'];
        }
        error_log("hi");
       
        if (isset($_GET['projectId'])) {
            $searchpi =$_GET['projectId'];
        }
        if (isset($_GET['name'])) {
            $searchna = $_GET['name'];
        }

        // $employeeProjectRole = DB::select("select employees.id as employee_id,employees.name as employee_name,roles.id as role_id,roles.name as roles_name from employees join employee_project_roles join projects join roles on employees.teamId ='%$searchti%' and projects.id='%$searchpi%' and employees.id = employee_project_roles.employeeId and projects.id = employee_project_roles.projectId and roles.id = employee_project_roles.roleId");
            // return $employeeProjectRole->paginate($rowNb);
            $employeeProjectRole = DB::table("employees")
            ->join('employee_project_roles','employees.id','=','employee_project_roles.employeeId')
            ->join('projects','projects.id','=','employee_project_roles.projectId')
            ->join('roles','employee_project_roles.roleId','=','roles.id')
            ->select('employees.id as employee_id','employees.name as employee_name','roles.id as role_id','roles.name as roles_name')
            ->where('employees.teamId' ,$searchti)
            ->where('projects.id' ,$searchpi)
            ->where('employees.name' ,'LIKE','%' . $searchna . '%');
            return $employeeProjectRole->paginate($rowNb);

        

    }
    public function projectRole($id,$rowNb){
        $searchp = $searchr = "";
        if (isset($_GET['projectName'])) {
            $searchp = $_GET['projectName'];
        }
        if (isset($_GET['roleName'])) {
            $searchr = $_GET['roleName'];
        }
        $project = DB::table('employee_project_roles')
        ->join('employees','employees.id','=','employee_project_roles.employeeId')
        ->join('projects','projects.id','=','employee_project_roles.projectId')
        ->join('roles','employee_project_roles.roleId','=','roles.id')
        ->select('projects.name as projectName','roles.name as roleName')
        ->where('employees.id',$id)
        ->where('projects.name' ,'LIKE','%' . $searchp . '%')
        ->where('roles.name' ,'LIKE','%' . $searchr . '%');
        return $project->paginate($rowNb);
    }
    public function notAssigned(){
        return DB::select("select employees.id,employees.name from employees where employees.teamId = 1 and employees.id not in (select distinct employees.id from teams join team_projects join employees join employee_project_roles on teams.id = team_projects.teamId and team_projects.teamId=1 and team_projects.projectId=1 and employees.teamId = teams.id where(employees.id = employee_project_roles.employeeId and employee_project_roles.projectId=1))");
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
            'employeeId' => 'required',
            'projectId' => 'required',
            'roleId' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{


        $data=$request->all(); 
        $employeeProjectRole= new EmployeeProjectRole();
        $employeeProjectRole->fill($data); 
        $employeeProjectRole->save();
        return response()-> json(['status'=> 200,'employeeProjectRole'=>$employeeProjectRole]);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeProjectRole  $employeeProjectRole
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return EmployeeProjectRole :: where('id',$id)->first();
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeProjectRole  $employeeProjectRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all() ,[
            'employeeId' => 'required',
            'projectId' => 'required',
            'roleId' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{

            $data= $request->all();
            $employeeProjectRole= EmployeeProjectRole::where('id',$id)-> first();
            $employeeProjectRole->update($data); //changing everything
            $employeeProjectRole->save(); 
            return response()-> json(['status='=> 200,'employeeProjectRole'=> $employeeProjectRole]);

        }
    }
    public function updateRole(Request $request){
        
        $validator = Validator::make($request->all() ,[
            'employeeId' => 'required',
            'projectId' => 'required',
            'roleId' => 'required',
        ]);
        if($validator->fails()){
            error_log("hi");
            return response()->json(['error'=> $validator->errors()] , 401);
        }
        error_log($request->employeeId);
        error_log($request->projectId);
        error_log($request->roleId);
        $model = EmployeeProjectRole::where('projectId','=',$request->projectId)
        ->where('employeeId','=',$request->employeeId)
        ->firstOrFail();
        error_log($model->roleId);
        $model->roleId = $request->roleId;
        $model->save();
        return "a";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeProjectRole  $employeeProjectRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId,$employeeId)
    {
        // EmployeeProjectRole :: where('id',$id)->delete();
        DB::table('employee_project_roles')
        ->where('projectId',$projectId)
        ->where('employeeId',$employeeId)
        ->delete();
        return response()-> json(['status'=>200,'message'=>"Record has been deleted successfuly"]);
    }
}
