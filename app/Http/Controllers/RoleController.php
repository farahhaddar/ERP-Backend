<?php

namespace App\Http\Controllers;

use App\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchn = "";

        if (isset($_GET['name'])) {
            $searchn = $_GET['name'];
        }

        $role = DB::table('roles');
        $role = $role->where('name', 'LIKE', '%' . $searchn . '%');
        return $role->paginate($rowNb);
    }
    public function count()
    {
        return  Role::count();

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
            'name' => 'required|unique:roles|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $data = $request->all();
            $role = new Role();
            $role->fill($data);
            $role->save();
            return response()->json(['status' => 200, 'role' => $role]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Role::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            $role = Role::where('id', $id)->first();
            $role->update($data); //changing everything
            $role->save();
            return response()->json(['status' => 200, 'role' => $role]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();
        return response()->json(['status' => 200, "message"=>"Record has been deleted successfuly"]);
    }
}
