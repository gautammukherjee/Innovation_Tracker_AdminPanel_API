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
        $sql = "SELECT drug_id, name as drug_name, description, created_at FROM testing.drugs WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Add Drugs Lists section
    public function addDrugs(Request $request){
        $sql = "INSERT INTO testing.drugs (name, description) values ('".pg_escape_string($request->name)."', '".pg_escape_string($request->description)."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateDrugs(Request $request, $id){
        $sql = "UPDATE testing.drugs SET name = '".pg_escape_string($request->name)."', description ='".pg_escape_string($request->description)."' WHERE drug_id=".$id;
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

    //Drug Synonm Lists/add/edit/delete

    //Get Drug Synonm Lists section
    public function getDrugSynLists(){
        $sql = "SELECT drug_syn_id, drug_id, name, created_at FROM testing.drug_syns WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Add Drug Lists section
    public function addDrugSyn(Request $request){
        $sql = "INSERT INTO testing.drug_syns (drug_id,name) values ('".$request->drug_id."', '".pg_escape_string($request->name)."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Add Drugs Lists section
    public function updateDrugSyn(Request $request, $id){
        $sql = "UPDATE testing.drug_syns SET drug_id='".$request->drug_id."', name = '".pg_escape_string($request->name)."' WHERE drug_syn_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Delete Drugs Lists section
    public function deleteDrugSyn($id){
        $sql = "UPDATE testing.drug_syns SET deleted=1 WHERE drug_syn_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugDeleted' => $result
        ]);
    }
}
