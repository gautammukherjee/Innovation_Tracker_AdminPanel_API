<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class CompanyController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    public function _construct(){
        // $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    //Get Genes Lists section
    public function getCompaniesLists(){        
        $sql = "SELECT * FROM companys WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companiesRecords' => $result
        ]);
    }


    //Logout section
    // public function logout(){
    //     auth()->logout();
    //     return response()->json([
    //         'message'=>'User Logged out',
    //     ]);
    // }
}
