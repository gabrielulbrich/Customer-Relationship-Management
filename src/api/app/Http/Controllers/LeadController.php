<?php


namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Lead;
use App\Priority;
use App\Status;
use App\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    //todo: verificar o perfil do usuário
    public function getAllLeads(){
        $user = User::find(Auth::id());

        $page_user = $user->page()->first();
        $leadsFromUserPage = Lead::where('page_id', $page_user->id )->get();
        $status = Status::all('id as code', 'status as name');
        $priorities = Priority::all('id as code', 'priority as name');

        foreach($leadsFromUserPage as $lead){
            $lead->summary = $page_user->epic.'/'.$lead->api->api;
            $lead->priority->code = $lead->priority->id;
            $lead->priority->name = $lead->priority->priority;
            $lead->priority_icon = $lead->priority->icon_url;
            $lead->status->code = $lead->status->id;
            $lead->status->name = $lead->status->status;
            $lead->user;
            $lead->avatar_url = $lead->user->avatar_url;
            $lead->created = $lead->created_at->format('d M');
        }
        return response()->json([
            'leads' => $leadsFromUserPage,
            'status' => $status,
            'priorities' => $priorities
        ]);
    }

    //todo: verificar o perfil do usuário
    public function getLeadById($leadId){
        $user = User::find(Auth::id());

        $page_user = $user->page()->first();
        $leadById = Lead::where('page_id', $page_user->id )
                    ->where('id', $leadId)
                    ->get()
                    ->first();
                
        $anotherLeads = Lead::select('id', 'priority_id', 'status_id', 'user_id','api_id', 'created_at', 'updated_at')
                    ->where('page_id', $page_user->id )
                    ->where('id', '<>', $leadId)
                    ->get();

        $fields = Api::find($leadById->api_id)->get()->first();

        foreach ($anotherLeads as $other) {
            $other->summary = $page_user->epic.'/'.$other->api->api;
            $other->created = $other->created_at->format('d M Y');
            $other->priority->code = $other->priority->id;
            $other->priority->name = $other->priority->priority;
            $other->priority_icon = $other->priority->icon_url;
            $other->status->code = $other->status->id;
            $other->status->name = $other->status->status;
            if (!empty($other->user)) {
                $other->user;
                $other->user->avatar = $other->user->avatar_url;
            }
        }

        $status = Status::all('id as code', 'status as name');
        $priorities = Priority::all('id as code', 'priority as name', 'icon_url');

        $leadById->summary = $page_user->epic;
        $leadById->priority->code = $leadById->priority->id;
        $leadById->priority->name = $leadById->priority->priority;
        $leadById->priority_icon = $leadById->priority->icon_url;
        $leadById->status->code = $leadById->status->id;
        $leadById->status->name = $leadById->status->status;
        if (!empty($other->user)) {
            $leadById->user;
            $leadById->avatar_url = $leadById->user->avatar_url;
        }
        $leadById->created = $leadById->created_at->format('d M');
        $leadById->comments;

        
        foreach ($fields->fields as $field) {
          $columns[] = array(
            'field' => 'data.'.$field['name'],
            'header' => $field['description']
          );
        }
        $leadById->columns = $columns;

        foreach ($leadById->comments as $comment){
            $comment->user = User::find($comment->user_id);
            $comment->created = $comment->created_at->format('d M Y');
            $comment->avatar_url = $comment->user->avatar_url;
        }

        return response()->json([
            'lead' => $leadById,
            'status' => $status,
            'priorities' => $priorities,
            'another_leads' => $anotherLeads,
        ]);
    }

    //todo: verificar o perfil do usuário
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
            $comment = new Comment;
            $comment->user_id = $request->input('user_id');
            $comment->comment = $request->input('comment');
            $comment->save();
            $comment->lead()->attach([$request->input('lead_id')]);
            $comment->user = User::find(Auth::id());
            $comment->created = $comment->created_at->format('d M Y');
            $comment->avatar_url = $comment->user->avatar_url;

            return response()->json($comment, 201);
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

    //todo: verificar o perfil do usuário que faz a requisição
    public function report(){
        $oneWeekAgo = \Carbon\Carbon::today()->subWeek();
        $user = User::find(Auth::id());

        $page_user = $user->page()->first();

        $allLeads = Lead::where('page_id', $page_user->id)->count();
        $last7days = Lead::where('page_id', $page_user->id)->whereDate('created_at','>=',$oneWeekAgo)->count();
        $newLeads = Lead::where('page_id', $page_user->id)->where('status_id', 1)->count();
        $closedLeads = Lead::where('page_id', $page_user->id)->where('status_id', 4)->count();
        $activity = Lead::where('page_id', $page_user->id)->where('user_id', Auth::id())->select('id', 'api_id', 'priority_id')->get();

        foreach($activity as $ac) {
            $ac->summary = $page_user->epic.'/'.$ac->api->api;
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

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteData(Request $request) {
        $dataValidation = [
            'id' => 'required|numeric',
        ];
        $this->validate($request, $dataValidation);

        $data = Lead::find($request->input('id'));
        $data->comments()->detach();
        $data->delete();

        return response()->json($data, 200);
    }

    public function getAllData() {
        $user = User::find(Auth::id());
        $page_user = $user->page()->first();
        $columns = [];

        $data = Api::where('page_id', $page_user->id)->get();
        foreach ($data as $value) {
            $value->data = Lead::where('api_id', $value->id)->get();
            foreach ($value->fields as $field) {
                $columns[$value->api][] = array(
                    'field' => 'data.'.$field['name'],
                    'header' => $field['description']
                );
            }
        }

        return response()->json([
            'data' =>  $data,
            'columns' => $columns
        ]);
    }
}
