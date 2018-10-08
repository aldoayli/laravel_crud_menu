<?php

namespace App\Http\Controllers;


use Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\assignmenu; 
use Response;
use Illuminate\Support\Facades\Auth;

class AssignMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['title'] = 'Assign Menu';
        $data['assign_by_id'] = Auth::id();
        $data['assign_by_email'] = Auth::user()->email;
        $data['user_list'] = DB::select(DB::raw("SELECT * FROM users order by id asc"));

        $data['menu_list'] = DB::select(DB::raw("SELECT * from menu ORDER by parent_id,id asc"));
        

        $menuarr = array();
        $x = 0;
        while ( $x < count($data['menu_list'])) {
            $menuarr[] = array(
                                'id' => $data['menu_list'][$x]->id, 
                                'pid' => $data['menu_list'][$x]->parent_id, 
                                'name' => $data['menu_list'][$x]->menu, 
                                );
            $x++;
        };

        $data['menu_list'] = json_encode($menuarr);  

        return view('assign_menu.index',$data);
    }      
    public function datatables()
    {
        $datatables = DB::select(DB::raw("SELECT t1.* , t2.email as assign_to_email, t3.email as assign_by_email
                    FROM assign_menu t1
                    LEFT JOIN users t2 ON t2.id = t1.assign_to
                    LEFT  JOIN users t3 on t3.id = t1.assign_by order by t1.id desc"));



        return Datatables::of($datatables)
            ->addColumn('action', function ($datatables) {
                return '<div style="width: 130px !important;"><a class="btn btn-xs btn-outline-success view-modal action-icon"><i class="fa fa-search"></i></a> <a class="btn btn-xs btn-outline-info edit-modal action-icon"><i class="fa fa-edit"></i></a> <a class="btn btn-xs btn-outline-danger delete-modal action-icon"><i class="fa fa-trash"></i></a></div>';
            })
            ->make(true);
    }

    public function getunassign()
    {
        $data = DB::select(DB::raw("SELECT t1.*
                    FROM users t1
                    LEFT JOIN assign_menu t2 ON t2.assign_to = t1.id
                    WHERE t2.assign_to IS NULL
                "));
        return $data;
    }

    public function gettreemenu()
    {

        $data['menu_list'] = DB::select(DB::raw("SELECT * from menu  ORDER by parent_id,id asc"));
        $data['selected_menu'] = DB::select(DB::raw("SELECT * from menu where id in(".$_POST['id'].")"));

        $menuarrselected = array();
        $y = 0;
        while ( $y < count($data['selected_menu'])) {
            $menuarrselected[] = $data['selected_menu'][$y]->id;
            $y++;
        };


        $menuarr = array();
        $x = 0;
        while ( $x < count($data['menu_list'])) {
            if (in_array($data['menu_list'][$x]->id, $menuarrselected)) {
                    $menuarr[] = array(
                                'id' => $data['menu_list'][$x]->id, 
                                'pid' => $data['menu_list'][$x]->parent_id, 
                                'name' => $data['menu_list'][$x]->menu, 
                                'checked' => 'checked',
                                'expand' => 'expand',
                                );

            } else {
                    $menuarr[] = array(
                                'id' => $data['menu_list'][$x]->id, 
                                'pid' => $data['menu_list'][$x]->parent_id, 
                                'name' => $data['menu_list'][$x]->menu, 
                                );

            };


            $x++;
        };


        return json_encode($menuarr);         
    }
    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
                // 'id' => 'required',
                'assign_by' => 'required',
                'assign_to' => 'required',
                'menu_id' => 'required',
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
                $newdata = new assignmenu([
                    //'id'    =>  $request->get('id'),
                    'assign_by'     =>  $request->get('assign_by'),
                    'assign_to'     =>  $request->get('assign_to'),
                    'menu_id'     =>  $request->get('menu_id'),
                ]);
                $newdata->save();
                $success_output = '<div class="alert alert-success alert-dismissible fade show" role="alert">Data inserted successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            }
            if($request->get('button_action') == 'update')
            {
	                $updatedata = assignmenu::find($request->get('id'));
                    $updatedata->assign_by = $request->get('assign_by');
                    $updatedata->assign_to = $request->get('assign_to');
                    $updatedata->menu_id = $request->get('menu_id');
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
        $removedata = assignmenu::find($request->input('id'));
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