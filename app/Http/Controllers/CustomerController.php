<?php

namespace App\Http\Controllers;

use App\Helpers\StrHelper;
use App\Http\Requests\Customers\RegisterRequest;
use App\Http\Requests\Customers\UpdateRequest;
use App\Models\Customer;
use App\Models\Person;
use App\Models\ResultResponse;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Customer::orderBy('id')
            ->where('status',Customer::STATUS_ACTIVE)
            ->with('person')
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
            $person = Person::create([
                "dni" => $request->dni,
                "iban" => $request->iban,
                "gender" => $request->gender,
                "name" => $request->name,
                "last_name" => $request->last_name,
                "phone" => $request->phone,
                "address" => $request->address,
                "country" => $request->country,
                "birth_date" => $request->birth_date
            ]);

            if($person  == null)
                throw new Exception('Error al crear Persona');

            $person->code = StrHelper::generateCode('PER',$person->id, 5);
            $person->save();

            $customer = Customer::create([
                "access_code" => $request->access_code,
                "people_id" => $person->id
            ]);

            if($customer == null)
                throw new Exception('Error al crear Cliente');

            $customer->code = StrHelper::generateCode('CLI',$customer->id, 5);
            $customer->save();

            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->dni),
                "people_id" => $person->id,
                "aboutYou" => "Cliente {$request->name} ingresado automaticamente"
            ]);

            $user->createToken('auth_token')->plainTextToken;

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $customer);
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
            $customer = Customer::with('person')->firstWhere('id', $id);
            if($customer == null || $customer->person == null)
                throw new Exception("Recurso no encontrado");

            $customer->access_code = $request->access_code;

            $person = Person::find($customer->person->id);
            if($person  == null)
                throw new Exception('Recurso no encontrado');

            $customer->person->name = $request->name;
            $customer->person->last_name = $request->last_name;
            $customer->person->phone = $request->phone;
            $customer->person->address = $request->address;
            $customer->person->country = $request->country;
            $customer->person->birth_date = $request->birth_date;
            $customer->person->save();
            $customer->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, $customer);
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
            $customer = Customer::with('person')->firstWhere('id', $id);
            if($customer == null)
                throw new Exception("Recurso no encontrado");

            $response->setResponse(ResultResponse::CODE_SUCCESS,ResultResponse::TXT_SUCCESS, $customer);
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
            $customer = Customer::with('person')->firstWhere('id', $id);
            if($customer == null)
                throw new Exception("Recurso no encontrado");

            $user = User::firstWhere('people_id',$customer->person->id);
            if($user == null)
                throw new Exception("Recurso no encontrado");

            $customer->delete();

            $customer->person->delete();

            $user->delete();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, null);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }
}
