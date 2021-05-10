<?php

namespace App\Http\Controllers;

use App\Page;
use App\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use  App\User;
use  App\Api;

class ApiController extends Controller
{

    public  function select() {
        $user = User::find(Auth::id());
        $page_user = $user->page()->first();

        return response()->json([
            'apis' =>  Api::where('page_id', $page_user->id)->get(),
        ]);
    }

    /**
     * Store a new API.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeApi(Request $request) {
        $user_admin = User::find(Auth::id());
        $page_user = $user_admin->page()->first();

        $data = $request->all();
        try {
            foreach ($data as $api) {
                Api::updateOrCreate(
                    ['weight' => $api['weight'], 'page_id' => $page_user->id],
                    [
                        'api' => $api['api'],
                        'fields' => json_encode($api['fields']),
                    ]
                );
            }

            return response()->json( [
                'success' => [
                    'message' => 'Api Salva com sucesso'
                ],
            ], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json([
                'entity' => 'users',
                'action' => 'create',
                'result' => 'failed'
            ], 409);
        }
    }

    /**
     * Delete an API.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteApi(Request $request) {
        $dataValidation = [
            'api_id' => 'required|numeric',
        ];
        $this->validate($request, $dataValidation);

        $api = Api::find($request->input('api_id'));
        $api->delete();

        return response()->json($api, 200);
    }

    /**
     * Store API Data.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeData($page, $api, Request $request) {
        $page = Page::where('epic', $page)->first();
        $api = Api::where('api', $api)->first();

        if (empty($page) || empty($api)){
            dd('empty');
        }

        $fields = json_decode($api->fields);
        $validation = array();
        $values = array();
        
        foreach($request->all() as $key => $value) {
            foreach ($fields as $field) {
                if ($key == $field->name ) {
                    $validation[$key] = $field->type->code;
                    $values[$key] = $value;
                }
            }
        }
        $this->validate($request, $validation);

        try {
            $data = new Data;
            $data->api_id = $api->id;
            $data->data = json_encode($values);
            $data->save();
        } catch (\Exception $e) {
            //return error message
            return response()->json([
                'entity' => 'api',
                'action' => 'store data',
                'result' => 'failed'
            ], 409);
        }

        return $data;
    }
}
