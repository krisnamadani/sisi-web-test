<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\MenuUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MenuUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $menus = Menu::all();
        
        return view('pages.menu-user', compact('users', 'menus'));
    }

    public function get()
    {
        $menu_users = MenuUser::all();

        return DataTables::of($menu_users)
            ->addIndexColumn()
            ->addColumn('user', function ($menu_user) {
                return $menu_user->user->nama_user;
            })
            ->addColumn('menu', function ($menu_user) {
                return $menu_user->menu->menu_name;
            })
            ->addColumn('action', function ($menu_user) {
                return '<button class="btn btn-sm btn-primary" onclick="edit(`' . $menu_user->no_seting . '`)">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="destroy(`' . $menu_user->no_seting . '`)">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'menu_id' => 'required'
        ]);

        $menu_user = new MenuUser();

        $id = MenuUser::max('no_seting') + 1;

        $menu_user->no_seting = $id;
        $menu_user->id_user = $request->id_user;
        $menu_user->menu_id = $request->menu_id;

        $menu_user->delete_mark = '0';
        $menu_user->create_by = Auth::user()->id_user;
        $menu_user->create_date = date('Y-m-d H:i:s');
        $menu_user->update_by = Auth::user()->id_user;
        $menu_user->update_date = date('Y-m-d H:i:s');

        $menu_user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu user created successfully'
        ]);
    }

    public function edit($id)
    {
        $menu_user = MenuUser::find($id);

        return response()->json([
            'status' => 'success',
            'menu_user' => $menu_user
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'menu_id' => 'required'
        ]);
        
        $menu_user = MenuUser::find($request->no_seting);

        $menu_user->id_user = $request->id_user;
        $menu_user->menu_id = $request->menu_id;

        $menu_user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu user updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $menu_user = MenuUser::find($id);
        $menu_user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu user deleted successfully'
        ]);
    }
}
