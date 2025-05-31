<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AlumniController extends Controller
{
    public function index()
    {
        return view('alumni.index');
    }

    public function list()
    {
        $data = AlumniModel::with('user')->select([
            'alumni_id',
            'user_id',
            'nama',
            'nim',
            'email',
            'no_hp',
            'program_studi',
            'tahun_lulus'
        ]);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('username', function ($row) {
                // Ambil username dari relasi user
                return $row->user ? $row->user->username : '-';
            })
            ->addColumn('tahun_lulus_formatted', function ($row) {
                return $row->tahun_lulus ? $row->tahun_lulus->format('Y') : '-';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-warning btn-sm btn-edit" data-id="' . $row->alumni_id . '">Edit</button>
                    <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $row->alumni_id . '">Hapus</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $users = UsersModel::whereDoesntHave('alumni')->get();
        return view('alumni.create_ajax', compact('users'));
    }

    public function store_ajax(Request $request)
    {
        \Log::info('Store Request Data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id|unique:alumni,user_id',
            'nama' => 'nullable|string|max:50',
            'nim' => 'nullable|string|max:50',
            'email' => 'required|email|max:20|unique:alumni,email',
            'no_hp' => 'required|string|max:20',
            'program_studi' => 'nullable|string|max:20',
            'tahun_lulus' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors: ', $validator->errors()->toArray());
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            AlumniModel::create($request->only([
                'user_id',
                'nama',
                'nim',
                'email',
                'no_hp',
                'program_studi',
                'tahun_lulus'
            ]));
            \Log::info('Create Success for user_id: ' . $request->user_id);

            return response()->json([
                'status' => true,
                'message' => 'Data alumni berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            \Log::error('Create Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem!'
            ], 500);
        }
    }

    public function edit_ajax($id)
    {
        $alumni = AlumniModel::with('user')->findOrFail($id);
        $users = UsersModel::all();
        \Log::info('Alumni Data: ', $alumni->toArray()); // Tambahkan log untuk debugging
        return view('alumni.edit_ajax', compact('alumni', 'users'));
    }

    public function update_ajax(Request $request, $id)
    {
        \Log::info('Update Request Data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id|unique:alumni,user_id,' . $id . ',alumni_id',
            'nama' => 'nullable|string|max:50',
            'nim' => 'nullable|string|max:50',
            'email' => 'required|email|max:20|unique:alumni,email,' . $id . ',alumni_id',
            'no_hp' => 'required|string|max:20',
            'program_studi' => 'nullable|string|max:20',
            'tahun_lulus' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors: ', $validator->errors()->toArray());
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $alumni = AlumniModel::findOrFail($id);
            $alumni->update($request->only([
                'nama',
                'nim',
                'email',
                'no_hp',
                'program_studi',
                'tahun_lulus'
            ]));
            \Log::info('Update Success for alumni_id: ' . $id);

            return response()->json([
                'status' => true,
                'message' => 'Data alumni berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            \Log::error('Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem!'
            ], 500);
        }
    }

    public function destroy_ajax($id)
    {
        $alumni = AlumniModel::findOrFail($id);
        $alumni->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data alumni berhasil dihapus'
        ]);
    }
}
