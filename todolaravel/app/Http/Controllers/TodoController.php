<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Resources\TodoResource;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    public function index()
    {
        return TodoResource::collection(Todo::all());
    }

    public function store(Request $request)
    {
        $new_todo = Todo::create($request->all());
        return response()->json([
            'data' => new TodoResource($new_todo),
            'message' => 'Successfully added new event!',
            'status' => Response::HTTP_CREATED
        ]);
    }

    public function show(Todo $todo)
    {
        return new TodoResource($todo);
    }

    public function update(Request $request, Todo $todo)
    {
        $todo->update($request->all());
        return response()->json([
            'data' => new TodoResource($todo),
            'message' => 'Successfully updated event!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response('Event removed successfully!', Response::HTTP_NO_CONTENT);
    }
}




















    // protected $todo;
    // public function __construct()
    // {
    //     $this->todo = new Todo();
    // }
    // /**
    //  * Display a listing of the resource.
    //  */
    // // public function index()
    // // {
    // //     try {
    // //         return response()->json($this->todo->all(), 200);
    // //     } catch (\Exception $e) {
    // //         return response()->json(['error' => $e], 500);
    // //     }
    // // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    //     try {
    //         $todo = $this->todo->create($request->all());
    //         return response()->json($todo, 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e], 500);
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    //     try {
    //         $todo = $this->todo->find($id);
    //         if (!$todo) {
    //             return response()->json(['error' => 'todo not found'], 404);
    //         }
    //         return response()->json($todo, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e], 500);
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    //     try {
    //         $todo = $this->todo->find($id);
    //         if (!$todo) {
    //             return response()->json(['error' => 'Todo not found'], 404);
    //         }
    //         $todo->update($request->all());
    //         return response()->json($todo, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e], 500);
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    //     try {
    //         $todo = $this->todo->find($id);
    //         if (!$todo) {
    //             return response()->json(['error' => 'todo not found'], 404);
    //         }
    //         $todo->delete();
    //         return response()->json(['message' => 'Todo delete successfully'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e], 500);
    //     }
    // }
    // // this method will show calender page
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Todo::whereDate('start', '>=', $request->start)
    //             ->whereDate('end',   '<=', $request->end)
    //             ->get(['id', 'title', 'description', 'color', 'start', 'end']);
    //         return response()->json($data);
    //     }
    //     return view('calender');
    // }

    // // this method provide action in calender page
    // public function action(Request $request)
    // {
    //     if ($request->ajax()) {
    //         if ($request->type == 'add') {
    //             $event = Todo::create([
    //                 'title'        =>    $request->title,
    //                 'description'        =>    $request->description,
    //                 'color'        =>    $request->color,
    //                 'start'        =>    $request->start,
    //                 'end'        =>    $request->end
    //             ]);

    //             return response()->json($event);
    //         }

    //         if ($request->type == 'update') {
    //             $event = Todo::find($request->id)->update([
    //                 'title'        =>    $request->title,
    //                 'description'        =>    $request->description,
    //                 'color'        =>    $request->color,
    //                 'start'        =>    $request->start,
    //                 'end'        =>    $request->end
    //             ]);

    //             return response()->json($event);
    //         }

    //         if ($request->type == 'delete') {
    //             $event = Todo::find($request->id)->delete();

    //             return response()->json($event);
    //         }
    //     }
    // }
