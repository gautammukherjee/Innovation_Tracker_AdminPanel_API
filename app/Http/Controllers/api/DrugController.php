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

    //Get Drugs Lists section
    public function getDrugsLists(){
        $sql = "select distinct d.drug_id,d.name as drug_name, description, d.created_at FROM news_drug_rels ndr join drugs d on ndr.drug_id=d.drug_id where ndr.deleted=0 and d.deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsRecords' => $result
        ]);
    }

    //Get Drugs Synonms Lists section
    public function getDrugsSynsLists(){
        $sql = "SELECT d.drug_id, d.name as drug_name, ds.name as drug_syn_name FROM drugs d join news_drug_rels ndr on ndr.drug_id=d.drug_id join drug_syns ds on d.drug_id=ds.drug_id where ds.deleted=0 and d.deleted=0 ORDER BY d.drug_id ASC";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugsSynsRecords' => $result
        ]);
    }

    //////////////////// Backend API ////////////////////////////////

    //Get Genes Lists section
    public function getBackendDrugsLists(){
        $sql = "select d.drug_id,d.name as drug_name, description, d.created_at FROM testing.drugs d where d.deleted=0";
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

    //Get Drug Lists section not exist in new_drug_relation table
    public function getDrugListsNotExistRl(Request $request, $id){
        $sql = "select n.drug_id, n.name from testing.drugs n where n.deleted=0 and not exists (select 1 from testing.news_drug_rels dr where dr.drug_id=n.drug_id and dr.news_id=".$id.")";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugRecords' => $result
        ]);
    }

    //Get Drug Lists section exist in new_drug_relation table
    public function getDrugListsExistRl(Request $request, $id){
        $sql = "select n.drug_id, n.name from testing.drugs n where n.deleted=0 and exists (select 1 from testing.news_drug_rels dr where dr.drug_id=n.drug_id and dr.news_id=".$id.")";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'drugExistRecords' => $result
        ]);
    }
}
