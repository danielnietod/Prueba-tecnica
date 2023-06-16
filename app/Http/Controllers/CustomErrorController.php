<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomErrorController extends Controller
{
    public function create()
    {
        return view('form');
    }
   
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users'
            ], 
            [
                'name.required' => 'El nombre solo acepta letras y espacios.',
                'password.required' => 'La contraseña debe tener al menos una mayuscula, una minuscula, unn numero, y un caracter especial.'
            ]
          );
    
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
     
        return back()->with('success', 'User created successfully.');
    }
}
