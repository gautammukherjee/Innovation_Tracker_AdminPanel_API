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
        $sql = "SELECT * FROM testing.drugs WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Add Drugs Lists section
    public function addDrugs(Request $request){
        $sql = "INSERT INTO testing.drugs (name, description) values ('".$request->name."', '".$request->description."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateDrugs(Request $request, $id){
        $sql = "UPDATE testing.drugs SET name = '".$request->name."', description ='".$request->description."' WHERE drug_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteDrugs($id){
        $sql = "UPDATE testing.drugs SET deleted=1 WHERE drug_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsDeleted' => $result
        ]);
    }
}
