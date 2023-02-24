<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class DrugController extends Controller
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
    public function getDrugsLists(){        
        $sql = "SELECT * FROM drugs WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
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
