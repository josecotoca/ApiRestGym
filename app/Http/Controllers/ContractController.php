<?php

namespace App\Http\Controllers;

use App\Helpers\StrHelper;
use App\Http\Requests\Contracts\RegisterRequest;
use App\Http\Requests\Contracts\UpdateRequest;
use App\Models\Contract;
use App\Models\Receipt;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Pagination\Paginator;

class ContractController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Contract::orderBy('id')
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
            $contract = Contract::create([
                "customer_id" => $request->customer_id,
                "coupon_id" => $request->coupon_id,
                "membership_id" => $request->membership_id,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "amount_payment" => $request->amount_payment,
            ]);

            if($contract  == null)
                throw new Exception('Error al crear el contrato');

            $contract->code = StrHelper::generateCode('CTR',$contract->id, 5);
            $contract->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $contract);
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
    public function update(UpdateRequest $request, $id)
    {
        $response = new ResultResponse();
        try {
            $contract = Contract::find($id);
            if($contract == null)
                throw new Exception("Contrato no encontrado");

            if($contract->status != Contract::STATUS_ACTIVE)
                throw new Exception("No es posible modificar un contrato en estado {$contract->status}" );

            $contract->start_date = $request->start_date;
            $contract->end_date = $request->end_date;
            $contract->status = $request->status;

            $contract->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, $contract);
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
            $contract = Contract::find($id);
            if($contract == null)
                throw new Exception("Recurso no encontrado");

            $response->setResponse(ResultResponse::CODE_SUCCESS,ResultResponse::TXT_SUCCESS, $contract);
            }catch(Exception $ex){
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
            $contract = Contract::find($id);
            if($contract->status != Contract::STATUS_ACTIVE)
                throw new Exception("No es posible eliminar un contrato en estado {$contract->status}" );

            $contract->delete();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, null);
        }catch(Exception $ex){
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }
}
