<?php

namespace App\Http\Controllers;

use App\Models\booktable;
use App\Models\data;
use App\Models\DeadLeads;
use App\Models\FollowUpLeads;
use App\Models\User;
use App\Models\UserLeadsPool;
use App\Models\UserLeadsPoolComment;
use App\Models\WonLeads;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LeadsPoolController extends Controller
{
    public function leadspoolindex()
    {
        $datasource = booktable::select('source')->groupBy('source')->pluck('source');
        $campaignsources = booktable::where('campaign_name', '!=', '')->select('campaign_name')->groupBy('campaign_name')->pluck('campaign_name');
        return view('leadspooldata.leadsbool', ['datasource' => $datasource, 'campaignsources' => $campaignsources]);
    }

    public function leadspool(Request $request)
    {
        $campaignsource = $request->campaignsource;
        $datasource = $request->datasource;

        if ($campaignsource == null && $datasource == null) {
            $data = booktable::where('assigned', 0)->get();
        } else if ($campaignsource != null && $datasource == null) {
            $data = booktable::where('campaign_name', $campaignsource)->where('assigned', 0)->get();
        } else if ($campaignsource == null && $datasource != null) {
            $data = booktable::where('source', $datasource)->where('assigned', 0)->get();
        } else {
            $data = booktable::where('campaign_name', $campaignsource)->where('assigned', 0)->where('source', $datasource)->get();
        }

        $users = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($user) {
                return  date('d-m-Y h-m-s', strtotime($user->created_at));
            })
            ->addColumn('action', function ($row) {
                if ($row->is_enquiry_customer) {
                    $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                    $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
                    return $actionBtn;
                }
                else if ($row->created_by == 0){
                    $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                    return $actionBtn;
                }
            })
            ->editColumn('created_by', function ($row) use ($users) {
                $user = $users->where('id', $row->created_by)->first();
                if ($user != null)
                    return $user->name;
                else
                    return null;
            })
            ->make(true);
    }

    public function leadspooluserhomeindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = booktable::select('source')->groupBy('source')->get();
        $userstates = config('app.user_status');
        return view('leadspooldata.leadspooluserhome', ['agentnames' => $agentnames, 'datasources' => $datasources, 'userstates' => $userstates]);
    }

    public function assignagentleadspoolindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = booktable::select('source')->groupBy('source')->get();
        return view('leadspooldata.assignagentleadspooldata', ['agentnames' => $agentnames, 'datasources' => $datasources]);
    }

    public function showassignedagentleadspoolindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = booktable::select('source')->groupBy('source')->get();
        return view('leadspooldata.showassignedagentleadspooldata', ['agentnames' => $agentnames, 'datasources' => $datasources]);
    }

    public function leadspooluserhomedata(Request $request)
    {
        $data = [];

        $agentname = $request->agentname;
        $datasource = $request->datasource;

        if ($agentname == null && $datasource == null) {
            $data = booktable::all();
        } else if ($agentname != null && $datasource == null) {
            $data = booktable::where('created_by', $agentname);
        } else if ($agentname == null && $datasource != null) {
            $data = booktable::where('source', $datasource);
        } else {
            $data = booktable::where('source', $datasource)->where('created_by', $agentname);
        }
        $users = User::all();

        $temp0 = Auth::user()->userleadsbooldata()->pluck('leads_pool_id');
        $data = $data->whereIn('id', $temp0);
        $temp = Auth::user()->userleadspooldatacomment()->pluck('leads_pool_id');
        $data = $data->whereNotIn('id', $temp);
        return DataTables::of($data)
            ->addcolumn('check', function () {
                return null;
            })
            ->editColumn('created_at', function ($user) {
                return  date('d-m-Y h-m-s', strtotime($user->created_at));
            })
            ->editColumn('created_by', function ($row) use ($users) {
                $user = $users->where('id', $row->created_by)->first();
                if ($user != null)
                    return $user->name;
                else
                    return null;
            })
            ->addColumn('dataid', function ($row) {
                return $row->id;
            })
            ->rawColumns(['check'])
            ->make(true);
        // ->addColumn('hascomment', function ($row) use ($comments) {
        //     $hascomm = $comments->where('data_id', $row->id)->count();
        //     if ($hascomm > 0)
        //         return true;
        //     else
        //         return false;
        // })
    }

    public function showassignedagentleadspooldata(Request $request)
    {
        $data = booktable::get();

        $datasource = $request->datasource;
        $userid = $request->userid;

        if ($datasource != null) {
            $data = booktable::where('source', $datasource);
        }

        $user = User::find($userid);
        if ($user != null) {
            $temp = $user->leadspooldata()->pluck('leads_pool_id');
            $data = $data->whereIn('id', $temp);
        } else {
            $data = [];
        }

        $users = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_by', function ($row) use ($users) {
                $user = $users->where('id', $row->created_by)->first();
                if ($user != null)
                    return $user->name;
                else
                    return null;
            })
            ->editColumn('created_at', function ($user) {
                return  date('d-m-Y h-m-s', strtotime($user->created_at));
            })
            ->make(true);
    }

    public function searchforagentleadspooldata(Request $request)
    {
        $data = booktable::query();

        // $agentname = $request->agentname;
        $datasource = $request->datasource;
        // $userid = $request->userid;

        // if ($agentname == null && $datasource == null) {
        //     $data = booktable::all();
        // } else if ($agentname != null && $datasource == null) {
        //     $data = booktable::where('created_by', $agentname);
        // } else if ($agentname == null && $datasource != null) {
        //     $data = booktable::where('source', $datasource);
        // } else {
        //     $data = booktable::where('source', $datasource)->where('created_by', $agentname);
        // }

        if ($datasource != null)
            $data = booktable::where('source', $datasource);

        // $user = User::find($userid);
        // if ($user != null) {
        //     // $temp = $user->leadspooldata()->pluck('leads_pool_id');
        //     // $data = $data->whereNotIn('id', $temp);
        // }
        $data = $data->where('assigned', 0);
        return DataTables::of($data)
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check'])
            ->make(true);
    }

    public function assignagentleadspooldata(Request $request)
    {
        $request->validate(
            [
                'userid' => 'required|exists:users,id',
                'data' => 'required|json'
            ],
            [
                'data.required' => 'please select data you want to assign !!'
            ]
        );

        try {
            $userdata = [];
            $data = json_decode($request->data);

            // $userfound = UserLeadsPool::where('user_id', $request->userid)->count();
            // if ($userfound > 0) {
            //     $currentuserdata = UserLeadsPool::select('leads_pool_id')->where('user_id', $request->userid)->get();
            //     $repateddatalist = [];
            //     $notrepateddatalist = [];
            //     foreach ($data as $key => $item) {
            //         if ($currentuserdata->contains('leads_pool_id', $item))
            //             $repateddatalist[] = $item;
            //         else
            //             $notrepateddatalist[] = $item;
            //     }

            //     foreach ($notrepateddatalist as $key => $item) {
            //         $userdata[] = new UserLeadsPool([
            //             'user_id' => $request->userid,
            //             'leads_pool_id' => $item
            //         ]);
            //     }
            //     $user = User::find($request->userid);
            //     $user->userleadspooldata()->saveMany($userdata);

            //     if (count($repateddatalist) > 0) {
            //         $request->session()->remove('repateddatalist');
            //         $request->session()->push('repateddatalist', $repateddatalist);
            //         return response()->json(['success' => false, 'message' => 'There are some duplicated data']);
            //     } else
            //         return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
            // } else {
            // }
            foreach ($data as $key => $item) {
                $userdata[] = new UserLeadsPool([
                    'user_id' => $request->userid,
                    'leads_pool_id' => $item
                ]);
            }
            $user = User::find($request->userid);
            $user->userleadspooldata()->saveMany($userdata);
            // update data status
            $status = booktable::whereIn('id', $data)->update(['assigned' => true]);
            return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error while assign data for user']);
        }
    }

    public function addleadspoolcomment(Request $request)
    {
        // if user status is interested from data then we add user to leads pool and set source as customer enquiry
        // if user status is interested from leads pool then add
        // if user status is not interseted then add to dead pools
        // if user status is set appointment then after appointment we save it in won deal

        // data_status:
        // 0 non qualified
        // 1 qualified
        // 2 intersted
        // 3 set apponitment
        // 4 not not interested
        // 5 won leads
        // 6 dead leads
        // 7 qualified leads
        // 8 leads pool
        // 9 follow up leads

        $request->validate([
            'comment' => 'required'
        ]);

        try {
            if ($request->appointment_date != null && $request->userstatus == "Set appointment") {
                // add comment
                UserLeadsPoolComment::create([
                    'leads_pool_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus,
                    'appointment_date' => $request->appointment_date
                ]);

                // change data status to won leads
                $data = booktable::find($request->checkedrow);

                // add data to own leads
                WonLeads::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'number_of_beds' => $data->number_of_beds,
                    'source' => $data->source,
                    'project' => $data->project,
                    'title' => $data->title,
                    'data_id' => $data->data_id,
                    'previous_state' => '8',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);

                // change data status to won leads
                data::where('id', $data->data_id)->update(['data_status' => 5]);
            } else if ($request->userstatus == "Not interested") {
                // add comment
                UserLeadsPoolComment::create([
                    'leads_pool_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);
                // add data to own leads
                $data = booktable::find($request->checkedrow);
                DeadLeads::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'number_of_beds' => $data->number_of_beds,
                    'source' => $data->source,
                    'project' => $data->project,
                    'title' => $data->title,
                    'data_id' => $data->data_id,
                    'previous_state' => '8',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);

                // change data status to dead leads
                data::where('id', $data->data_id)->update(['data_status' => 6]);
            } else {
                // add comment
                UserLeadsPoolComment::create([
                    'user_id' => Auth::user()->id,
                    'leads_pool_id' => $request->checkedrow,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);

                // change data status to leads pool
                $data = booktable::find($request->checkedrow);

                // add data to follow up leads
                FollowUpLeads::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'number_of_beds' => $data->number_of_beds,
                    'source' => $data->source,
                    'project' => $data->project,
                    'data_id' => $data->data_id,
                    'title' => $data->title,
                    'data_id' => $data->data_id,
                    'previous_state' => '8',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);

                // change data status to follow up leads
                data::where('id', $data->data_id)->update(['data_status' => 9]);
                // $data->delete();
            }

            return response()->json(['success' => true, 'message' => 'Comment entered successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error happen call system admin']);
        }
    }

    public function showleadspooldatacommentsindex()
    {
        $userstatus = config('app.user_status');
        $datasources = booktable::select('source')->groupBy('source')->get();
        return view('leadspooldata.showleadspooldatacomment', ['userstatus' => $userstatus, 'datasources' => $datasources]);
    }

    public function showleadspooldatacomments(Request $request)
    {
        $data = [];
        $userstatus = $request->userstatus;
        $datasource = $request->datasource;
        $agentname = $request->agentname;
        $userdatacomments = UserLeadsPoolComment::all();
        $users = User::all();

        try {
            if (Auth::user()->isagent() || Auth::user()->isconsultant()) {
                $temp = UserLeadsPoolComment::select('leads_pool_id');
                if ($userstatus != null)
                    $temp = $temp->where('userstatus', $userstatus);
                $temp = $temp->groupBy('leads_pool_id');
                $temp = $temp->pluck('leads_pool_id');
                if ($datasource == null)
                    $data = booktable::whereIn('id', $temp)->get();
                else
                    $data = booktable::whereIn('id', $temp)->where('source', $datasource)->get();
                return DataTables::of($data)
                    ->addColumn('userstatus', function ($row) {
                        $userdata = UserLeadsPoolComment::select(DB::raw("COUNT(*) as count_row"), 'userstatus')->where('leads_pool_id', $row->id)->groupBy('userstatus')->orderBy('count_row', 'desc')->pluck('userstatus', 'count_row')->first();
                        if (!is_null($userdata))
                            return $userdata;
                    })
                    ->addColumn('comments', function ($row) use ($userdatacomments, $users, $userstatus) {
                        if ($userstatus == null)
                            $values = $userdatacomments->where('leads_pool_id', $row->id);
                        else
                            $values = $userdatacomments->where('leads_pool_id', $row->id)->where('userstatus', $userstatus);
                        $res = "";
                        foreach ($values as $key => $value) {
                            $user = $users->where('id', $value->user_id)->first();
                            if ($user != null) {
                                if ($value->userstatus == "Interested")
                                    $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Not interested")
                                    $comment = '<div class="row ml-1" style="background-color:red"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Not answer")
                                    $comment = '<div class="row ml-1" style="background-color:brown"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Number unavailable/Not working for call/Incomplete no")
                                    $comment = '<div class="row ml-1" style="background-color:orange"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Switch off/Line busy/Wrong number/Invalid number")
                                    $comment = '<div class="row ml-1" style="background-color:#AED6F1"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Others")
                                    $comment = '<div class="row ml-1" style="background-color:#DAF7A6"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Set appointment")
                                    $comment = '<div class="row ml-1" style="background-color:#F9C4F8"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else
                                    $comment = '<div class="row ml-1"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                $res .= $comment;
                            }
                        }
                        return $res;
                    })
                    ->rawColumns(['comments'])
                    ->editColumn('created_by', function ($row) use ($users) {
                        $userid = $row->userleadspooldatacomments()->pluck('user_id')->first();
                        $user = $users->where('id', $userid)->first();
                        if ($user != null)
                            return $user->name;
                        else
                            return null;
                    })
                    ->make(true);
            } else if (Auth::user()->isadmin()) {
                if ($agentname == null)
                    $temp = UserLeadsPoolComment::select('leads_pool_id');
                else {
                    $temp = UserLeadsPoolComment::where('user_id', $agentname)->select('leads_pool_id');
                }

                if ($userstatus != null)
                    $temp = $temp->where('userstatus', $userstatus);
                $temp = $temp->groupBy('leads_pool_id');
                $temp = $temp->pluck('leads_pool_id');
                if ($datasource == null)
                    $data = booktable::whereIn('id', $temp)->get();
                else
                    $data = booktable::whereIn('id', $temp)->where('source', $datasource)->get();

                return DataTables::of($data)
                    ->addColumn('userstatus', function ($row) {
                        $userdata = UserLeadsPoolComment::select(DB::raw("COUNT(*) as count_row"), 'userstatus')->where('leads_pool_id', $row->id)->groupBy('userstatus')->orderBy('count_row', 'desc')->pluck('userstatus', 'count_row')->first();
                        if (!is_null($userdata))
                            return $userdata;
                    })
                    ->addColumn('comments', function ($row) use ($userdatacomments, $users, $userstatus) {
                        $values = $userdatacomments->where('leads_pool_id', $row->id);
                        if ($userstatus != null)
                            $values = $userdatacomments->where('leads_pool_id', $row->id)->where('userstatus', $userstatus);

                        // if ($agentname != null)
                        //     $values = $userdatacomments->where('user_id', $agentname);

                        $res = "";
                        foreach ($values as $key => $value) {
                            $user = $users->where('id', $value->user_id)->first();
                            if ($user != null) {
                                if ($value->userstatus == "Interested")
                                    $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Not interested")
                                    $comment = '<div class="row ml-1" style="background-color:red"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Not answer")
                                    $comment = '<div class="row ml-1" style="background-color:brown"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Number unavailable/Not working for call/Incomplete no")
                                    $comment = '<div class="row ml-1" style="background-color:orange"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Switch off/Line busy/Wrong number/Invalid number")
                                    $comment = '<div class="row ml-1" style="background-color:#AED6F1"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Others")
                                    $comment = '<div class="row ml-1" style="background-color:#DAF7A6"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else if ($value->userstatus == "Set appointment")
                                    $comment = '<div class="row ml-1" style="background-color:#F9C4F8"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                else
                                    $comment = '<div class="row ml-1"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row ml-1"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                                $res .= $comment;
                            }
                        }
                        return $res;
                    })
                    ->rawColumns(['comments'])
                    ->editColumn('created_by', function ($row) use ($users) {
                        $userid = $row->userleadspooldatacomments()->pluck('user_id')->first();
                        $user = $users->where('id', $userid)->first();
                        if ($user != null)
                            return $user->name;
                        else
                            return null;
                    })
                    ->make(true);
            }
        } catch (Exception $th) {
            dd($th);
        }
    }

    public function getleadspooldatacommentsinfo(Request $request)
    {
        $user = User::find($request->agentname);
        $userstatus = $request->userstatus;
        $datasource = $request->datasource;
        $swoflibuwonuinnu = 0;
        $unavnotworkincomp = 0;
        $others = 0;
        $interested = 0;
        $notinterested = 0;
        $notanswer = 0;
        $setappointment = 0;
        $total = 0;

        $data = DB::table('booktables')->join('user_leads_pool_comments', 'booktables.id', '=', 'leads_pool_id');

        if ($datasource != null)
            $data->where('source', $datasource);

        if ($user != null)
            $data->where('user_leads_pool_comments.user_id', $request->agentname);

        if ($userstatus != null)
            $data->where('user_leads_pool_comments.userstatus', $userstatus);

        $data = $data->get();

        $setappointment = $data->where('userstatus', 'Set appointment')->count();
        $swoflibuwonuinnu = $data->where('userstatus', 'Switch off/Line busy/Wrong number/Invalid number')->count();
        $unavnotworkincomp = $data->where('userstatus', 'Number unavailable/Not working for call/Incomplete no')->count();
        $others = $data->where('userstatus', 'Others')->count();
        $interested = $data->where('userstatus', 'Interested')->count();
        $notinterested = $data->where('userstatus', 'Not interested')->count();
        $notanswer = $data->where('userstatus', 'Not answer')->count();

        $total = $swoflibuwonuinnu + $unavnotworkincomp + $others + $interested +  $notinterested + $notanswer + $setappointment;
        return response()->json([
            'succssess' => true,
            'swoflibuwonuinnu' => $swoflibuwonuinnu,
            'unavnotworkincomp' => $unavnotworkincomp,
            'others' => $others,
            'interested' => $interested,
            'notinterested' => $notinterested,
            'notanswer' => $notanswer,
            'setappointment' => $setappointment,
            'total' => $total
        ]);
    }

    public function showuserleadspooldatacommentsindex()
    {
        $userstatus = config('app.user_status');
        $agentname = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = booktable::select('source')->groupBy('source')->get();
        return view('leadspooldata.showuserleadspooldatacomment', ['userstatus' => $userstatus, 'datasources' => $datasources, 'agentname' => $agentname]);
    }
}
