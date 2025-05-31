<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KepuasanController extends Controller
{
    public function index()
    {
        return view('kepuasan.index');
    }
}