<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index(){
        $users = DB::select("SELECT * FROM data_user");
    
        return view('user.index', compact('users'));
    }

    public function create(){
        $users = DB::select("SELECT * FROM user");
        $roles = DB::select("SELECT * FROM role");
    
        return view('user.create', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'idrole'   => 'required|exists:role,idrole',
        ]);
    
        DB::statement("
            INSERT INTO user (username, password, idrole) 
            VALUES (?, ?, ?)
        ", [$request->username, $request->password, $request->idrole]);
    
        return redirect('/user');
    }

    public function destroy($id)
    {
        try {
            DB::statement("
                DELETE FROM user 
                WHERE iduser = ?
            ", [$id]);
    
            return redirect('/user')->with('success', 'User berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/user')->with('error', 'User Tidak berhasil dihapus!');
        }
    }

    public function edit($id)
    {
        // Ambil data user berdasarkan ID
        $user = DB::select("SELECT * FROM user WHERE iduser = ?", [$id]);
    
        // Jika user tidak ditemukan, redirect dengan pesan error
        if (empty($user)) {
            return redirect('/user')->with('error', 'User tidak ditemukan.');
        }
    
        // Ambil semua role
        $roles = DB::select("SELECT * FROM role");
    
        // Konversi hasil query user dari object ke array untuk digunakan di Blade
        $user = (array)$user[0];
    
        return view('user.edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'idrole'   => 'required|exists:role,idrole',
        ]);
    
        DB::statement("
            UPDATE user 
            SET username = ?, password = ?, idrole = ? 
            WHERE iduser = ?
        ", [$request->username, $request->password, $request->idrole, $id]);
    
        return redirect('/user')->with('success', 'Data user berhasil diperbarui.');
    }
    
}