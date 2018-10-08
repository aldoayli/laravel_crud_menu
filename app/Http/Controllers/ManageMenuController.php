<?php

namespace App\Http\Controllers;


use Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\menu; 
use Response;

class ManageMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['title'] = 'Manage Menu';
        return view('manage_menu.index',$data);
    }      
    public function datatables()
    {
        $datatables = DB::select(DB::raw("SELECT t1.* , t2.menu as parent
                    FROM menu t1
                    LEFT JOIN menu t2 ON t2.id = t1.parent_id"));      




        return Datatables::of($datatables)
            ->addColumn('action', function ($datatables) {
                return '<div style="width: 130px !important;"><a class="btn btn-xs btn-outline-success view-modal action-icon"><i class="fa fa-search"></i></a> <a class="btn btn-xs btn-outline-info edit-modal action-icon"><i class="fa fa-edit"></i></a> <a class="btn btn-xs btn-outline-danger delete-modal action-icon"><i class="fa fa-trash"></i></a></div>';
            })
            ->make(true);
    }

    public function getparent()
    {
        $data = DB::select(DB::raw("SELECT * FROM menu order by parent_id, id asc"));
        return $data;
    }

    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
                // 'id' => 'required',
                'parent_id' => 'required',
                'menu' => 'required',
        ]);
        $error_array = array();
        $success_output = '';
        
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages; 
            }
            //$error_array = '<div class="alert alert-danger">Please fill all required data.</div>';
        }
        else
        {
            $fileUrl = "";
            if($request->get('button_action') == "insert")
            {
                $newdata = new menu([
                    //'id'    =>  $request->get('id'),
                    'parent_id'     =>  $request->get('parent_id'),
                    'menu'     =>  $request->get('menu'),
                ]);
                $newdata->save();
                $success_output = '<div class="alert alert-success alert-dismissible fade show" role="alert">Data inserted successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            }
            if($request->get('button_action') == 'update')
            {
	                $updatedata = menu::find($request->get('id'));
                    $updatedata->parent_id = $request->get('parent_id');
                    $updatedata->menu = $request->get('menu');
                $updatedata->save();
                $success_output = '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            }
            
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }
    function removedata(Request $request)
    {
        $removedata = menu::find($request->input('id'));
        $error_array = array();
        $success_output = '';
        if($removedata->delete())
        {
            $success_output = '<div class="alert alert-warning alert-dismissible fade show" role="alert">Data deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        } else {
            $error_array = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error while delete data, please try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }
}