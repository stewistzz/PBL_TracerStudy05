<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;


class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = UsersModel::select(['user_id', 'username', 'role']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex justify-content-center gap-2 mr-2">
                            <button type="button" class="btn btn-warning py-2 btn-edit" data-id="' . $row->user_id . '">
                                <i class="mdi mdi-pencil"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-hapus" data-id="' . $row->user_id . '">
                                <i class="mdi mdi-delete"></i> Hapus
                            </button>
                        </div>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        // Bila bukan AJAX, tampilkan halaman biasa
        return view('user.index');
    }

    public function store_ajax(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|max:100',
            'role'     => 'required|in:admin,alumni'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            UsersModel::create([
                'username' => $request->username,
                'password' => $request->password,
                'role'     => $request->role
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User berhasil ditambahkan'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan user'
            ], 500);
        }
    }


    public function create_ajax()
    {
        return view('user.create_ajax');
    }

    public function edit_ajax($id)
    {
        try {
            $users = UsersModel::findOrFail($id);
            return view('user.edit_ajax', compact('users'));
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }
    }

    public function show_ajax($id)
    {
        try {
            $data = UsersModel::findOrFail($id);
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
    public function update_ajax(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|max:100',
            'role'     => 'required|in:admin,alumni'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $users = UsersModel::findOrFail($id);
            $users->update([
                'username' => $request->username,
                'password' => $request->password,
                'role' => $request->role
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User berhasil diperbarui'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui user'
            ], 500);
        }
    }

    public function destroy_ajax($id)
    {
        try {
            $users = UsersModel::findOrFail($id);
            $users->delete();

            return response()->json([
                'status' => true,
                'message' => 'User berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus user'
            ], 500);
        }
    }

    public function import()
    {
        return view('user.import');
    }

    public function import_ajax(Request $request)
    {
        $rules = [
            'file_user' => ['required', 'mimes:xlsx,xls', 'max:1024'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            $file = $request->file('file_user');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $insert = [];
            $dataTampil = [];
            $header = array_shift($rows); // Buang baris header

            foreach ($rows as $row) {
                if (!empty($row[0])) {
                    $insert[] = [
                        'username' => $row[0],
                        'password' => Hash::make($row[1]),
                        'role' => $row[2],
                        'created_at' => now(),
                    ];
                    // hanya username & role yang ingin ditampilkan
                    $dataTampil[] = [
                        'username' => $row[0],
                        'role' => $row[2],
                    ];
                }
            }

            if (!empty($insert)) {
                UsersModel::insertOrIgnore($insert);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimpor: ' . count($insert) . ' user',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kosong atau tidak valid',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan saat membaca file: ' . $e->getMessage(),
            ]);
        }
    }
}
