<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rowNb)
    {
        $searchn = $searche = $searchp = "";

        if (isset($_GET['name'])) {
            $searchn = $_GET['name'];
        }

        if (isset($_GET['email'])) {
            $searche = $_GET['email'];
        }
        if (isset($_GET['password'])) {
            $searchp = $_GET['password'];
        }

        $user = DB::table('users');
        $user = $user->where('name', 'LIKE', '%' . $searchn . '%')
            ->where('email', 'LIKE', '%' . $searche . '%')
            ->where('password', 'LIKE', '%' . $searchp . '%');

        return $user->paginate($rowNb);

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
            'email' => 'required|email|unique:users|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|min:6',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $data = $request->all();
            $image = $request->file('image');
            $path = Storage::disk('public')->put('images', $image);

            if ($path) {

                $user = new User();
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->image = $path;
                $user->password = $data['password'];
                $user->save();

                return response()->json(['status' => 200, 'user' => $user]);
            } else {

                return response()->json(['status' => 500, 'error' => "couldnt upload image"]);

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::where('id', $id)->first();

    }

    public function count()
    {
        return User::count();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'image' => 'Nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'min:8|Nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $data = $request->all();
            $image = $request->file('image');
            $oldData = User::findOrFail($id);
            $old_path = $oldData->image;

            if (!empty($image)) {
                $pic = $image;
                $path = Storage::disk('public')->put('images', $pic);
                if (!$path) {
                    return response()->json(['status' => 500, 'error' => "couldn't upload image"]);
                } else {
                    Storage::disk('public')->delete('/' . $old_path);
                }
            } else {
                $path = $oldData->image;
            }

            if (trim($request->password) === '') {
                $user = User::where('id', $id)->first();
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->image = $path;
                $user->save();
                return response()->json(['status' => 200, 'user' => $user]);
            } else {
                $password = $request->password;
                $user = User::where('id', $id)->first();
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->image = $path;
                $user->password = $password;
                $user->save();
                return response()->json(['status' => 200, 'user' => $user]);

            }

        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $image = $user->image;
        Storage::disk('public')->delete('/' . $image);
        $user->delete();
        return response()->json(['status' => 200, 'Message' => "Record has been deleted successfuly"]);

    }
}
