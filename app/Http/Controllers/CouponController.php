<?php

namespace App\Http\Controllers;

use App\Helpers\StrHelper;
use App\Http\Requests\Coupons\RegisterRequest;
use App\Models\Coupon;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Coupon::orderBy('id')
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

            $coupon = Coupon::create([
                "number_of_uses" => $request->number_of_uses,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "type" => $request->type,
            ]);

            if($coupon  == null)
                throw new Exception('Error al crear el cupon');

            $coupon->code = StrHelper::generateCode('CUP',$coupon->id, 5);
            $coupon->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $coupon);
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
            $coupon = Coupon::find($id);
            if($coupon == null)
                throw new Exception("Recurso no encontrado");

            $coupon->number_of_uses = $request->number_of_uses;
            $coupon->start_date = $request->start_date;
            $coupon->end_date = $request->end_date;
            $coupon->type = $request->type;

            $coupon->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, $coupon);
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
            $coupon = Coupon::find($id);
            if($coupon == null)
                throw new Exception("Recurso no encontrado");

            $response->setResponse(ResultResponse::CODE_SUCCESS,ResultResponse::TXT_SUCCESS, $coupon);
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
            $coupon = Coupon::find($id);
            if($coupon == null)
                throw new Exception("Recurso no encontrado");

            $coupon->delete();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, null);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }
}
