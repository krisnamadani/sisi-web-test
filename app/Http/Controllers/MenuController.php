<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function index()
    {
        $menu_levels = MenuLevel::all();
        
        return view('pages.menu', compact('menu_levels'));
    }

    public function get()
    {
        $menus = Menu::all();

        return DataTables::of($menus)
            ->addIndexColumn()
            ->addColumn('level', function ($menu) {
                return $menu->menu_level->level;
            })
            ->addColumn('action', function ($menu) {
                return '<button class="btn btn-sm btn-primary" onclick="edit(`' . $menu->menu_id . '`)">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="destroy(`' . $menu->menu_id . '`)">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_level' => 'required',
            'menu_name' => 'required',
            'menu_link' => 'required',
            'menu_icon' => 'required',
        ]);

        $menu = new Menu();

        $id = Menu::max('menu_id') + 1;

        $menu->menu_id = $id;
        $menu->id_level = $request->id_level;
        $menu->menu_name = $request->menu_name;
        $menu->menu_link = $request->menu_link;
        $menu->menu_icon = $request->menu_icon;

        $menu->parent_id = 1;
        $menu->delete_mark = '0';
        $menu->create_by = Auth::user()->id_user;
        $menu->create_date = date('Y-m-d H:i:s');
        $menu->update_by = Auth::user()->id_user;
        $menu->update_date = date('Y-m-d H:i:s');

        $menu->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu created successfully'
        ]);
    }

    public function edit($id)
    {
        $menu = Menu::find($id);

        return response()->json([
            'status' => 'success',
            'menu' => $menu
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_level' => 'required',
            'menu_name' => 'required',
            'menu_link' => 'required',
            'menu_icon' => 'required',
        ]);
        
        $menu = Menu::find($request->menu_id);

        $menu->id_level = $request->id_level;
        $menu->menu_name = $request->menu_name;
        $menu->menu_link = $request->menu_link;
        $menu->menu_icon = $request->menu_icon;

        $menu->update_by = Auth::user()->id_user;
        $menu->update_date = date('Y-m-d H:i:s');

        $menu->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu deleted successfully'
        ]);
    }
}
