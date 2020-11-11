<?php


namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Lead;
use App\Priority;
use App\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{

    public function getAllLeads(){
        $user = User::find(Auth::id());

        $page_user = $user->page()->first();
        $leadsFromUserPage = Lead::where('page_id', $page_user->id )->get();
        $status = Status::all('id as code', 'status as name');
        $priorities = Priority::all('id as code', 'priority as name');

        foreach($leadsFromUserPage as $lead){
            $lead->summary = $page_user->epic.' - '.$lead->name.' - '.$lead->id;
            $lead->priority->code = $lead->priority->id;
            $lead->priority->name = $lead->priority->priority;
            $lead->priority_icon = $lead->priority->icon_url;
            $lead->status->code = $lead->status->id;
            $lead->status->name = $lead->status->status;
            $lead->user;
//            $lead->user->code = $lead->user->id;
            $lead->avatar_url = $lead->user->avatar_url;
            $lead->created = $lead->created_at->format('d M');
        }
        return response()->json([
            'leads' => $leadsFromUserPage,
            'status' => $status,
            'priorities' => $priorities
        ]);
    }

    public function getLeadById($leadId){
        $user = User::find(Auth::id());

        $page_user = $user->page()->first();
        $leadById = Lead::where('page_id', $page_user->id )
                    ->where('id', $leadId)
                    ->get()
                    ->first();
        $anotherLeads = Lead::select('id','name', 'priority_id', 'status_id', 'user_id', 'created_at', 'updated_at')
                    ->where('page_id', $page_user->id )
                    ->where('email', $leadById->email)
                    ->where('id', '<>', $leadId)
                    ->get();

        foreach ($anotherLeads as $other) {
            $other->summary = $page_user->epic.' - '.$other->name.' - '.$other->id;
            $other->created = $other->created_at->format('d M Y');
            $other->priority->code = $other->priority->id;
            $other->priority->name = $other->priority->priority;
            $other->priority_icon = $other->priority->icon_url;
            $other->status->code = $other->status->id;
            $other->status->name = $other->status->status;
            $other->user;
            $other->user->avatar = $other->user->avatar_url;
        }

        $status = Status::all('id as code', 'status as name');
        $priorities = Priority::all('id as code', 'priority as name', 'icon_url');

        $leadById->summary = $page_user->epic.' - '.$leadById->name.' - '.$leadById->id;
        $leadById->priority->code = $leadById->priority->id;
        $leadById->priority->name = $leadById->priority->priority;
        $leadById->priority_icon = $leadById->priority->icon_url;
        $leadById->status->code = $leadById->status->id;
        $leadById->status->name = $leadById->status->status;
        $leadById->user;
        $leadById->avatar_url = $leadById->user->avatar_url;
        $leadById->created = $leadById->created_at->format('d M');
        $leadById->comments;
        foreach ($leadById->comments as $history){
            $history->user = User::find($history->user_id);
            $history->created = $history->created_at->format('d M Y');
            $history->avatar_url = $history->user->avatar_url;
        }

        return response()->json([
            'lead' => $leadById,
            'status' => $status,
            'priorities' => $priorities,
            'another_leads' => $anotherLeads,
        ]);
    }

    public function submitCommentLead(Request $request){
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        try{
            $history = new Comment;
            $history->user_id = $request->input('user_id');
            $history->comment = $request->input('comment');
            $history->save();
            $history->lead()->attach([$request->input('lead_id')]);
            $history->user = User::find(Auth::id());
            $history->created = $history->created_at->format('d M Y');
            $history->avatar_url = $history->user->avatar_url;

            return response()->json($history, 201);
        } catch (\Exception $e) {
            return response()->json( [
                'errors' => [
                    'message' => 'Erro ao salvar comentário.'
                ],
            ], 409);
        }
    }


    /**
     * Update Status do lead.
     * todo: necessario criar validacao se o lead pertence a pagina do usuario.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required|numeric',
            'status_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        try{
            $lead = Lead::find($request->input('lead_id'));
            $lead->status_id = $request->input('status_id');
            $lead->save();
            $lead->status->code = $lead->status->id;
            $lead->status->name = $lead->status->status;

            return response()->json($lead);
        } catch (\Exception $e) {
            return response()->json( [
                'errors' => [
                    'message' => 'Erro ao atualizar lead.'
                ],
            ], 409);
        }
    }

    /**
     * Update Prioridade do lead.
     * todo: necessario criar validacao se o lead pertence a pagina do usuario.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePriority(Request $request){
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required|numeric',
            'priority_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        try{
            $lead = Lead::find($request->input('lead_id'));
            $lead->priority_id = $request->input('priority_id');
            $lead->save();
            $lead->priority->code = $lead->priority->id;
            $lead->priority->name = $lead->priority->priority;
            $lead->priority_icon = $lead->priority->icon_url;


            return response()->json($lead);
        } catch (\Exception $e) {
            return response()->json( [
                'errors' => [
                    'message' => 'Erro ao atualizar lead.'
                ],
            ], 409);
        }
    }

    /**
     * Update Usuario do lead.
     * todo: necessario criar validacao se o lead pertence a pagina do usuario.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request){
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        try{
            $lead = Lead::find($request->input('lead_id'));
            $lead->user_id = $request->input('user_id');
            $lead->save();
            $lead->user;
            $lead->avatar_url = $lead->user->avatar_url;


            return response()->json($lead);
        } catch (\Exception $e) {
            return response()->json( [
                'errors' => [
                    'message' => 'Erro ao atualizar lead.'
                ],
            ], 409);
        }
    }

    public function report(){
        $oneWeekAgo = \Carbon\Carbon::today()->subWeek();
        $user = User::find(Auth::id());

        $page_user = $user->page()->first();

        $allLeads = Lead::where('page_id', $page_user->id)->count();
        $last7days = Lead::where('page_id', $page_user->id)->whereDate('created_at','>=',$oneWeekAgo)->count();
        $newLeads = Lead::where('page_id', $page_user->id)->where('status_id', 1)->count();
        $closedLeads = Lead::where('page_id', $page_user->id)->where('status_id', 4)->count();

        $activity = Lead::where('page_id', $page_user->id)->where('user_id', Auth::id())->select('id', 'name', 'priority_id')->get();
        foreach($activity as $ac) {
            $ac->summary = $page_user->epic . ' - ' . $ac->name . ' - ' . $ac->id;
            $ac->priority;
            $ac->priority->code = $ac->priority->id;
            $ac->priority->name = $ac->priority->priority;
            $ac->priority_icon = $ac->priority->icon_url;
        }


        return response()->json([
            'report' => [
                'last7days' => $last7days,
                'allLeads' => $allLeads,
                'newLeads' => $newLeads,
                'closedLeads' => $closedLeads,
            ],
            'activity' => $activity
        ]);
    }
}
