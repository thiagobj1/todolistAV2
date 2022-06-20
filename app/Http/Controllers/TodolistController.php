<?php

namespace App\Http\Controllers;

use App\Models\todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tasks = todolist::all();
            return response()->json($tasks, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //$todolist = new todolist();
            //$todolist->title = $request->title;
            //$todolist->description = $request->description;
            //$todolist->deadline = $request->deadline;
            //$todolist->save();
            todolist::create($request->all());
            return response()->json(['message' => 'Tarefa criada com sucesso'], 200);
        } catch (\Exception ) {
            return response()->json(['message' => 'Erro ao criar tarefa'], 500);
        }
        return response()->json(['message' => 'Vou salvar os dados'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $todolist = todolist::findOrFail($id);
            $todolist->title = $request->title;
            $todolist->description = $request->description;
            $todolist->deadline = $request->deadline;
            $todolist->save();
            todolist::create($request->all());
            return response()->json(['message' => 'Tarefa atualizada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar tarefa'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $todolist = todolist::findOrFail($id);
            $todolist ->delete();
            return response()->json(['message' => 'Tarefa deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar tarefa: ' .$e->getMessage()], 500);
        }
    }
}
