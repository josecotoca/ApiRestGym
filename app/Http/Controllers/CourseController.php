<?php

namespace App\Http\Controllers;

use App\Helpers\StrHelper;
use App\Http\Requests\Courses\RegisterRequest;
use App\Models\Course;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Pagination\Paginator;

class CourseController extends Controller
{
    public function paginate(int $perPage = 10): Paginator
    {
        $data = Course::orderBy('id')
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

            $course = Course::create([
                'name' => $request->name,
                'number_places' => $request->number_places,
                'start_hour' => $request->start_hour,
                'end_hour' => $request->end_hour,
                'start_date' => $request->start_date
            ]);

            if($course  == null)
                throw new Exception('Error al crear el curso');

            $course->code = StrHelper::generateCode('CO',$course->id, 5);
            $course->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_CREATED,ResultResponse::TXT_SUCCESS, $course);
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
            $course = Course::find($id);
            if($course == null)
                throw new Exception("Recurso no encontrado");

            $course->name = $request->name;
            $course->number_places = $request->number_places;
            $course->start_hour = $request->start_hour;
            $course->end_hour = $request->end_hour;
            $course->start_date = $request->start_date;

            $course->save();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, $course);
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
            $course = Course::find($id);
            if($course == null)
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
            $course = Course::find($id);
            if($course == null)
                throw new Exception("Recurso no encontrado");

            $course->delete();

            $response->setResponse(ResultResponse::CODE_SUCCESS_ACCEPTED,ResultResponse::TXT_SUCCESS, null);
        } catch(Exception $ex) {
            $response->setResponse(ResultResponse::CODE_NOT_FOUND,ResultResponse::TXT_ERROR, $ex->getMessage());
        }
        return response()->json($response,$response->getStatusCode());
    }
}
