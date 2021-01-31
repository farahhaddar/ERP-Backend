<?php

namespace App\Http\Controllers;
use DB;
use App\KpiDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
class KpiDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchl = $searchdate =$searchkpii ="";
        
        if (isset($_GET['level'])) {
            $searchl = $_GET['level'];
        }
       
        if (isset($_GET['date'])) {
            $searchdate = $_GET['date'];
        }

        if (isset($_GET['kpiId'])) {
            $searchkpii = $_GET['kpiId'];
        }
        
        
            $kpid = DB::table('kpi_details');
            $kpid = $kpid->where('level', 'LIKE', '%' . $searchl . '%')
                ->where('date', 'LIKE', '%' . $searchdate . '%')
                ->where('kpiId', 'LIKE', '%' .  $searchkpii . '%');


            return $kpid->paginate($rowNb);
          
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
            'level' => 'required|max:255|integer',
            'kpiId'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
            
        $data=$request->all(); 
        $kpid= new KpiDetail();
        $date= Carbon:: now();
        $kpid->level=$data['level'];
        $kpid->date=$date->toDateString();
        $kpid->kpiId=$data['kpiId'];
        $kpid->save();
        return response()-> json(['status'=> 200,'kpi details'=> $kpid]);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\KpiDetail  $KpiDetail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return KpiDetail :: where('id',$id)->first();
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KpiDetail  $kpiDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all() ,[
            'level' => 'required|max:255|integer',
            'kpiId'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()] , 401);
        }else{
        $data= $request->all();
        $kpid= KpiDetail::where('id',$id)-> first();
        $date=$kpid->date;
        $kpid->update($data); //changing everything
        $kpid->date=$date;
        $kpid->save(); 
        return response()-> json(['status='=> 200,'kpi'=> $kpid]);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KpiDetail  $kpiDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KpiDetail :: where('id',$id)->delete();
        return response()-> json(["Record has been deleted successfuly"]);
    }
}
