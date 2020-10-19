<?php


namespace App\Http\Controllers;

use App\User;
use App\Lead;
use App\Priority;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Carbon;

class LeadController extends Controller
{

    public function getAllLeads(){
        $user = User::find(Auth::id());

        $page_user = $user->page()->first();
        $leadsFromUserPage = Lead::where('page_id', $page_user->id )->get();
        foreach($leadsFromUserPage as $lead){
            $lead->summary = $page_user->epic.' - '.$lead->name.' - '.$lead->id;
            $lead->priority;
            $lead->status;
            $lead->user->name;
            $lead->created = $lead->created_at->format('d M');
        }
        return response()->json([
            'leads' => $leadsFromUserPage
        ]);
    }
}
