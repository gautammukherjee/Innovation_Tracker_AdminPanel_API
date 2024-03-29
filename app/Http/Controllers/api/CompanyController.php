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

    public function _construct()
    {
        // $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    //Get Genes Lists section
    public function getCompaniesTypes()
    {
        $sql = "select ct.company_type_id,ct.name from company_types ct where ct.deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companiesTypeRecords' => $result
        ]);
    }

    //Get Genes Lists section
    public function getCompaniesLists()
    {
        // $sql = "SELECT c.company_id, c.company_type_id, c.name as company_name, c.description, c.created_at, ct.name as ct_name FROM testing.companys as c LEFT JOIN company_types as ct ON c.company_type_id=ct.company_type_id WHERE c.deleted=0";
        $sql = "select distinct c.company_id,c.name as company_name, c.description, c.created_at, ct.name as ct_name from news_company_rels ncr join companys c on ncr.company_id=c.company_id LEFT JOIN company_types as ct ON c.company_type_id=ct.company_type_id where ncr.deleted=0 and c.deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companiesRecords' => $result
        ]);
    }

    //////////////////// Backend API /////////////////////////////////
    //Get Genes Lists section
    public function getBackendCompaniesLists()
    {
        // $sql = "SELECT c.company_id, c.company_type_id, c.name as company_name, c.description, c.created_at, ct.name as ct_name FROM testing.companys as c LEFT JOIN company_types as ct ON c.company_type_id=ct.company_type_id WHERE c.deleted=0";
        $sql = "select c.company_id,c.name as company_name, c.company_type_id, c.description, c.created_at, ct.name as ct_name from testing.companys c LEFT JOIN testing.company_types as ct ON c.company_type_id=ct.company_type_id where c.deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companiesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function addCompanies(Request $request)
    {
        $sql = "INSERT INTO testing.companys (company_type_id, name, description) values ('" . $request->company_type_id . "', '" . pg_escape_string($request->name) . "', '" . pg_escape_string($request->description) . "')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companyRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateCompanies(Request $request, $id)
    {

        $sql = "UPDATE testing.companys SET company_type_id='" . $request->company_type_id . "', name = '" . pg_escape_string($request->name) . "', description ='" . pg_escape_string($request->description) . "' WHERE company_id=" . $id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companyRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteCompanies($id)
    {
        $sql = "UPDATE testing.companys SET deleted=1 WHERE company_id=" . $id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companyDeleted' => $result
        ]);
    }

    //Get Company Lists section not exist in new_company_relation table
    public function getCompanyListsNotExistRl(Request $request, $id)
    {
        $sql = "select n.company_id, n.name from testing.companys n where n.deleted=0 and not exists (select 1 from testing.news_company_rels cr where cr.company_id=n.company_id and cr.news_id=" . $id . ")";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companyRecords' => $result
        ]);
    }

    //Get Company Lists section exist in new_company_relation table
    public function getCompanyListsExistRl(Request $request, $id)
    {
        $sql = "select n.company_id, n.name from testing.companys n where n.deleted=0 and exists (select 1 from testing.news_company_rels cr where cr.company_id=n.company_id and cr.news_id=" . $id . ")";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'companyExistRecords' => $result
        ]);
    }


}