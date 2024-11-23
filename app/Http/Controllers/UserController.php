<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index(){

        $users = DB::table('data_user')->get();

        $roles = DB::table('role')->get();
        
        return view('user.index', compact('users'));
    }

    public function create(){

        $users = DB::table('data_user')->get();

        $roles = DB::table('role')->get();

        return view('user.create', compact('users', 'roles')); 
    }

    public function store(Request $request)
    {

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'idrole'   => 'required|exists:role,idrole', // Pastikan idrole valid
        ]);

        DB::table('user')->insert([
            'username' => $request->username,
            'password' => $request->password,
            'idrole'   => $request->idrole, // Tambahkan idrole di sini
        ]);
    
        return redirect('/user');
    }

    public function destroy($id)
    {
        try{
            // Mencoba menghapus user dengan idrole tertentu
            DB::table('user')->where('iduser', $id)->delete();
            return redirect('/user')->with('success', 'User berhasil dihapus!');
        } catch ( QueryException $e ){
            // Redirect dengan pesan sukses jika penghapusan berhasil
            return redirect('/user')->with('error', 'User Tidak berhasil dihapus!');
        }
    }

    public function edit($id)
    {
        // Ambil satu data user berdasarkan iduser
        $user = DB::table('data_user')->where('iduser', $id)->first();
    
        // Ambil data role untuk dropdown
        $roles = DB::table('role')->get();
    
        // Kirim data ke view
        return view('user.edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $id) {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'idrole' => 'required|integer|exists:role,idrole', // Pastikan idrole valid
        ]);
    
        // Update data pengguna
        DB::table('user')
            ->where('iduser', $id)
            ->update([
                'username' => $request->username,
                'password' => $request->password,
                'idrole' => $request->idrole,
            ]);
    
        return redirect('/user');
    }
}