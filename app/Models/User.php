<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Str;
use Symfony\Component\VarDumper\Cloner\Data;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'project_name',
        'notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getcurrentproccessstatus()
    {
        $report = Report::where('currentuser', $this->id)->where('state', config('importstatus.import_status.in_progress'))->first();
        if ($report != null)
            return $report->state;
        else
            return 2;
    }

    public function getfilename()
    {
        $report = Report::where('currentuser', $this->id)->orderBy('created_at', 'desc')->first();
        if ($report != null)
            return $report->description;
        else
            return null;
    }

    public function getuserimportingdata()
    {
        $report = Report::where('state', config('importstatus.import_status.in_progress'))->orderBy('created_at', 'desc')->first();
        if ($report != null)
            return $report->currentuser;
        else
            return 0;
    }

    public function data()
    {
        return $this->belongsToMany('App\Models\Data', 'user_data');
    }

    public function qualifieddata()
    {
        return $this->belongsToMany('App\Models\QualifiedLeads', 'user_qualified_leads');
    }

    public function leadspooldata()
    {
        return $this->belongsToMany('App\Models\booktable', 'user_leads_pools', 'user_id', 'leads_pool_id');
    }

    public function followupdata()
    {
        return $this->belongsToMany('App\Models\FollowUpLeads', 'user_follow_up_leads', 'user_id', 'follow_up_id');
    }

    public function userdata()
    {
        return $this->hasMany(UserData::class, 'user_id', 'id');
    }

    public function userleadspooldata()
    {
        return $this->hasMany(UserLeadsPool::class, 'user_id', 'id');
    }

    public function userfollowupdata()
    {
        return $this->hasMany(UserFollowUpLeads::class, 'user_id', 'id');
    }

    public function userqualifieddata()
    {
        return $this->hasMany(UserQualifiedLeads::class, 'user_id', 'id');
    }
    
    public function userqualifieddatacomment()
    {
        return $this->belongsToMany('App\Models\QualifiedLeads', 'user_qualified_leads_comments')->withPivot('user_id','qualified_leads_id','userstatus');
    }

    public function userleadsbooldata()
    {
        return $this->hasMany(UserLeadsPool::class, 'user_id', 'id');
    }

    public function userleadspooldatacomment()
    {
        return $this->belongsToMany('App\Models\booktable', 'user_leads_pool_comments', 'user_id', 'leads_pool_id')->withPivot('user_id','leads_pool_id','userstatus');
    }

    public function userfollowupdatacomment()
    {
        return $this->belongsToMany('App\Models\FollowUpLeads', 'user_follow_up_leads_comments', 'user_id', 'follow_up_id')->withPivot('user_id','leads_pool_id','userstatus');
    }

    public function userdatacomment()
    {
        return $this->belongsToMany('App\Models\Data', 'user_data_comment')->withPivot('user_id','data_id','userstatus');
    }

    public function isadmin()
    {
        if (Str::contains(Auth::user()->role_id, '1'))
            return true;
        else
            return false;
    }

    public function isconsultant()
    {
        if (Str::contains(Auth::user()->role_id, '2'))
            return true;
        else
            return false;
    }

    public function isagent()
    {
        if (Str::contains(Auth::user()->role_id, '3'))
            return true;
        else
            return false;
    }

    public function isconsultantagent()
    {
        if (Str::contains(Auth::user()->role_id, '2,3'))
            return true;
        else
            return false;
    }

    public function iscustomer()
    {
        if (Str::contains(Auth::user()->role_id, '4'))
            return true;
        else
            return false;
    }
}
