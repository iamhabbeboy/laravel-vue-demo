<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $user = Auth()->user();
        sleep(3);
        $data = Todo::query()->where('user_id', $user->id)->get();
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Todo::where('user_id', $request->user()->id)->where('title', $request->title);
        if ($data->first()) {
            return response()->json(['status' => false, 'message' => 'Already exist']);
        }
        $req = $request->all();
        $req['user_id'] = $request->user()->id;
        $data = Todo::create($req);
        return response()->json(['status' => true, 'data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $response = Todo::findOrFail($id);
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validateUser = Validator::make($request->all(),
            [
                'has_completed' => 'required',
            ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $data = Todo::find($id);
        $data->has_completed = $request->has_completed;
        $data->update();
        return response()->json(['status' => true, 'data' => $data], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        throw_if(!$id, 'todo Id is missing');
        Todo::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'todo deleted']);
    }
}
