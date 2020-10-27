<?php


namespace App\Http\Controllers;

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
            $lead->priority_icon = $lead->priority->icon;
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
        $status = Status::all('id as code', 'status as name');
        $priorities = Priority::all('id as code', 'priority as name', 'icon');

        $leadById->summary = $page_user->epic.' - '.$leadById->name.' - '.$leadById->id;
        $leadById->priority->code = $leadById->priority->id;
        $leadById->priority->name = $leadById->priority->priority;
        $leadById->priority_icon = $leadById->priority->icon;
        $leadById->status->code = $leadById->status->id;
        $leadById->status->name = $leadById->status->status;
        $leadById->user;
        $leadById->avatar_url = $leadById->user->avatar_url;
        $leadById->created = $leadById->created_at->format('d M');

        return response()->json([
            'lead' => $leadById,
            'status' => $status,
            'priorities' => $priorities
        ]);
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
            $lead->priority_icon = $lead->priority->icon;


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
}
