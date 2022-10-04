<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
 
class ToDoController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('toDo');
    }
    public function addData(Request $request)
    {
        $input = $request->input('input');
        if(DB::insert('insert into input (item) values(?)',[$input])){
            $id = DB::getPdo()->lastInsertId();
            echo json_encode(['msg'=>'done','id'=>$id]);
        }else{
            echo json_encode('error');
        }
        
    }
    public function delData(Request $request)
    {
        $id = $request->input('id');
        
        if(DB::table('input')->where('id', $id)-> delete()){
            echo json_encode('done');
        }else{
            echo json_encode('error');
        }
        
    }
    public function listData(Request $request)
    {
        $data['list'] = DB::table('input')->get();
        
        if($data){
            echo json_encode(['msg'=>'done','data'=>$data]);
        }else{
            echo json_encode('error');
        }

    }
}