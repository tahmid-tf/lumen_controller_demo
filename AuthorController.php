<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules =
            [
                'name' => 'required|max:255|unique:authors',
                'gender' => 'required|max:255|in:male,female',
                'country' => 'required|max:255'
            ];


        $this->validate($request,$rules);

        $author = Author::create($request->all());
        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::findOrFail($id);

        return $this->successResponse($author);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $rules =
        [
            'name' => 'max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'max:255'
        ];


        $this->validate($request,$rules);

        $author = Author::findOrFail($id);
        $author->fill($request->all());

       if($author->isClean()){
        return $this->errorResponse("At least one value must be changed",Response::HTTP_UNPROCESSABLE_ENTITY);
       }

       $author->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        $author->delete();
        return $this->successResponse($author);
    }
}
