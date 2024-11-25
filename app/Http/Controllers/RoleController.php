<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(){

        $roles = DB::select("SELECT * FROM role");

        return view('role.index', compact('roles'));
    }

    public function create(){

        $roles = DB::select("SELECT * FROM role");

        return view('role.create', compact('roles')); 
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_role' => 'required|string|max:50',
            ]);
    
            DB::statement("
                INSERT INTO role (nama_role) 
                VALUES (?)
            ", [$request->nama_role]);
    
            return redirect()->route('role.create')->with('success', 'Data berhasil ditambahkan!');
        } catch (QueryException $e) {
            return redirect()->route('role.create')->with('error', 'Data tidak berhasil ditambahkan!');
        }
    }

    
    public function destroy($id)
    {
        try {
            DB::statement("
                DELETE FROM role 
                WHERE idrole = ?
            ", [$id]);
    
            return redirect()->route('role')->with('success', 'Data berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect()->route('role')->with('error', 'Data tidak dapat dihapus karena sedang digunakan oleh pengguna!');
        }
    }

}
