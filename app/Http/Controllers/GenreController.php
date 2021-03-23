<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Facade\FlareClient\View;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('genres.index', ['genres' => Genre::all()]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        if (request('q')) {
            $key = request('q');
            // search through secondary genre relationships
            $titlesSub = $genre->titlesSecondary()->where('title', 'like', "%$key%")->limit(10)->get();

            // search directly via relationship genre title. they have 2 relationships, one direct and one indirect. this is the former.
            $titlesMain = $genre->hasMany(\App\Models\Title::class)->where('title', 'like', "%$key%")->limit(10)->get();
            // merge them together
            $titles = (collect($titlesSub->merge($titlesMain)));
        } else {
            $titlesSub = $genre->titlesSecondary()->limit(15)->get();
            $titlesMain = $genre->hasMany(\App\Models\Title::class)->limit(15)->get();
            $titles = (collect($titlesSub->merge($titlesMain)));
        }
        return view('genres.show', ['genre' => $genre, 'titles' => $titles]);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
