<?php

namespace App\Http\Controllers;

use App\Imports\EnquriyCustomerImport;
use App\Imports\InventoryImport;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Data;
use App\Models\ge;
use App\Models\session as ModelsSession;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\DB;
use File;
use Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Str;
use App\Models\booktable;
use App\Models\BookView;
use App\Models\Campaign;
use App\Models\DeadLeads;
use App\Models\Inventory;
use App\Models\LandingAgent;
use App\Models\Payment;
use App\Models\Property;
use App\Models\QualifiedLeads;
use App\Models\User;
use App\Models\UserBook;
use App\Models\UserData;
use App\Models\UserDataComment;
use App\Models\WonLeads;
use Exception;
use Hamcrest\Type\IsNumeric;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Util\Json;
use Yajra\DataTables\DataTables;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showbooksindex()
    {
        $userstatus = config('app.user_status');
        $campaignsources = Campaign::pluck('name');
        return view('showbooks', ['userstatus' => $userstatus, 'campaignsources' => $campaignsources]);
    }

    public function leaderboardindex()
    {
        return view('leaderboard');
    }

    public function listpaymentsindex()
    {
        if (Auth::user()->isadmin()) {
            $users = User::select('id', 'name')->where('role_id', 'LIKE', '%4%')->get();
            $properties = Property::select('name')->get();
            return view('listpayments')->with('users', $users)->with('properties', $properties);
        } else if (Auth::user()->iscustomer()) {
            $properties = Property::select('name')->get();
            return view('listcustomerpayments')->with('properties', $properties);
        }
    }

    public function listpropertiesindex()
    {
        $users = User::select('id', 'name')->where('role_id', 'like', '%4%')->get();
        return view('listproperties')->with('users', $users);
    }

    public function listusersindex()
    {
        return view('listusers');
    }

    public function listproperties(Request $request)
    {
        $properties = Property::where('buyer_id', $request->userid)->orderBy('created_at', 'DESC')->get();
        $users = User::select('id', 'name')->where('role_id', 'like', '%4%')->get();
        return DataTables::of($properties)
            ->addIndexColumn()
            ->addColumn('Buyer_name1', function ($row) use ($users) {
                $buyername = $users->where('id', $row->buyer_id)->pluck('name')->first();
                return $buyername;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function listpayments(Request $request)
    {
        if (Auth::user()->isadmin()) {
            if ($request->propertyname == null) {
                $payments = Payment::where('buyer_id', $request->userid)->orderBy('created_at', 'DESC')->get();
                $users = User::select('id', 'name')->get();
            } else {
                $payments = Payment::where('buyer_id', $request->userid)->where('property', $request->propertyname)->orderBy('created_at', 'DESC')->get();
                $users = User::select('id', 'name')->get();
            }
            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('Buyer_name1', function ($row) use ($users) {
                    $buyername = $users->where('id', $row->buyer_id)->pluck('name')->first();
                    return $buyername;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else  if (Auth::user()->iscustomer()) {
            if ($request->propertyname == null) {
                $payments = Payment::where('buyer_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
            } else {
                $payments = Payment::where('buyer_id', Auth::user()->id)->where('property', $request->propertyname)->orderBy('created_at', 'DESC')->get();
            }
            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('Buyer_name1', function ($row) {
                    return Auth::user()->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function listusers(Request $request)
    {
        $users = User::where('role_id', 'not like', '%1%')->orderBy('created_at', 'DESC')->get();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function ($row) {
                if ($row->role_id == '2')
                    return 'Consultant';
                else if ($row->role_id == '3')
                    return 'Agent';
                else if ($row->role_id == '2,3')
                    return 'Consultant Agent';
                else if ($row->role_id == '4')
                    return 'Customer';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function updatecustomerindex($id)
    {
        $customer = booktable::where('id', $id)->first();
        return view('updatecustomer', ['username' => $customer->name, 'userphone' => $customer->phone, 'useremail' => $customer->email, 'projectname' => $customer->project_name, 'notes' => $customer->notes, 'userid' => $id]);
    }

    public function updateuserindex($id)
    {
        $user = User::where('id', $id)->first();
        return view('updateuser', ['username' => $user->name, 'userphone' => $user->phone, 'useremail' => $user->email, 'userid' => $id]);
    }

    public function assignagentforlanding()
    {
        $agents = User::where('role_id', 'like', '%3%')->select('id', 'name')->get();
        $campaigns = Campaign::select('id', 'name')->get();
        return view('assignagentforlandingpage', ['agents' => $agents, 'campaigns' => $campaigns]);
    }

    public function assignagenttolandpage(Request $request)
    {
        $request->validate([
            'landingname' => 'required',
            'agent' => 'required|exists:users,id'
        ]);
        try {
            $landingagent = LandingAgent::create([
                'landing_name' => $request->landingname,
                'user_id' => $request->agent
            ]);
            if ($landingagent)
                return response()->json(['success' => true, 'message' => 'Assign proccess completed successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error while assigning proccess']);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function deletelanding(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|exists:landing_agents,id'
            ]
        );
        $landingagent = LandingAgent::find($request->id);

        $res = $landingagent->delete();
        if ($res)
            return response()->json(['success' => true, 'message' => 'Landing agent has been deleted successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error hapen while delete landing agent']);
    }

    public function listassignedlandingagent()
    {
        $data = LandingAgent::all();
        $agents = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('agentname', function ($row) use ($agents) {
                $agentname = $agents->where('id', $row->user_id)->first();
                if ($agentname != null)
                    return  $agentname->email;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function updatecustomer(Request $request)
    {
        $request->validate([
            'userid' => 'required|exists:booktables,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
        ]);
        try {
            $customer = booktable::find($request->userid);
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            if ($request->projectname != null)
                $customer->project = $request->projectname;
            if ($request->notes != null)
                $customer->comment = $request->notes;
            $res = $customer->save();

            if ($res)
                return response()->json(['success' => true, 'message' => 'Customer updated successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in updating customer data']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function updateuser(Request $request)
    {
        $request->validate([
            'userid' => 'required|exists:users,id',
            'name' => 'required',
            'phone' => 'required|regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
            'password' => 'required|required_with:password_confirm|same:password_confirm'
        ]);
        try {
            $customer = User::where('id', $request->userid)
                ->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            if ($customer)
                return response()->json(['success' => true, 'message' => 'Agent updated successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in updating agent data']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function deleteuser(Request $request)
    {
        $user = User::destroy($request->id);
        if ($user)
            return response()->json(['success' => true, 'message' => 'User has been deleted successfully']);
        else
            return response()->json(['success' => true, 'message' => 'Error while deleting user']);
    }

    public function deletecustomer(Request $request)
    {
        $customer = booktable::destroy($request->id);
        UserBook::where('book_id', $request->id)->delete();
        if ($customer)
            return response()->json(['success' => true, 'message' => 'Customer has been deleted successfully']);
        else
            return response()->json(['success' => true, 'message' => 'Error while deleting customer']);
    }

    public function deleteproperty(Request $request)
    {
        $property = Property::find($request->id);
        $havepayments = Payment::where('property', $property->name)->where('buyer_id', $property->buyer_id)->exists();
        if ($havepayments)
            return response()->json(['success' => false, 'message' => 'This property has payments you should remove payments first']);

        $res = $property->delete();
        if ($res)
            return response()->json(['success' => true, 'message' => 'Property has been deleted successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error hapen while delete property']);
    }

    public function deletepayment(Request $request)
    {
        $payment = Payment::destroy($request->id);
        if ($payment)
            return response()->json(['success' => true, 'message' => 'Payment has been deleted successfully']);
        else
            return response()->json(['success' => true, 'message' => 'Error while deleting paymnet']);
    }

    public function getcustomerpaymentsinfo(Request $request)
    {
        if (Auth::user()->isadmin()) {
            if ($request->propertyname == null) {
                $userpayments = Payment::where('buyer_id', $request->userid)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', $request->userid)->count();
            } else {
                $userpayments = Payment::where('buyer_id', $request->userid)->where('property', $request->propertyname)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', $request->userid)->where('name', $request->propertyname)->count();
            }
            return response()->json([
                'success' => true,
                'totalpaymentscount' => $totalpaymentscount,
                'totalpaymentsamount' => $totalpaymentsamount,
                'totalpropertiescount' => $totalpropertiescount
            ]);
        } else if (Auth::user()->iscustomer()) {
            if ($request->propertyname == null) {
                $userpayments = Payment::where('buyer_id', Auth::user()->id)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', Auth::user()->id)->count();
            } else {
                $userpayments = Payment::where('buyer_id', Auth::user()->id)->where('property', $request->propertyname)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', Auth::user()->id)->where('name', $request->propertyname)->count();
            }
            return response()->json([
                'success' => true,
                'totalpaymentscount' => $totalpaymentscount,
                'totalpaymentsamount' => $totalpaymentsamount,
                'totalpropertiescount' => $totalpropertiescount
            ]);
        }
    }

    public function getcustomerpropertiesinfo(Request $request)
    {
        $customerproperties = Property::where('buyer_id', $request->userid)->get();
        $totalpropertiescount = $customerproperties->count();
        $totalpropertiesamount = $customerproperties->sum('price');
        return response()->json([
            'success' => true,
            'totalpropertiescount' => $totalpropertiescount,
            'totalpropertiesamount' => $totalpropertiesamount
        ]);
    }

    // assign agent data
    public function assignagentdataindex()
    {
        // jsut for normal agent and aconsultant agent
        $users = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $address = Data::select('ADDRESS')->distinct()->get();
        $emirates = Data::select('EMIRATE')->distinct()->get();
        $residencecountries = Data::select('RESIDENCE_COUNTRY')->distinct()->get();
        $nationalities = Data::select('NATIONALITY')->distinct()->get();
        $areas = Data::select('AREA')->distinct()->get();
        return view('assignagentdata', ['users' => $users, 'address' => $address, 'emirates' => $emirates, 'residencecountries' => $residencecountries, 'nationalities' => $nationalities, 'areas' => $areas]);
    }

    public function showcommenteddata()
    {
        $users = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $comments = UserData::select('comment')->distinct()->get();
        $userstatus = config('app.user_status');
        return view('showusercommenteddata', [
            'users' => $users,
            'comments' => $comments,
            'userstatus' => $userstatus
        ]);
    }

    public function createpropertyindex()
    {
        $users = User::select('id', 'name')->where('role_id', '4')->get();
        return view('createproperty')->with('users', $users);
    }

    public function createpaymentindex()
    {
        $properties = Property::pluck("name");
        $users = User::select("id", "name")->where('role_id', '4')->get();
        return view('createpayment')->with('properties', $properties)->with('users', $users);
    }

    public function createuserindex()
    {
        return view('createuser');
    }

    public function createnewinventory(Request $request)
    {
        //save floor plan/view image
        if ($request->floor_plans_view != null && $request->floor_plans_view != "undefined") {
            $fileName = rand(0, 10000) . time() . '.' . $request->floor_plans_view->extension();
            $request->floor_plans_view->move(public_path('images/'), $fileName);
        }

        $inventory = Inventory::create([
            'source_of_lead' => $request->source_of_lead,
            'remarks' => $request->remarks,
            'unit_for_sales' => $request->unit_for_sales,
            'client_name' => Auth::user()->isagent() ? Auth::user()->name : $request->client_name,
            'building_status' => $request->building_status,
            'category' => $request->category,
            'agent_name' => $request->agent_name,
            'date_listed' => $request->date_listed,
            'serial_num' => $request->serial_num,
            'developer' => $request->developer,
            'community_location' => $request->community_location,
            'building_name' => $request->building_name,
            'property_name' => $request->property_name,
            'unit_number' => $request->unit_number,
            'plot_area' => $request->plot_area,
            'customer_name' => $request->customer_name,
            'email_address' => $request->email_address,
            'mobile' => $request->mobile,
            'comments' => $request->comments,
            'status' => $request->status,
            'nationality' => $request->nationality,
            'property_type' => $request->property_type,
            'furniture' => $request->furniture,
            'floor_plans_View' => $request->floor_plans_view != 'undefined' ? ('/images/' . $fileName) : null,
            'bedrooms' => $request->bedrooms,
            'customer_type' => $request->customer_type,
            'can_add' => $request->can_add,
            'unite_price' => $request->unite_price,
            'roi' => $request->roi,
            'telephone_number' => $request->telephone_number,
            'telephone_residence' => $request->telephone_residence,
            'telephone_office' => $request->telephone_office,
            'general' => $request->general,
            'property_finder_link' => $request->property_finder_link,
            'buyut_link' => $request->buyut_link,
            'dubizzle_link' => $request->dubizzle_link,
            'wow_propties_link' => $request->wow_propties_link,
            'other_links' => $request->other_links,
            'type_of_apt' => $request->type_of_apt,
            'property_size' => $request->property_size,
            'floors' => $request->floors,
            'service_charge' => $request->service_charge,
            'payment_plan' => $request->payment_plan,
            'rent' => $request->rent,
            'ready_off' => $request->ready_off,
            'handover' => $request->handover,
            'price_aed' => $request->price_aed,
            'bathrooms' => $request->bathrooms,
            'completion' => $request->completion
        ]);

        if ($inventory != null)
            return response()->json(['success' => true, 'message' => 'Inventory created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new inventory']);
    }

    public function createcustomerindex()
    {
        return view('createcustomer');
    }

    public function createinventoryindex()
    {
        // developers
        $developers = [
            "EMAAR", "DAMAC", "NAKHEEL", "DUBAI PROPERTIES", "MERAAS", "MEYDAN", "SOBHA", "DEYAAR", "OMNIYAT", "MAG",
            "Select Group", "The First Group", "Wasl Properties", "Dubai Investments Real Estate",
            "Binghatti Developers", "Azizi Developments", "Danube", "Ellington Properties", "Tilal Properties",
            "Al Futtaim Real Estate", "Majid al Futtaim Real Estate", "Diamond Developers", "Nshama",
            "Al Habtoor Group", "Bloom Properties", "Seven Tides International", "Cayan Group", "Al Barari",
            "Time Properties", "G&Co Properties"
        ];
        sort($developers);

        // dubai locations
        $locations = [
            "Abu Hail",
            "Al Awir First",
            "Al Awir Second",
            "Al Bada",
            "Al Baraha",
            "Al Barsha First",
            "Al Barsha Second",
            "Al Barsha South First",
            "Al Barsha South Second",
            "Al Barsha South Third",
            "Al Barsha Third",
            "Al Buteen",
            "Al Dhagaya",
            "Al Garhoud",
            "Al Guoz Fourth",
            "Al Hamriya, Dubai",
            "Al Hamriya Port",
            "Al Hudaiba",
            "Al Jaddaf",
            "Al Jafiliya",
            "Al Karama",
            "Al Khabisi",
            "Al Khwaneej First",
            "Al Khwaneej Second",
            "Al Kifaf",
            "Al Mamzar",
            "Al Manara",
            "Al Mankhool",
            "Al Merkad",
            "Al Mina",
            "Al Mizhar First",
            "Al Mizhar Second",
            "Al Muraqqabat",
            "Al Murar",
            "Al Mushrif",
            "Al Muteena",
            "Al Nahda First",
            "Al Nahda Second",
            "Al Nasr, Dubai",
            "Al Quoz First",
            "Al Quoz Industrial First",
            "Al Quoz Industrial Fourth",
            "Al Quoz Industrial Second",
            "Al Quoz Industrial Third",
            "Al Quoz Second",
            "Al Quoz Third",
            "Al Qusais First",
            "Al Qusais Industrial Fifth",
            "Al Qusais Industrial First",
            "Al Qusais Industrial Fourth",
            "Al Qusais Industrial Second",
            "Al Qusais Industrial Third",
            "Al Qusais Second",
            "Al Qusais Third",
            "Al Raffa",
            "Al Ras",
            "Al Rashidiya",
            "Al Rigga",
            "Al Sabkha",
            "Al Safa First",
            "Al Safa Second",
            "Al Safouh First",
            "Al Safouh Second",
            "Al Satwa",
            "Al Shindagha",
            "Al Souq Al Kabeer",
            "Al Twar First",
            "Al Twar Second",
            "Al Twar Third",
            "Al Warqa'a Fifth",
            "Al Warqa'a First",
            "Al Warqa'a Fourth",
            "Al Warqa'a Second",
            "Al Warqa'a Third",
            "Al Wasl",
            "Al Waheda",
            "Ayal Nasir",
            "Aleyas",
            "Business Bay",
            "Bu Kadra",
            "Dubai Investment park First",
            "Dubai Investment Park Second",
            "Emirates Hill First",
            "Emirates Hill Second",
            "Emirates Hill Third",
            "Hatta",
            "Hor Al Anz",
            "Hor Al Anz East",
            "Jebel Ali 1",
            "Jebel Ali 2",
            "Jebel Ali Industrial",
            "Jebel Ali Palm",
            "Jumeira First",
            "Palm Jumeira",
            "Jumeira Second",
            "Jumeira Third",
            "Marsa Dubai",
            "Mirdif",
            "Muhaisanah Fourth",
            "Muhaisanah Second",
            "Muhaisanah Third",
            "Muhaisnah First",
            "Nad Al Hammar",
            "Nadd Al Shiba Fourth",
            "Nadd Al Shiba Second",
            "Nadd Al Shiba Third",
            "Nad Shamma",
            "Naif",
            "Port Saeed",
            "Arabian Ranches",
            "Oud Al Muteena Third",
            "Ras Al Khor",
            "Ras Al Khor Industrial First",
            "Ras Al Khor Industrial Second",
            "Ras Al Khor Industrial Third",
            "Rigga Al Buteen",
            "Trade Centre 1",
            "Trade Centre 2",
            "Umm Al Sheif",
            "Umm Hurair First",
            "Umm Hurair Second",
            "Umm Ramool",
            "Umm Suqeim First",
            "Umm Suqeim Second",
            "Umm Suqeim Third",
            "Wadi Alamardi",
            "Warsan First",
            "Warsan Second",
            "Za'abeel First",
            "Za'abeel Second"

        ];
        sort($locations);

        $propertytype = ["Apartment", "Townhouse", "Villa Compound", "Residential Plot", "Residential Building", "Villa", "Penthouse", "Hotel Apartment", "Residential Floor"];
        sort($propertytype);

        $status = config('app.user_status');
        return view('inventory.createinventory', ['developers' => $developers, 'locations' => $locations, 'status' => $status, 'propertytype' => $propertytype]);
    }

    public function showbookviewsindex()
    {
        return view('showbookview');
    }

    public function createnewpayment(Request $request)
    {
        $request->validate(
            [
                'buyerid' => 'required|exists:users,id',
                'property' => 'required|exists:properties,name',
                'amount' => 'required|numeric',
                'Paymentdate' => 'required',
            ]
        );
        $property = Property::where('name', $request->property)->first();
        $totalpayments = Payment::where('buyer_id', $request->buyerid)->where('property', $request->property)->sum('payment_amount');
        if ($totalpayments > 0) {
            $remaining = $property->price - $totalpayments;
            if ($request->amount > $remaining)
                return response()->json(['success' => false, 'message' => 'Property remaining amount is ' . $remaining  . ' payment should be less than']);
        } else {
            if ($request->amount > $property->price)
                return response()->json(['success' => false, 'message' => 'Property remaining amount is ' . $property->price  . ' payment should be less than']);
        }
        $payment = Payment::create([
            'buyer_id' => $request->buyerid,
            'property' => $request->property,
            'payment_amount' => $request->amount,
            'date_of_payment' => $request->Paymentdate,
            'payment_status' => array_search('UnPaid', config('payment.payment_status'))
        ]);

        if ($payment != null)
            return response()->json(['success' => true, 'message' => 'Payment created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new payment']);
    }

    public function createnewcustomer(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required_if:,null&email&unique:users,email',
                'phone' => 'required_if:email,null&regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
                // 'password' => 'required|required_with:password_confirm|same:password_confirm'
            ],
            [
                'required'  => 'The :attribute field is required.',
                'unique'    => ':attribute is already used',
                // 'same'    => 'passwrod and confirmed password should be equal',
            ]
        );
        $user = booktable::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'project' => $request->projectname,
            'comment' => $request->notes,
            'is_enquiry_customer' => true,
            'created_by' => Auth::user()->id
        ]);
        if ($user != null)
            return response()->json(['success' => true, 'message' => 'Customer created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new customer']);
    }

    public function createnewproperty(Request $request)
    {
        $request->validate(
            [
                'property' => 'required',
                'area' => 'required',
                'price' => 'required|numeric',
                'status' => 'required',
                'buyerid' => 'required|exists:users,id'
            ],
            [
                'required'  => 'The :attribute field is required.',
            ]
        );
        $isduplicatedpropertyforuser = Property::where('name', $request->property)->where('buyer_id', $request->buyerid)->exists();
        if ($isduplicatedpropertyforuser)
            return response()->json(['success' => false, 'message' => 'This property is already buyed to this customer']);

        $property = Property::create([
            'name' => $request->property,
            'area' => $request->area,
            'price' => $request->price,
            'status' => $request->status,
            'buyer_id' => $request->buyerid,
            'payments' => 0
        ]);
        if ($property != null)
            return response()->json(['success' => true, 'message' => 'Property created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new property']);
    }

    // create new agent
    public function createnewuser(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|regex:/^\+(?:[0-9] ?){8,14}[0-9]$/',
                'password' => 'required|required_with:password_confirm|same:password_confirm',
            ],
            [
                'required'  => 'The :attribute field is required.',
                'unique'    => ':attribute is already used',
                'same'    => 'passwrod and confirmed password should be equal',
            ]
        );
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => '3',
        ]);
        if ($user != null)
            return response()->json(['success' => true, 'message' => 'User created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new user']);
    }

    public function importenquirycustomer(Request $request)
    {
        if ($request->file == 'undefined')
            return response()->json(['success' => false, 'message' => 'You should select file first']);
        $validator = Validator::make(
            [
                'file'      => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv',
            ]
        );

        $validator->validate();
        Excel::import(new EnquriyCustomerImport, $request->file('file'));
        return response()->json(['success' => true, 'message' => 'File imported successfully']);
    }

    public function importinventory(Request $request)
    {
        if ($request->file == 'undefined')
            return response()->json(['success' => false, 'message' => 'You should select file first']);
        $validator = Validator::make(
            [
                'file'      => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv',
            ]
        );

        $validator->validate();
        Excel::import(new InventoryImport, $request->file('file'));
        return response()->json(['success' => true, 'message' => 'File imported successfully']);
    }

    public function showbooks(Request $request)
    {
        $users = User::all();
        $userbook = UserBook::all();
        if ($request->campaignsource == '' && $request->userstatus == '') {
            $data = booktable::orderBy('created_at', 'DESC')->get();
        } else if ($request->campaignsource != '' && $request->userstatus == '') {
            $data = booktable::where('campaign_name', $request->campaignsource)->orderBy('created_at', 'DESC')->get();
        } else if ($request->campaignsource == '' && $request->userstatus != '') {
            $userbk = UserBook::where('userstatus', $request->userstatus)->groupBy('book_id')->pluck('book_id');
            $data = booktable::whereIn('id', $userbk)->orderBy('created_at', 'DESC')->get();
        } else {
            $userbk = UserBook::where('userstatus', $request->userstatus)->groupBy('book_id')->pluck('book_id');
            $data = booktable::whereIn('id', $userbk)->where('campaign_name', $request->campaignsource)->orderBy('created_at', 'DESC')->get();
        }

        $userstates = config('app.user_status');
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
            })
            ->addColumn('comments', function ($row) use ($userbook, $users) {
                $values = $userbook->where('book_id', $row->id);
                $res = "";
                foreach ($values as $key => $value) {
                    $user = $users->where('id', $value->user_id)->first();
                    if ($user != null) {
                        $comment = '<div class="row"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                        // $comment = '<input style="border-width:0px;border:none;" class="form-control" id="comment mr-2' . $row->id . '" name="comment" value= "' . $user->name .', ' .  $value->comment . ', ' . $value->created_at . '" type="text" >';
                        $res .= $comment;
                    }
                }
                return $res;
                // if ($res != null)
                // else
                //     return '<input class="form-control trackInput" id="comment mr-2' . $row->id . '" name="comment" value="" type="text" >';
            })
            ->addColumn('customerstatus', function ($row) use ($userstates) {
                $userbook = UserBook::select(DB::raw("COUNT(*) as count_row"), 'userstatus')->where('book_id', $row->id)->groupBy('userstatus')->orderBy('count_row', 'desc')->pluck('userstatus', 'count_row')->first();
                $options =  '<select name="" class="form-control ml-2" id="">';
                $options .= "<option> </option>";
                foreach ($userstates as $key => $value) {
                    if ($userbook != null) {
                        if ($value == $userbook)
                            $options .= '<option value=' . $value . ' selected>' . $value . '</option>';
                        else
                            $options .= '<option value=' . $value . '>' . $value . '</option>';
                    } else {
                        $options .= '<option class="selected" value=' . $value . '>' . $value . '</option>';
                    }
                }
                $options .= '</select>';
                return  $options;
            })
            ->addColumn('comment', function ($row) {
                return '<input class="form-control trackInput ml-3 mr-3" id="comment' . $row->id . '" name="comment" value="" type="text" >';
            })
            ->addColumn('addcomment', function ($row) {
                return '<input style="background-color:#70cacc" class="btn btn-md btn-success ml-4 addcomment" value="Add" id="addcomment' . $row->id . '" name="addcomment" type="button" >';
            })
            ->rawColumns(['action', 'comments', 'customerstatus', 'comment', 'addcomment'])
            ->make(true);
    }

    public function showbookviews()
    {
        $data = BookView::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function getLavaChart()
    {
        $lava = new Lavacharts;
        $COUNTS = DB::table('data')
            ->select("NATIONALITY as first", DB::raw("COUNT(NATIONALITY) as second"))
            ->groupby('NATIONALITY')
            ->get()->toArray();
        $array = [];
        foreach ($COUNTS as $count) {
            array_push($array, ['0' => $count->first, '1' => $count->second]);
        }


        // foreach ($COUNTS as $COUNT) {
        //     ge::updateOrCreate([
        //         'first' => $COUNT->NATIONALITY,
        //         'second' => $COUNT->second
        //     ],[
        // 'first' =>  $COUNT->NATIONALITY ,
        // 'second' => $COUNT->second ,
        // ]);
        // }
        // $ss = DB::table('data')
        // ->select('NATIONALITY', DB::raw('COUNT(NATIONALITY)'))
        // ->groupby('NATIONALITY')
        // ->get()->toArray();
        // dd($ss);



        $users = $lava->DataTable();
        // $data = ge::select("first as 0","second as 1")->get()->toArray();
        $users->addStringColumn('Country');
        $users->addNumberColumn('Users');
        $users->addRows($array);
        $lava->GeoChart('Users', $users, [
            'colorAxis'                 => ['green'],   //ColorAxis Options
            'enableRegionInteractivity' => true,
            'keepAspectRatio'           => true,
            'minZoom'           => true,
            //SizeAxis Options
        ]);


        return view('lavacharts', compact('lava'));
    }

    public function getProgressB()
    {
        try {
            $totalexcelrows = session('constvar1988', 0) + session('constvar1989', 0);
            $starttime = new DateTime(session('starttime'));
            $elapsedtime = now()->getTimestamp() - $starttime->getTimestamp();
            $minutes = intval($elapsedtime / 60);
            $seconds = $elapsedtime % 60;
            $res = [
                'imported' => session('constvar1988', 0),
                'duplicated' => session('constvar1989', 0),
                'processstatus' => session('processstatus', 0),
                'filename' => session('filename', ''),
                'filesize' =>  session('filesize', 0),
                'totalexcelrows' => $totalexcelrows,
                'elapsedtime' => isset($minutes) ? $minutes . ' m, ' . $seconds . ' s' : ''
            ];
            return $res;
        } catch (Exception $ex) {
            $res = [
                'imported' => 0,
                'duplicated' => 0,
                'processstatus' => 0,
                'filename' => '',
                'filesize' => 0,
                'totalexcelrows' => 0,
                'starttime' => 0
            ];
            return $res;
        }
    }

    public function getImportStatus()
    {
        return session('processstatus', 0);
    }

    public function finishImportStatus()
    {
        session()->put(['processstatus' => 0]);
        session::save();
    }

    public function startImportStatus()
    {
        session()->put(
            [
                'processstatus' => 1,
                'starttime' => now(),
                'imported' => 0,
                'duplicated' => 0
            ]
        );
        session::save();
    }

    public function clearProgressBar()
    {
        session::forget('filename');
        session::forget('filesize');
        session::forget('starttime');
        session::forget('processstatus');
        session::forget('constvar1988');
        session::forget('constvar1989');
        session::forget('imported');
        session::forget('duplicated');
    }

    public function agentdata()
    {
        $areas = Data::select('AREA')->distinct()->where('AREA', '<>', '')->get();
        $emirates = Data::select('EMIRATE')->distinct()->where('EMIRATE', '<>', '')->get();
        $residences = Data::select('RESIDENCE_COUNTRY')->distinct()->where('RESIDENCE_COUNTRY', '<>', '')->get();
        $datasource = Data::select('source')->groupby('source')->get();

        if (Auth::user()->isadmin())
            return view('agentdata')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences)->with('datasource', $datasource);
        else
            return view('userhome')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences);
    }
    public function index()
    {
        $areas = Data::select('AREA')->distinct()->where('AREA', '<>', '')->get();
        $emirates = Data::select('EMIRATE')->distinct()->where('EMIRATE', '<>', '')->get();
        $residences = Data::select('RESIDENCE_COUNTRY')->distinct()->where('RESIDENCE_COUNTRY', '<>', '')->get();
        $userstates = config('app.user_status');
        $datasource = Data::select('source')->groupby('source')->get();

        if (Auth::user()->isadmin())
            return view('home')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences)->with('datasource', $datasource);
        else
            return view('userhome')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences)->with('userstates', $userstates)->with('datasource', $datasource);
    }

    public function index1()
    {
        $areas = Data::select('AREA')->distinct()->where('AREA', '<>', '')->get();
        $emirates = Data::select('EMIRATE')->distinct()->where('EMIRATE', '<>', '')->get();
        $residences = Data::select('RESIDENCE_COUNTRY')->distinct()->where('RESIDENCE_COUNTRY', '<>', '')->get();
        $userstatus = config('app.user_status');
        return view('userhomeshow')->with('areas', $areas)
            ->with('emirates', $emirates)->with('residences', $residences)->with('userstatus', $userstatus);
    }

    public function map()
    {
        $markers = DB::table('data')->select('lng', 'lat')->where(
            [
                ['lng', '<>', null],
                ['lat', '<>', null],
                ['lat', '<>', ''],
                ['lat', '<>', ''],
            ]
        )->distinct()->get();

        $emptyMarker = DB::table('data')->select('lng', 'lat')->where(
            [
                ['lng', '=', null],
                ['lat', '=', null],
            ]
        )->get();

        return view('map', compact('markers', 'emptyMarker'));
    }

    public function uploadedFiles()
    {
        $files = DB::table('uploaded_files')->select('id', 'fileName', 'created_at', 'numberofimportedrows')->distinct()->get();
        $totaRowsCount = 0;
        foreach ($files as $value) {
            $totaRowsCount += intval($value->numberofimportedrows);
        }
        return view('uploadedFiles', compact('files', 'totaRowsCount'));
    }

    public function downloadFile($fileName)
    {
        $file = 'uploadedFiles/' . $fileName;
        $headers = array(
            'Content-Type: application/octet-stream',
        );


        return Response::download($file, $fileName, $headers);
    }

    function getall()
    {
        try {
            // $data = Data::all();
            return (Datatables::of(Data::all())->make(true));
        } catch (Exception $th) {
            dd($th);
        }
    }

    public function filterIng($emirates, $area, $residence)
    {
        if ($emirates == 'Show' && $area == 'Show' && $residence == 'Show') {
            $data = DB::table('data')->limit(100)->get();
            return $data;
        }


        $data = DB::table('data')
            ->where('EMIRATE', $emirates)
            ->orWhere('RESIDENCE_COUNTRY', $residence)
            ->orWhere('AREA', $area)->get();
        return $data;
    }

    public function search(Request $request)
    {
        $emirates = $request->emirates;
        $area = $request->area;
        $residence = $request->residence;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $filtertext = $request->searchday;
        $datasource = $request->datasource;
        $searchdaytext = null;
        $monthfiltertext = null;

        if (!is_null($filtertext)) {
            $filtertext = explode('-', $filtertext);
            $monthfiltertext = $filtertext[1];
            $searchdaytext = $filtertext[0];
            if ($searchdaytext == "" || $searchdaytext == "00")
                $searchdaytext = null;

            if ($monthfiltertext == "" || $monthfiltertext == "00")
                $monthfiltertext = null;
        }

        $filtertype = $request->filtertype;

        $sdate = null;
        $edate = null;
        // search between range
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
        }

        //
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        if (Auth::user()->isadmin()) {
            $data = Data::orderBy('id', 'DESC');
        } else {
            $commenteddata = Auth::user()->userdatacomment()->pluck('data_id');
            $data =  Auth::user()->data()->whereNotIn('data.id', $commenteddata);
        }

        if (!is_null($emirates) && $emirates != "Show")
            $data->where('EMIRATE', 'LIKE', '%' . $emirates . '%');
        if (!is_null($area) && $area != "Show")
            $data->where('AREA', 'LIKE', '%' . $area . '%');
        if (!is_null($residence) && $residence != "Show") {
            $data->where('RESIDENCE_COUNTRY', 'LIKE', '%' . $residence . '%');
        }
        if (!is_null($datasource) && $datasource != "Show")
            $data->where('source', '=', $datasource);

        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2) {
            $data->whereBetween('DOB', [$sdate, $edate]);
        }
        if (!is_null($monthfiltertext))
            $data->whereMonth('DOB', '=', $monthfiltertext);

        if (!is_null($searchdaytext))
            $data->whereDay('DOB', '=', $searchdaytext);

        if (Auth::user()->isadmin()) {
            return DataTables::of($data)
                ->addcolumn('check', function () {
                    return null;
                })
                ->rawColumns(['check'])
                ->make(true);
        } else {
            $comments = UserDataComment::all();
            return DataTables::of($data)
                ->addcolumn('check', function () {
                    return null;
                })
                ->addColumn('dataid', function ($row) {
                    return $row->data_id;
                })
                ->addColumn('hascomment', function ($row) use ($comments) {
                    $hascomm = $comments->where('data_id', $row->id)->count();
                    if ($hascomm > 0)
                        return true;
                    else
                        return false;
                })
                ->rawColumns(['check'])
                ->make(true);
        }
    }

    public function search1(Request $request)
    {
        $emirates = $request->emirates;
        $area = $request->area;
        $residence = $request->residence;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $filtertext = $request->searchday;
        $userstatus = $request->userstatus;
        $searchdaytext = null;
        $monthfiltertext = null;
        $data = [];

        if (!is_null($filtertext)) {
            $filtertext = explode('-', $filtertext);
            $monthfiltertext = $filtertext[1];
            $searchdaytext = $filtertext[0];
            if ($searchdaytext == "" || $searchdaytext == "00")
                $searchdaytext = null;

            if ($monthfiltertext == "" || $monthfiltertext == "00")
                $monthfiltertext = null;
        }

        $filtertype = $request->filtertype;
        $userdatacomments = UserDataComment::all();
        $users = User::all();

        try {
            $sdate = null;
            $edate = null;
            // search between range
            if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
                $sdate = Carbon::parse($startdate);
                $edate = Carbon::parse($enddate);
                if ($sdate->gt($edate))
                    return response()->json(['message' => 'start date must smaller than end date']);
            }

            //
            if (!is_null($startdate) && $filtertype == 1) {
                $sdate = Carbon::parse($startdate);
            }

            if (Auth::user()->isagent() || Auth::user()->isconsultant()) {
                if ($userstatus == null)
                    $temp = UserDataComment::select('data_id')->groupBy('data_id')->get();
                else
                    $temp = UserDataComment::where('userstatus', $userstatus)->select('data_id')->groupBy('data_id')->get();

                $data = Data::whereIn('id', $temp);
            }

            if (!is_null($emirates) && $emirates != "Show")
                $data->where('EMIRATE', 'LIKE', '%' . $emirates . '%');
            if (!is_null($area) && $area != "Show")
                $data->where('AREA', 'LIKE', '%' . $area . '%');
            if (!is_null($residence) && $residence != "Show") {
                $data->where('RESIDENCE_COUNTRY', 'LIKE', '%' . $residence . '%');
            }
            if (!is_null($sdate) && !is_null($edate) && $filtertype == 2) {
                $data->whereBetween('DOB', [$sdate, $edate]);
            }
            if (!is_null($monthfiltertext))
                $data->whereMonth('DOB', '=', $monthfiltertext);

            if (!is_null($searchdaytext))
                $data->whereDay('DOB', '=', $searchdaytext);

            return DataTables::of($data)
                ->addcolumn('check', function () {
                    return null;
                })
                ->rawColumns(['check'])
                ->addcolumn('action', function () {
                    return '<a class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->editColumn('created_by', function ($row) use ($users) {
                    $user = $users->where('id', $row->created_by)->first();
                    if ($user != null)
                        return $user->name;
                    else
                        return null;
                })
                ->addColumn('userstatus', function ($row) {
                    $userdata = UserDataComment::select(DB::raw("COUNT(*) as count_row"), 'userstatus')->where('data_id', $row->id)->groupBy('userstatus')->orderBy('count_row', 'desc')->pluck('userstatus', 'count_row')->first();
                    if (!is_null($userdata))
                        return $userdata;
                })
                ->addColumn('comments', function ($row) use ($userdatacomments, $users, $userstatus) {
                    if ($userstatus == null)
                        $values = $userdatacomments->where('data_id', $row->id);
                    else
                        $values = $userdatacomments->where('data_id', $row->id)->where('userstatus', $userstatus);
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
                ->make(true);
        } catch (Exception $th) {
            // dd($th);
        }
    }

    public function search2(Request $request)
    {
        $emirates = $request->emirates;
        $area = $request->area;
        $residence = $request->residence;
        $datasource = $request->datasource;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $filtertext = $request->searchday;
        $searchdaytext = null;
        $monthfiltertext = null;

        if (!is_null($filtertext)) {
            $filtertext = explode('-', $filtertext);
            $monthfiltertext = $filtertext[1];
            $searchdaytext = $filtertext[0];
            if ($searchdaytext == "" || $searchdaytext == "00")
                $searchdaytext = null;

            if ($monthfiltertext == "" || $monthfiltertext == "00")
                $monthfiltertext = null;
        }

        $filtertype = $request->filtertype;

        try {
            $sdate = null;
            $edate = null;
            // search between range
            if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
                $sdate = Carbon::parse($startdate);
                $edate = Carbon::parse($enddate);
                if ($sdate->gt($edate))
                    return response()->json(['message' => 'start date must smaller than end date']);
            }

            if (!is_null($startdate) && $filtertype == 1) {
                $sdate = Carbon::parse($startdate);
            }

            $data = Data::where('phone', '!=', '')->distinct('phone');

            if (!is_null($emirates) && $emirates != "Show")
                $data->where('EMIRATE', 'LIKE', '%' . $emirates . '%');
            if (!is_null($area) && $area != "Show")
                $data->where('AREA', 'LIKE', '%' . $area . '%');
            if (!is_null($residence) && $residence != "Show") {
                $data->where('RESIDENCE_COUNTRY', 'LIKE', '%' . $residence . '%');
            }
            if (!is_null($datasource) && $datasource != "Show")
                $data->where('source', '=', $datasource);
            if (!is_null($sdate) && !is_null($edate) && $filtertype == 2) {
                $data->whereBetween('DOB', [$sdate, $edate]);
            }
            if (!is_null($monthfiltertext))
                $data->whereMonth('DOB', '=', $monthfiltertext);

            if (!is_null($searchdaytext))
                $data->whereDay('DOB', '=', $searchdaytext);

            return DataTables::of($data)
                ->addcolumn('check', function () {
                    return null;
                })
                ->rawColumns(['check'])
                ->make(true);
        } catch (Exception $th) {
            // dd($th);
        }
    }

    public function getinventoriesindex()
    {
        $customer_type = ['Seller', 'Buyer', 'Rent'];
        $bedrooms = Inventory::select('bedrooms')->groupBy('bedrooms')->pluck('bedrooms');
        $floors = Inventory::select('floors')->groupBy('floors')->pluck('floors');
        $propertiessize = Inventory::select('property_size')->groupBy('property_size')->pluck('property_size');
        return view('inventory.inventories', ['customertype' => $customer_type, 'bedrooms' => $bedrooms, 'propertiessize' => $propertiessize, 'floors' => $floors]);
    }

    public function getinventories(Request $request)
    {

        $data = Inventory::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                // $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
                return $actionBtn;
            })
            ->addColumn('image', function ($row) {
                return '<img src=' . $row->floor_plans_view . ' alt="" style="width: 150px;">';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function deleteinventory(Request $request)
    {
        try {
            $data = Inventory::where('id', $request->id)->first();
            if ($data) {
                try {
                    $data->delete();
                } catch (Exception $ex) {
                    return response()->json(['success' => false, 'message' => "Inventory cannot be deleted"]);
                }
                return response()->json(['success' => true, 'message' => "Inventory has been deleted successfully"]);
            } else
                return response()->json(['success' => false, 'message' => "Inventory not found"]);
        } catch (Exception $ex) {
        }
    }

    public function deletecomment(Request $request)
    {
        try {
            $dataid = $request->id;
            $data = UserData::where('user_id', Auth::user()->id)->where('data_id', $dataid)->first();
            if ($data) {
                try {
                    $data->comment = null;
                    $data->userstatus = null;
                    $data->save();
                } catch (Exception $ex) {
                    return response()->json(['success' => false, 'message' => "Data cannot be deleted"]);
                }
                return response()->json(['success' => true, 'message' => "Data comment has been deleted successfully"]);
            } else
                return response()->json(['success' => false, 'message' => "Data not found"]);
        } catch (Exception $ex) {
        }
    }

    public function addcomment(Request $request)
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
                UserDataComment::create([
                    'data_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus,
                    'appointment_date' => $request->appointment_date
                ]);

                // change data status to won leads
                $data = Data::find($request->checkedrow);
                $data->data_status = 5;
                $data->save();

                // add data to own leads
                WonLeads::create([
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'phone' => $data->PHONE,
                    'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                    'source' => $data->source,
                    'project' => $data->Master_Project,
                    'title' => $data->unique,
                    'data_id' => $data->id,
                    'previous_state' => '0',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);
            } else if ($request->userstatus == "Interested") {
                // add comment
                UserDataComment::create([
                    'user_id' => Auth::user()->id,
                    'data_id' => $request->checkedrow,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);

                // change data status to leads pool
                $data = Data::find($request->checkedrow);
                $data->data_status = 8;
                $data->save();
                // dd($data);

                // add data to leads pool
                booktable::create([
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'phone' => $data->PHONE,
                    'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                    'source' => 'Customer enquiry',
                    'project' => $data->Master_Project,
                    'title' => $data->unique,
                    'data_id' => $data->id,
                    'previous_state' => '0',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);
            } else if ($request->userstatus == "Not interested") {
                // add comment
                UserDataComment::create([
                    'data_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);
                // add data to own leads
                $data = Data::find($request->checkedrow);
                DeadLeads::create([
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'phone' => $data->PHONE,
                    'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                    'source' => $data->source,
                    'project' => $data->Master_Project,
                    'title' => $data->unique,
                    'data_id' => $data->id,
                    'previous_state' => '0',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);

                // change data status to dead leads
                $data->data_status = 6;
                $data->save();
            } else {
                // add comment
                UserDataComment::create([
                    'data_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);

                // change data status to qualified leads
                $data = Data::find($request->checkedrow);
                $data->data_status = 7;
                $data->save();

                // add data to qualified leads
                QualifiedLeads::create([
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'phone' => $data->PHONE,
                    'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                    'source' => $data->source,
                    'project' => $data->Master_Project,
                    'title' => $data->unique,
                    'data_id' => $data->id,
                    'previous_state' => '0',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Comment entered successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error happen call system admin']);
        }
    }

    public function addleadcomment(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:booktables,id',
            'comment' => 'required'
        ]);
        try {
            if (Str::contains($request->comment, '['))
                return response()->json(['success' => false, 'message' => 'You should delete old comment then add new one']);
            $isuserbookfound = UserBook::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->where('comment', $request->comment)->count();
            if ($isuserbookfound  == 0) {
                $userbook = UserBook::Create([
                    'user_id' => Auth::user()->id,
                    'book_id' => $request->book_id,
                    'comment' => $request->comment,
                    'userstatus' => $request->customerstate
                ]);
                if ($userbook != null)
                    return response()->json(['success' => true, 'message' => 'Comment created successfully']);
                else
                    return response()->json(['success' => false, 'message' => 'Error while creating Comment']);
            }
        } catch (Exception $ex) {
        }
    }

    public function serachforagentdata(Request $request)
    {
        $data = [];
        $user = User::find($request->userid);
        if ($user != null) {
            $temp = $user->data()->pluck('data.id');
            $data = Data::where('assigned', '0')->where('phone', '!=', '')->distinct('phone');
            // $data = Data::where('data_status', '0')->whereNotIn('id', $temp)->where('phone', '!=', '')->distinct('phone');
        }
        return DataTables::of($data)
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check'])
            ->make(true);
    }

    public function assignagentdata(Request $request)
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
            // $userfound = UserData::where('user_id', $request->userid)->count();
            // if ($userfound > 0) {
            //     $currentuserdata = UserData::select('data_id')->where('user_id', $request->userid)->get();
            //     $repateddatalist = [];
            //     $notrepateddatalist = [];
            //     foreach ($data as $key => $item) {
            //         if ($currentuserdata->contains('data_id', $item))
            //             $repateddatalist[] = $item;
            //         else
            //             $notrepateddatalist[] = $item;
            //     }

            //     foreach ($notrepateddatalist as $key => $item) {
            //         $userdata[] = new UserData([
            //             'user_id' => $request->userid,
            //             'data_id' => $item
            //         ]);
            //     }
            //     $user = User::find($request->userid);
            //     $user->userdata()->saveMany($userdata);

            //     if (count($repateddatalist) > 0) {
            //         $request->session()->remove('repateddatalist');
            //         $request->session()->push('repateddatalist', $repateddatalist);
            //         return response()->json(['success' => false, 'message' => 'There are some duplicated data']);
            //     } else
            //         return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
            // } else {
            // }
            foreach ($data as $key => $item) {
                $userdata[] = new UserData([
                    'user_id' => $request->userid,
                    'data_id' => $item
                ]);
            }
            $user = User::find($request->userid);
            $user->userdata()->saveMany($userdata);
            // update data status
            $status = Data::whereIn('id', $data)->update(['assigned' => true]);
            return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error while assign data for user']);
        }
    }

    // show assigned data for each egent
    public function getassigneddataindex()
    {
        $users = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        return view('showagentassigneddata', ['users' => $users, 'assigneddatacount' => 0, 'commenteddatacount' => 0]);
    }

    public function getassignedagentdata(Request $request)
    {
        $userdata = UserData::where('user_id', $request->userid)->pluck('data_id');
        $data = Data::whereIn('id', $userdata)->orderBy('created_at', 'DESC');
        return DataTables::of($data)
            ->make(true);
    }

    public function getassigneduserdatainfo(Request $request)
    {
        $assigneddatacount = UserData::where('user_id', $request->userid)->count();
        $commenteddatacount = UserDataComment::where('user_id', $request->userid)->count();
        return response()->json(['succssess' => true, 'assigneddatacount' => $assigneddatacount, 'commenteddatacount' => $commenteddatacount]);
    }

    public function getleaderboard(Request $request)
    {
        $data = [];
        $users = User::all()->except(['role_id' => 1]);
        foreach ($users as $key => $user) {
            $swoflibuwonuinnu = 0;
            $unavnotworkincomp = 0;
            $others = 0;
            $interested = 0;
            $notinterested = 0;
            $notanswer = 0;
            $total = 0;
            if ($user != null) {
                $username = $user->name;
                $swoflibuwonuinnu = $user->userdatacomment()->wherePivot('userstatus', 'Switch off/Line busy/Wrong number/Invalid number')->count();
                $unavnotworkincomp = $user->userdatacomment()->wherePivot('userstatus', 'Number unavailable/Not working for call/Incomplete no')->count();
                $others = $user->userdatacomment()->wherePivot('userstatus', 'Others')->count();
                $interested = $user->userdatacomment()->wherePivot('userstatus', 'Interested')->count();
                $notinterested = $user->userdatacomment()->wherePivot('userstatus', 'Not interested')->count();
                $notanswer = $user->userdatacomment()->wherePivot('userstatus', 'Not answer')->count();
                $notanswer = $user->userdatacomment()->wherePivot('userstatus', 'Not answer')->count();
                $setappointment = $user->userdatacomment()->wherePivot('userstatus', 'Set appointment')->count();
                $total = $swoflibuwonuinnu + $unavnotworkincomp + $others + $interested +  $notinterested + $notanswer + $setappointment;
                $data[] = ['username' => $username, 'swoflibuwonuinnu' => $swoflibuwonuinnu, 'unavnotworkincomp' => $unavnotworkincomp, 'others' => $others, 'interested' => $interested, 'notinterested' => $notinterested, 'notanswer' => $notanswer, 'setappointment' => $setappointment, 'total' => $total];
            }
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('username', function ($row) {
                return ucfirst($row['username']);
            })
            ->make(true);
    }

    public function getusercommentedinfo(Request $request)
    {
        $user = User::find($request->userid);
        $userstatus = $request->userstatus;
        $swoflibuwonuinnu = 0;
        $unavnotworkincomp = 0;
        $others = 0;
        $interested = 0;
        $notinterested = 0;
        $notanswer = 0;
        $setappointment = 0;
        $total = 0;

        if (($user == null && $userstatus != null) || ($user == null && $userstatus == null)) {
            $emirates = $request->emirates;
            $area = $request->area;
            $residence = $request->residence;
            $startdate = $request->startdate;
            $enddate = $request->enddate;
            $monthfiltertext = $request->monthfiltertext;
            $searchdaytext = $request->searchdaytext;
            $filtertype = $request->filtertype;
            $sdate = null;
            $edate = null;
            // search between range
            if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
                $sdate = Carbon::parse($startdate);
                $edate = Carbon::parse($enddate);
            }

            //
            if (!is_null($startdate) && $filtertype == 1) {
                $sdate = Carbon::parse($startdate);
            }

            $commenteddata = UserDataComment::pluck('data_id');
            $data = Data::whereIn('id', $commenteddata)->select('id', 'EMIRATE', 'AREA', 'RESIDENCE_COUNTRY');

            if (!is_null($emirates) && $emirates != "Show") {
                $data->where('EMIRATE', 'LIKE', '%' . $emirates . '%');
            }
            if (!is_null($area) && $area != "Show")
                $data->where('AREA', 'LIKE', '%' . $area . '%');
            if (!is_null($residence) && $residence != "Show") {
                $data->where('RESIDENCE_COUNTRY', 'LIKE', '%' . $residence . '%');
            }
            if (!is_null($sdate) && !is_null($edate) && $filtertype == 2) {
                $data->whereBetween('DOB', [$sdate, $edate]);
            }
            if (!is_null($monthfiltertext))
                $data->whereMonth('DOB', '=', $monthfiltertext);

            if (!is_null($searchdaytext))
                $data->whereDay('DOB', '=', $searchdaytext);

            $data = $data->pluck('id');
        }


        if ($user != null && $userstatus == null) {
            $swoflibuwonuinnu = $user->userdatacomment()->wherePivot('userstatus', 'Switch off/Line busy/Wrong number/Invalid number')->count();
            $unavnotworkincomp = $user->userdatacomment()->wherePivot('userstatus', 'Number unavailable/Not working for call/Incomplete no')->count();
            $others = $user->userdatacomment()->wherePivot('userstatus', 'Others')->count();
            $interested = $user->userdatacomment()->wherePivot('userstatus', 'Interested')->count();
            $notinterested = $user->userdatacomment()->wherePivot('userstatus', 'Not interested')->count();
            $notanswer = $user->userdatacomment()->wherePivot('userstatus', 'Not answer')->count();
            $setappointment = $user->userdatacomment()->wherePivot('userstatus', 'Set appointment')->count();
        } else if ($user == null && $userstatus != null) {
            $comments = UserDataComment::all();
            $swoflibuwonuinnu = $comments->whereIn('data_id', $data)->where('userstatus', $userstatus)->where('userstatus', 'Switch off/Line busy/Wrong number/Invalid number')->count();
            $unavnotworkincomp = $comments->whereIn('data_id', $data)->where('userstatus', $userstatus)->where('userstatus', 'Number unavailable/Not working for call/Incomplete no')->count();
            $others = $comments->whereIn('data_id', $data)->where('userstatus', $userstatus)->where('userstatus', 'Others')->count();
            $interested = $comments->whereIn('data_id', $data)->where('userstatus', $userstatus)->where('userstatus', 'Interested')->count();
            $notinterested = $comments->whereIn('data_id', $data)->where('userstatus', $userstatus)->where('userstatus', 'Not interested')->count();
            $notanswer = $comments->whereIn('data_id', $data)->where('userstatus', $userstatus)->where('userstatus', 'Not answer')->count();
            $setappointment = $comments->whereIn('data_id', $data)->where('userstatus', $userstatus)->where('userstatus', 'Set appointment')->count();
        } else if ($user == null && $userstatus == null) {
            $comments = UserDataComment::all();
            $swoflibuwonuinnu = $comments->whereIn('data_id', $data)->where('userstatus', 'Switch off/Line busy/Wrong number/Invalid number')->count();
            $unavnotworkincomp = $comments->whereIn('data_id', $data)->where('userstatus', 'Number unavailable/Not working for call/Incomplete no')->count();
            $others = $comments->whereIn('data_id', $data)->where('userstatus', 'Others')->count();
            $interested = $comments->whereIn('data_id', $data)->where('userstatus', 'Interested')->count();
            $notinterested = $comments->whereIn('data_id', $data)->where('userstatus', 'Not interested')->count();
            $notanswer = $comments->whereIn('data_id', $data)->where('userstatus', 'Not answer')->count();
            $setappointment = $comments->whereIn('data_id', $data)->where('userstatus', 'Set appointment')->count();
        } else {
            $swoflibuwonuinnu = $user->userdatacomment()->wherePivot('userstatus', 'Switch off/Line busy/Wrong number/Invalid number')->where('userstatus', $userstatus)->count();
            $unavnotworkincomp = $user->userdatacomment()->wherePivot('userstatus', 'Number unavailable/Not working for call/Incomplete no')->where('userstatus', $userstatus)->count();
            $others = $user->userdatacomment()->wherePivot('userstatus', 'Others')->where('userstatus', $userstatus)->count();
            $interested = $user->userdatacomment()->wherePivot('userstatus', 'Interested')->where('userstatus', $userstatus)->count();
            $notinterested = $user->userdatacomment()->wherePivot('userstatus', 'Not interested')->where('userstatus', $userstatus)->count();
            $notanswer = $user->userdatacomment()->wherePivot('userstatus', 'Not answer')->where('userstatus', $userstatus)->count();
            $setappointment = $user->userdatacomment()->wherePivot('userstatus', 'Set appointment')->where('userstatus', $userstatus)->count();
        }
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

    public function getcommenteduserdata(Request $request)
    {
        $userid = $request->userid;
        $userstatus = $request->userstatus;
        $userdatacomments = UserDataComment::all();
        $users = User::all();
        $user = $users->where('id', $userid)->first();
        $data = [];

        if ($user == null && $userstatus == null) {
            $temp = UserDataComment::select('data_id')->groupBy('data_id')->get();
            $data = Data::whereIn('id', $temp)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('userstatus', function ($row) {
                    $userdata = UserDataComment::select(DB::raw("COUNT(*) as count_row"), 'userstatus')->where('data_id', $row->id)->groupBy('userstatus')->orderBy('count_row', 'desc')->pluck('userstatus', 'count_row')->first();
                    if (!is_null($userdata))
                        return $userdata;
                })
                ->addColumn('comments', function ($row) use ($userdatacomments, $users) {
                    $values = $userdatacomments->where('data_id', $row->id);
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
                ->make(true);
        }

        if ($user != null) {
            $data = $user->userdatacomment();
        }

        if ($userstatus != null) {
            if ($user != null)
                $data = $user->userdatacomment()->wherePivot('userstatus', $userstatus);
            else {
                $temp1 = UserDataComment::where('userstatus', $userstatus)->pluck('data_id');
                $data = Data::whereIn('id', $temp1);
            }
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('userstatus', function ($row) use ($userdatacomments) {
                $userdata = $userdatacomments->where('data_id', $row->data_id)->where('user_id', $row->user_id)->first();
                if (!is_null($userdata))
                    return $userdata->userstatus;
            })
            ->addColumn('comments', function ($row) use ($userdatacomments, $users, $userid, $userstatus) {
                if ($userid != null && $userstatus == null)
                    $values = $userdatacomments->where('data_id', $row->data_id)->where('user_id', $userid);
                else if ($userid != null && $userstatus != null)
                    $values = $userdatacomments->where('data_id', $row->data_id)->where('userstatus', $userstatus)->where('user_id', $userid);
                else if ($userid == null && $userstatus != null)
                    $values = $userdatacomments->where('data_id', $row->id)->where('userstatus', $userstatus);
                else {
                    $values = $userdatacomments->where('data_id', $row->id);
                }
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
            ->make(true);
    }

    public function wonleadsindex()
    {
        $datasource = WonLeads::select('source')->groupBy('source')->pluck('source');
        $projects = WonLeads::where('project', '!=', '')->select('project')->groupBy('project')->pluck('project');
        return view('wonleads', ['datasource' => $datasource, 'projects' => $projects]);
    }

    public function wonleadsdata(Request $request)
    {
        $projects = $request->projects;
        $datasource = $request->datasource;

        if ($projects == null && $datasource == null) {
            $data = WonLeads::all();
        } else if ($projects != null && $datasource == null) {
            $data = WonLeads::where('project', $projects)->get();
        } else if ($projects == null && $datasource != null) {
            $data = WonLeads::where('source', $datasource)->get();
        } else {
            $data = WonLeads::where('project', $projects)->where('source', $datasource)->get();
        }

        $users = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($user) {
                return  date('d-m-Y h-m-s', strtotime($user->created_at));
            })
            // ->addColumn('action', function ($row) {
            //     if ($row->is_enquiry_customer) {
            //         $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
            //         $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
            //         return $actionBtn;
            //     }
            // })
            ->editColumn('created_by', function ($row) use ($users) {
                $user = $users->where('id', $row->created_by)->first();
                if ($user != null)
                    return $user->name;
                else
                    return null;
            })
            ->make(true);
    }

    public function deadleadsindex()
    {
        $datasource = DeadLeads::select('source')->groupBy('source')->pluck('source');
        $projects = DeadLeads::where('project', '!=', '')->select('project')->groupBy('project')->pluck('project');
        return view('deadleads', ['datasource' => $datasource, 'projects' => $projects]);
    }

    public function deadleadsdata(Request $request)
    {
        $projects = $request->projects;
        $datasource = $request->datasource;

        if ($projects == null && $datasource == null) {
            $data = DeadLeads::all();
        } else if ($projects != null && $datasource == null) {
            $data = DeadLeads::where('project', $projects)->get();
        } else if ($projects == null && $datasource != null) {
            $data = DeadLeads::where('source', $datasource)->get();
        } else {
            $data = DeadLeads::where('project', $projects)->where('source', $datasource)->get();
        }

        $users = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($user) {
                return  date('d-m-Y h-m-s', strtotime($user->created_at));
            })
            // ->addColumn('action', function ($row) {
            //     if ($row->is_enquiry_customer) {
            //         $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
            //         $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
            //         return $actionBtn;
            //     }
            // })
            ->editColumn('created_by', function ($row) use ($users) {
                $user = $users->where('id', $row->created_by)->first();
                if ($user != null)
                    return $user->name;
                else
                    return null;
            })
            ->make(true);
    }

    // public function sample()
    // {

    //     $chart = (new LarapexChart)->pieChart()
    //     ->setTitle('Pie')
    //     ->addData([
    //         \App\Models\Data::where('EMIRATE', '=', 'Dubai')->count(),
    //         \App\Models\Data::where('EMIRATE', '=', 'Sharjah')->count(),
    //         \App\Models\Data::where('EMIRATE', '=', 'Abu Dhabi')->count(),
    //     ])
    //     ->setColors(['#a5378f', '#ffc70b','#cc2411'])
    //     ->setLabels(['Dubai', 'Sharjah','Abu Dhabi']);

    //     $chart1 = (new LarapexChart)->barChart()
    //     ->setTitle('Histogram')
    //     ->addBar('Dubai', [\App\Models\Data::where('EMIRATE', '=', 'Dubai')->count()])
    //     ->addBar('Sharjah', [\App\Models\Data::where('EMIRATE', '=', 'Sharjah')->count()])
    //     ->addBar('Abu Dhabi', [\App\Models\Data::where('EMIRATE', '=', 'Abu Dhabi')->count()])
    //     ->setColors(['blue'])
    //     ->setLabels([' ']);
    //     return view('sample')->with('chart',$chart)->with('chart1',$chart1);
    // }

    // public function nationality()
    // {
    //     $chart2 = (new LarapexChart)->barChart()
    //     ->setTitle('Histogram')
    //     ->addBar('Russia', [\App\Models\Data::where('NATIONALITY', '=', 'Russia')->count()])
    //     ->addBar('Kyrgistan',[\App\Models\Data::where('NATIONALITY', '=', 'Kyrgistan')->count()])
    //     ->addBar('India', [\App\Models\Data::where('NATIONALITY', '=', 'India')->count()])
    //     ->addBar('Italy', [\App\Models\Data::where('NATIONALITY', '=', 'Italy')->count()])
    //     ->addBar('South Africa', [\App\Models\Data::where('NATIONALITY', '=', 'South Africa')->count()])
    //     ->addBar('United Kingdom', [\App\Models\Data::where('NATIONALITY', '=', 'United Kingdom')->count()])
    //     ->addBar('United States of America', [\App\Models\Data::where('NATIONALITY', '=', 'United States of America')->count()])
    //     ->addBar('Pakistan', [\App\Models\Data::where('NATIONALITY', '=', 'Pakistan')->count()])
    //     ->addBar('China', [\App\Models\Data::where('NATIONALITY', '=', 'China')->count()])
    //     ->addBar('Afghanistan', [\App\Models\Data::where('NATIONALITY', '=', 'Afghanistan')->count()])
    //     ->addBar('Kuwait', [\App\Models\Data::where('NATIONALITY', '=', 'Kuwait')->count()])
    //     ->addBar('Iran', [\App\Models\Data::where('NATIONALITY', '=', 'Iran')->count()])
    //     ->addBar('France', [\App\Models\Data::where('NATIONALITY', '=', 'France')->count()])
    //     ->addBar('Canada', [\App\Models\Data::where('NATIONALITY', '=', 'Canada')->count()])
    //     ->addBar('Jordan', [\App\Models\Data::where('NATIONALITY', '=', 'Jordan')->count()])
    //     ->addBar('Kazakhstan', [\App\Models\Data::where('NATIONALITY', '=', 'Kazakhstan')->count()])
    //     ->addBar('Brunei', [\App\Models\Data::where('NATIONALITY', '=', 'Brunei')->count()])
    //     ->addBar('Palestine', [\App\Models\Data::where('NATIONALITY', '=', 'Palestine')->count()])
    //     ->addBar('Greece', [\App\Models\Data::where('NATIONALITY', '=', 'Greece')->count()])
    //     ->addBar('Lebanon', [\App\Models\Data::where('NATIONALITY', '=', 'Lebanon')->count()])
    //     ->addBar('South Korea', [\App\Models\Data::where('NATIONALITY', '=', 'South Korea')->count()])
    //     ->addBar('Bangladesh', [\App\Models\Data::where('NATIONALITY', '=', 'Bangladesh')->count()])
    //     ->addBar('United Arab Emirates', [\App\Models\Data::where('NATIONALITY', '=', 'United Arab Emirates')->count()])
    //     ->addBar('Syria', [\App\Models\Data::where('NATIONALITY', '=', 'Syria')->count()])
    //     ->addBar('Northern Ireland', [\App\Models\Data::where('NATIONALITY', '=', 'Northern Ireland')->count()])
    //     ->addBar('Morocco', [\App\Models\Data::where('NATIONALITY', '=', 'Morocco')->count()])
    //     ->setColors(['blue'])
    //     ->setLabels([' ']);

    //     $chart3 = (new LarapexChart)->pieChart()
    //     ->setTitle('Pie')
    //     ->addData([
    //         \App\Models\Data::where('NATIONALITY', '=', 'Russia')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Kyrgistan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'India')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Italy')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'South Africa')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'United Kingdom')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'United States of America')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Pakistan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'China')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Afghanistan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Kuwait')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Iran')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'France')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Canada')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Jordan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Kazakhstan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Brunei')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Palestine')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Greece')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Lebanon')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'South Korea')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Bangladesh')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'United Arab Emirates')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Syria')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Northern Ireland')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Morocco')->count(),
    //     ])
    //     ->setColors(['#a5378f', '#ffc70b','#cc2411','#f00','#80a2c7','#985dde','#7b1dea',
    //     '#1dea3c','#157123','#437115','#b1bf18','#bf6218','#254869','#2fe8a0','#de4f4f'])
    //     ->setLabels(['Russia', 'Kyrgistan','India','Italy','South Africa','United Kingdom',
    //     'United States of America','Pakistan','China','Afghanistan','Kuwait','Iran','France'
    //     ,'Canada','Jordan','Kazakhstan','Brunei','Palestine','Greece','Lebanon','South Korea'
    //     ,'Bangladesh','United Arab Emirates','Syria','Northern Ireland','Morocco']);

    //     return view('nationality')->with('chart',$chart)->with('chart1',$chart1);
    // }

    // public function usage(){
    //     $chart4 = (new LarapexChart)->barChart()
    //     ->setTitle('Histogram')
    //     ->addBar('Residential', [\App\Models\Data::where('USAGE', '=', 'Residential')->count()])
    //     ->addBar('Building',[\App\Models\Data::where('USAGE', '=', 'Building')->count()])
    //     ->addBar('Flat', [\App\Models\Data::where('USAGE', '=', 'Flat')->count()])
    //     ->setColors(['blue'])
    //     ->setLabels([' ']);

    //     $chart5 = (new LarapexChart)->pieChart()
    //     ->setTitle('Pie')
    //     ->addData([
    //         \App\Models\Data::where('USAGE', '=', 'Residential')->count(),
    //         \App\Models\Data::where('USAGE', '=', 'Building')->count(),
    //         \App\Models\Data::where('USAGE', '=', 'Flat')->count(),
    //     ])
    //     ->setColors(['#ffc70b', '#cc2411','#a5378f'])
    //     ->setLabels(['Residential', 'Building','Flat']);

    //     return view('usage')->with('chart',$chart)->with('chart1',$chart1);
    // }
}
