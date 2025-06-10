<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    // Method untuk menampilkan profile admin yang login
    public function profile()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data admin berdasarkan user_id yang login
        $admin = AdminModel::with('user')
            ->where('user_id', $user->user_id)
            ->first();

        // Jika data admin tidak ditemukan
        if (!$admin) {
            return redirect()->back()->with('error', 'Data admin tidak ditemukan');
        }

        return view('admin.profile', compact('admin'));
    }

    // Method untuk update profile admin
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'email' => 'required|email|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update data admin
        $admin = AdminModel::where('user_id', $user->user_id)->first();
        if ($admin) {
            $admin->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('admin.profile')->with('success', 'Profile berhasil diperbarui');
    }

    public function list()
    {
        $data = AdminModel::select('admin_id', 'user_id', 'nama', 'email')
            ->with('user:user_id,username,role');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('username', function ($row) {
                return $row->user ? $row->user->username : 'Tidak ada user';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-warning btn-sm btn-edit" data-id="' . $row->admin_id . '">Edit</button>
                    <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $row->admin_id . '">Hapus</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $users = UsersModel::select('user_id', 'username')->get();
        return view('admin.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nama' => 'required|string|max:50',
            'email' => 'required|string|max:50',
        ]);

        AdminModel::create([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'email' => $request->email,
        ]);
        return redirect('/admin')->with('success', 'Data admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = AdminModel::with('user')->findOrFail($id);
        $users = UsersModel::select('user_id', 'username')->get();
        return view('admin.edit', compact('admin', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'nama' => 'required|string|max:50',
            'email' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = AdminModel::findOrFail($id);
        $admin->update([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data admin berhasil diperbarui'
        ]);
    }

    public function destroy_ajax($id)
    {
        AdminModel::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data admin berhasil dihapus'
        ]);
    }
}
