<?php

namespace App\Http\Controllers;

use App\Helpers\StrHelper;
use App\Http\Requests\Receipts\UpdateRequest;
use App\Http\Requests\Receipts\RegisterRequest;
use App\Models\Contract;
use App\Models\Receipt;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ReceiptController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Receipt::orderBy('id')
            ->simplePaginate($perPage);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request, $idContract)
    {
        $response = new ResultResponse();
        try {
            $contract = Contract::find($idContract);
            if($contract->status == Contract::STATUS_ANNULLED)
                throw new Exception("No es posible actualizar pagos de un contrato en estado {$contract->status}" );

            $receipt = Receipt::create([
                "contract_id" => $idContract,
                "description" => $request->description,
                "date" => $request->date,
                "amount" => $request->amount
            ]);

            if($receipt  == null)
                throw new Exception('Error al crear el recibo');

            $receipt->code = StrHelper::generateCode('REC',$contract->id, 5);
            $receipt->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $receipt);
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
            $receipt = Receipt::find($id);
            if($receipt == null)
                throw new Exception("Recibo no encontrado");


            $contract = Contract::find($receipt->contract_id);
            if($contract == null)
                throw new Exception("Contrato no encontrado");

            if($contract->status == Contract::STATUS_ANNULLED)
                throw new Exception("No es posible actualizar pagos de un contrato en estado {$contract->status}" );


            $receipt->description = $request->description;
            $receipt->amount = $request->amount;

            $receipt->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, $receipt);
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
            $receipt = Receipt::find($id);
            if($receipt == null)
                throw new Exception("Recurso no encontrado");

            $response->setResponse(ResultResponse::CODE_SUCCESS,ResultResponse::TXT_SUCCESS, $receipt);
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
            $receipt = Receipt::find($id);
            if($receipt == null)
                throw new Exception("Recurso no encontrado");


            $contract = Contract::find($receipt->contract_id);
            if($contract == null)
                throw new Exception("Contrato no encontrado");

            if($contract->status == Contract::STATUS_ANNULLED)
                throw new Exception("No es posible actualizar pagos de un contrato en estado {$contract->status}" );

            $receipt->delete();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, null);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }
}
