<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Team;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $teams = Team::where('name', 'LIKE', "%$keyword%")
                ->orWhere('address', 'LIKE', "%$keyword%")
                ->orWhere('year_founded', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $teams = Team::latest()->paginate($perPage);
        }
        $error_message=Session::get('error_message');
        if(Session::has('error_message'))
        {
            Session::forget('error_message');
        }
        return view('teams.index', compact('teams'))->with('error_message',$error_message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   
        if(Session::has('error_message'))
        {
            Session::forget('error_message');
        }
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
                $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'year_founded' => 'required',
        ]);
        $requestData = $request->all();
        
        Team::create($requestData);

        return redirect('teams')->with('flash_message', 'Team added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        if(Session::has('error_message'))
        {
            Session::forget('error_message');
        }
        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);

        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        if(Session::has('error_message'))
        {
            Session::forget('error_message');
        }
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'year_founded' => 'required',
        ]);
        $requestData = $request->all();
        
        $team = Team::findOrFail($id);
        $team->update($requestData);

        return redirect('teams')->with('flash_message', 'Team updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
         $team = Team::findOrFail($id);
        try {
             $team->delete();
            } 
        catch (\Illuminate\Database\QueryException $e) {

                if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                    session(['error_message' => 'Cannot delete while has/have players. Remove first player/s to proceed.']);
                }
    }
        return redirect('teams')->with('flash_message', 'Team deleted!');
    }

}
