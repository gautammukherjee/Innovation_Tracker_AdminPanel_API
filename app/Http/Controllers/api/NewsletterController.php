<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class NewsletterController extends Controller
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
        $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    //Get Genes Lists section
    public function getNewsletterLists(){
        $sql = "SELECT ns.news_id, ns.user_id, ns.publication_date, ns.title, ns.description, ns.url, ns.webhose_id, ns.textindex_td, ns.created_at, c.name as user_name FROM testing.newss as ns LEFT JOIN users as c ON ns.user_id=c.user_id WHERE ns.deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsletterRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function addNewsletter(Request $request){
        $sql = "INSERT INTO testing.newss (user_id, publication_date, title, description, url) values (".auth()->user()->user_id.", '".$request->publication_date."', '".$request->title."','".$request->description."', '".$request->url."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newssRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateNewsletter(Request $request, $id){
        $sql = "UPDATE newss SET user_id = ".auth()->user()->user_id.", publication_date = '".$request->publication_date."', title = '".$request->title."', description ='".$request->description."', url='".$request->url."' WHERE news_id=".$id;
        //echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newssRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteNewsletter($id){
        $sql = "UPDATE testing.newss SET deleted=1 WHERE news_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newssDeleted' => $result
        ]);
    }

}
