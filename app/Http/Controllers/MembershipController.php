<?php

namespace App\Http\Controllers;

use App\Helpers\StrHelper;
use App\Http\Requests\Memberships\RegisterRequest;
use App\Models\Membership;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Membership::orderBy('id')
            ->simplePaginate($perPage);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $response = new ResultResponse();
        try {
            $membership = Membership::create([
                "duration" => $request->duration,
                "price" => $request->price,
                "type" => $request->type
            ]);

            if($membership  == null)
                throw new Exception('Error al crear la membresía');

            $membership->code = StrHelper::generateCode('MEM',$membership->id, 5);
            $membership->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $membership);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_ERROR,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }

    /**
     * Store a updated resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RegisterRequest $request, $id)
    {
        $response = new ResultResponse();
        try {
            $member = Membership::find($id);
            if($member == null)
                throw new Exception("Recurso no encontrado");

            $member->duration = $request->duration;
            $member->price = $request->price;

            $member->type = $request->type;

            $member->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, $member);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_ERROR,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }

    /**
     * Find a resource in storage.
     *
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function find($id)
    {
        $response = new ResultResponse();
        try {
            $membership = Membership::find($id);
            if($membership == null)
                throw new Exception("Recurso no encontrado");

            $response->setResponse(ResultResponse::CODE_SUCCESS,ResultResponse::TXT_SUCCESS, $course);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }

    /**
     * Remove a resource in storage.
     *
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $response = new ResultResponse();
        try {
            $membership = Membership::find($id);

            $membership->delete();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, null);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }
}
