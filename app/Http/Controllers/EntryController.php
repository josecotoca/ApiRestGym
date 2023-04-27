<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entries\RegisterRequest;
use App\Models\Entry;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Entry::orderBy('id')
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
            $entry = Entry::where('customer_id',$request->customer_id)
                    ->whereNull('date_output')->first();

            if($entry != null){
                $entry->date_output = $request->date;
                $entry->save();
            } else {
                $entry = Entry::create([
                    'date_input' => $request->date,
                    'customer_id' => $request->customer_id
                ]);
            }

            if($entry == null)
                throw new Exception("Error al registrar la entrada");


            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $entry);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_ERROR,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }

}

