<?php

namespace App\Http\Controllers;
use DB;
use App\Kpi;
use App\KpiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class KpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchn = $searchei ="";
        
        if (isset($_GET['name'])) {
            $searchn = $_GET['name'];
        }
       
        if (isset($_GET['employeeId'])) {
            $searchei = $_GET['employeeId'];
        }
        
            $kpi = DB::table('kpis');
            $kpi = $kpi->where('name', 'LIKE', '%' . $searchn . '%')
                ->where('employeeId', 'LIKE', '%' . $searchei . '%');

            return $kpi->paginate($rowNb);
          
    }
    public function kpiCurrent($rowNb){
        $searche ="";
        if (isset($_GET['empName'])) {
            $searche = $_GET['empName'];
        }
        $kpi = DB::table('kpi_details')
        ->join('kpis','kpis.id','=','kpi_details.kpiId')
        ->join('employees','employees.id','=','kpis.employeeId')
        ->select(DB::raw('max(date) as d,kpiId,kpis.name,employees.name as empName'))
        ->where('employees.name','Like','%' . $searche . '%');
        if (isset($_GET['empId'])) {
            $empId = $_GET['empId'];
            $kpi = $kpi
            ->where('employees.id','=',$empId);
        }
        $kpi = $kpi
        ->groupBy('kpiId');
        $kpi1 = DB::table('kpi_details')
        ->joinSub($kpi,'kpi',function($join){
            $searchn = $searchl = "";
        if (isset($_GET['name'])) {
            $searchn = $_GET['name'];
        }
        if (isset($_GET['level'])) {
            $searchl = $_GET['level'];
        }
            $join->on('kpi_details.kpiId','=','kpi.kpiId');
            $join->on('kpi_details.date','=','kpi.d');
            $join->where('kpi.name','Like','%' . $searchn . '%');
            $join->where('kpi_details.level','Like','%' . $searchl . '%');
        })
        ->groupBy('kpi.kpiId');
        return $kpi1->paginate($rowNb);
    }
     
    public function count()
    {
        return Kpi::count();

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
            'name' => 'required|max:255',
            'employeeId'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
        $data=$request->all(); 
        $kpi= new Kpi();
        $kpi->name=$data['name'];
        $kpi->employeeId=$data['employeeId'];
        $kpi->save();
        return response()-> json(['status'=> 200,'kpi'=> $kpi]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kpi  $kpi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Kpi :: where('id',$id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kpi  $kpi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all() ,[
            'name' => 'required|max:255',
            'employeeId'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
        $data= $request->all();
        $kpi= Kpi::where('id',$id)-> first();
        $kpi->update($data); //changing everything
        $kpi->save(); 
        return response()-> json(['status='=> 200,'kpi'=> $kpi]);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kpi  $kpi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kpi :: where('id',$id)->delete();
        return response()-> json(['status'=>200,'message'=>"Record has been deleted successfuly"]);
    }
}
