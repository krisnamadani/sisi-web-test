<?php

namespace App\Http\Controllers;

use App\Models\MenuLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenuLevelController extends Controller
{
    public function index()
    {
        return view('pages.menu-level');
    }

    public function get()
    {
        $menu_levels = MenuLevel::all();

        return DataTables::of($menu_levels)
            ->addIndexColumn()
            ->addColumn('action', function ($menu_level) {
                return '<button class="btn btn-sm btn-primary" onclick="edit(`' . $menu_level->id_level . '`)">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="destroy(`' . $menu_level->id_level . '`)">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required',
        ]);

        $menu_level = new MenuLevel();

        $id = MenuLevel::max('id_level') + 1;

        $menu_level->id_level = $id;
        $menu_level->level = $request->level;

        $menu_level->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu level created successfully'
        ]);
    }

    public function edit($id)
    {
        $menu_level = MenuLevel::find($id);

        return response()->json([
            'status' => 'success',
            'menu_level' => $menu_level
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'level' => 'required',
        ]);
        
        $menu_level = MenuLevel::find($request->id_level);

        $menu_level->level = $request->level;

        $menu_level->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu level updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $menu_level = MenuLevel::find($id);
        $menu_level->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu level deleted successfully'
        ]);
    }
}
