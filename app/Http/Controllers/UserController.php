<?php
// app/Http/Controllers/KategoriProfesiController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    
    
}
