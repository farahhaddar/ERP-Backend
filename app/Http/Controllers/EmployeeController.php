<?php

namespace App\Http\Controllers;

use App\Employee;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchn  = $searche = $searchpn =  $searchti= "";
        
        if (isset($_GET['name'])) {
            $searchn = $_GET['name'];
        }
       
        if (isset($_GET['email'])) {
            $searche = $_GET['email'];
        }
        if (isset($_GET['phoneNb'])) {
            $searchpn = $_GET['phoneNb'];
        }
        if (isset($_GET['teamId'])) {
            $searchti = $_GET['teamId'];
        }
        
            $employee = DB::table('employees');
            $employee = $employee->where('name', 'LIKE', '%' . $searchn . '%')
                ->where('email', 'LIKE', '%' . $searche . '%')
                ->where('phoneNb', 'LIKE', '%' . $searchpn . '%')
                ->where('teamId', 'LIKE', '%' . $searchti . '%');

            return $employee->paginate($rowNb);
        
       
    }
    public function count()
    {
        return Employee::count();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:employees|max:255',
            'phoneNb' => 'required|min:8|max:11',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $data = $request->all();
            $image = $request->file('image');
            $path = Storage::disk('public')->put('images', $image);

            if ($path) {

                $employee = new Employee();
                $employee->name = $data['name'];
                $employee->email = $data['email'];
                $employee->phoneNb = $data['phoneNb'];
                $employee->image = $path;
                $employee->teamId = $data['teamId'];
                $employee->save();

                return response()->json(['status' => 200, 'employee' => $employee]);
            } else {

                return response()->json(['status' => 500, 'error' => "couldnt upload image"]);

            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Employee::where('id', $id)->first();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phoneNb' => 'required|min:8|max:11',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $oldData = Employee::findOrFail($id);
            $old_path = $oldData->image;
            $data = $request->all();
            $image = $request->file('image');
            $teamid=$data['teamId'];
        
            if(!empty($image)){
              $pic=$image;
              $path = Storage::disk('public')->put('images', $pic);
              if(!$path){              
               return response()->json(['status' => 500, 'error' => "couldn't upload image"]);
              }
              Storage::disk('public')->delete('/' . $old_path);
            }else{
                $path=$oldData->image;
            }

            if(!empty($data['teamId'])){
                $teamid=$data['teamId'];
            }else{
                $teamid=$oldData->teamId;

            }

                $employee = Employee::where('id', $id)->first();
                $employee->name = $data['name'];
                $employee->email = $data['email'];
                $employee->phoneNb = $data['phoneNb'];
                $employee->image = $path;
                $employee->teamId = $teamid;
                $employee->save();
                // 
                return response()->json(['status' => 200, 'employee' => $employee]);
          
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $employee = Employee::find($id);
        $image = $employee->image;
        Storage::disk('public')->delete('/' . $image);
        $employee->delete();
        return response()->json(['status' => 200, 'Message' => "Record has been deleted successfuly"]);

    }
}
