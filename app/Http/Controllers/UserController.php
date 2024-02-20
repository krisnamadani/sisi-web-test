<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user');
    }

    public function get()
    {
        $users = User::all();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('jenis_user', function ($user) {
                return $user->id_jenis_user == 1 ? 'Admin' : 'User';
            })
            ->addColumn('action', function ($user) {
                return '<button class="btn btn-sm btn-primary" onclick="edit(`' . $user->id_user . '`)">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="destroy(`' . $user->id_user . '`)">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required',
            'wa' => 'required',
            'pin' => 'required',
        ]);

        $user = new User;

        $user->id_user = Str::random(30);
        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->wa = $request->wa;
        $user->pin = $request->pin;

        $user->id_jenis_user = '2'; // 2 = user
        $user->status_user = 'active';
        $user->delete_mark = '0';
        $user->create_by = Auth::user()->id_user;
        $user->create_date = date('Y-m-d H:i:s');
        $user->update_by = Auth::user()->id_user;
        $user->update_date = date('Y-m-d H:i:s');

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully'
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required|unique:users,username,' . $request->id_user . ',id_user',
            'password' => 'nullable|min:4',
            'email' => 'required|unique:users,email,' . $request->id_user . ',id_user|email',
            'no_hp' => 'required',
            'wa' => 'required',
            'pin' => 'required',
        ]);

        $user = User::find($request->id_user);

        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->wa = $request->wa;
        $user->pin = $request->pin;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }
}
