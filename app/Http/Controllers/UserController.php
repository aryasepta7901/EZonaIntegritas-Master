<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Satker;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $this->authorize('admin');
        //
        return view(
            'users.index',
            [
                'title' => 'Mengelola Pengguna',
                'users' => User::latest()->get(),
                'level' => Level::all(),
                'satker' => Satker::all(),
            ]

        );
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

        $validatedData = $request->validate([
            'id' => 'required|unique:users', //nip
            'name'  => 'required|min:5',
            'email'  => 'required|email:dns|unique:users',
            'no_telp' => 'required|min:11',
            'satker_id' => 'required',
            'level_id' => 'required',

        ]);



        $validatedData['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        User::create($validatedData);

        return redirect('/users')->with('success', 'New Users Has Ben Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'no_telp' => 'required|min:11',
            'satker_id' => 'required',
            'level_id' => 'required',

        ]);
        User::where('id', $user->id)->update($validatedData);
        return redirect('/users')->with('success', 'User Has Ben Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        User::destroy($user->id);
        return redirect('/users')->with('success', 'User Has Ben Deleted');
    }
}
