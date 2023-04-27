<?php

namespace App\Http\Controllers;

use App\Helpers\StrHelper;
use App\Http\Requests\Instructors\RegisterByPersonRequest;
use App\Http\Requests\Instructors\RegisterRequest;
use App\Models\Customer;
use App\Models\Instructor;
use App\Models\Person;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Instructor::orderBy('id')
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

            $instructor = Instructor::create([
                "speciality" => $request->speciality,
                "people_id" => $person->id
            ]);

            if($instructor == null)
                throw new Exception('Error al crear Instructor');

            $instructor->code = StrHelper::generateCode('INS',$instructor->id, 5);
            $instructor->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $instructor);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_ERROR,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerByPerson(RegisterByPersonRequest $request)
    {
        $response = new ResultResponse();
        try {

            $person = Person::find($request->people_id);

            if($person == null)
                throw new Exception('Recurso no encontrado');

            $instructor = Instructor::create([
                "speciality" => $request->speciality,
                "people_id" => $request->people_id
            ]);

            if($instructor == null)
                throw new Exception('Error al crear Instructor');

            $instructor->code = StrHelper::generateCode('INS',$instructor->id, 5);
            $instructor->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $instructor);
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
            $instructor = Instructor::with('person')->firstWhere('id', $id);
            if($instructor == null || $instructor->person == null)
                throw new Exception("Recurso no encontrado");

            $instructor->speciality = $request->speciality;

            $person = Person::find($instructor->person->id);
            if($person  == null)
                throw new Exception('Recurso no encontrado');

            $instructor->person->name = $request->name;
            $instructor->person->last_name = $request->last_name;
            $instructor->person->phone = $request->phone;
            $instructor->person->address = $request->address;
            $instructor->person->country = $request->country;
            $instructor->person->birth_date = $request->birth_date;
            $instructor->person->save();
            $instructor->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, $instructor);
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
            $customer = Instructor::with('person')->firstWhere('id', $id);
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
            $instructor = Instructor::with('person')->firstWhere('id', $id);
            if($instructor == null)
                throw new Exception("Recurso no encontrado");

            $instructor->delete();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, null);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }
}
