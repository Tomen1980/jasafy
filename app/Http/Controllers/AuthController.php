<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // return dd($validation);

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response(
                [
                    'message' => 'success',
                    'data' => Auth::user(),
                ],
                200,
            );
        }

        return response(
            [
                'message' => 'Error, email or password is wrong',
            ],
            200,
        );
    }

    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:5',
            'password_confirmation' => 'required|string|min:5',
            'phone_number' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        $checkEmail = User::where('email', $validation['email'])->first();
        $checkUser = User::where('username', $validation['username'])->first();
        if ($checkEmail) {
            return response()->json(['error', 'Email already exists!'], 401);
        } elseif ($checkUser) {
            return response()->json(['error', 'Username already exists!'], 401);
        } elseif ($validation['password'] != $validation['password_confirmation']) {
            return response()->json(['error', 'Password doesn\'t match!'], 401);
        }

        $user = User::create([
            'name' => $validation['name'],
            'username' => $validation['username'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
            'phone_number' => $validation['phone_number'],
            'role' => $validation['role'],
            'image' => 'default.jpg',
        ]);

        return response()->json(
            [
                'message' => 'success',
            ],
            201,
        );
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(
            [
                'message' => 'Logout success',
            ],
            200,
        );
    }

    public function getProfile()
    {
        return response()->json([
            'message' => 'Success',
            'data' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
       

        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|min:6',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // Pengecekan Data
        $checkData = User::where('id', Auth::user()->id)->first();
       
        // email input sama seperti email yang skrng
        if ($checkData->email == $validation['email']) {
            $emailVerify = $checkData->email;
        } else {
            // Chekc e mail yang diganti sama atau tidak
            $checkEmail = User::where('email', $validation['email'])->first();
            // jika sama eror
            if ($checkEmail) {
                return response()->json([
                    'message' => 'Email already exists!',
                ]);
            } else {
                $emailVerify = $validation['email'];
            }
        }
        
        // Pengecekan User
        $checkData = User::where('id', Auth::user()->id)->first();
        // user input sama seperti email yang skrng
        if ($checkData->username == $validation['username']) {
            $userVerify = $checkData->username;
        } else {
            // Chekc e mail yang diganti sama atau tidak
            $checkUsername = User::where('username', $validation['username'])->first();
            // jika sama eror
            if ($checkUsername) {
                return response()->json([
                    'message' => 'Username already exists!',
                ]);
            } else {
                $userVerify = $validation['username'];
            }
        }

        if ($validation['password'] != $validation['password_confirmation']) {
            return response()->json(['error', 'Password doesn\'t match!'], 401);
        }

        // Pengecekan upload foto
        $image = $request->file('image');
        if ($image) {
            $imageHash = $image->hashName();
            // Jika gambar tdk default maka hapus gambar lama
            if ($image !== 'default.jpg') {
                Storage::delete('public/profile/' . $checkData->image);
            }
            $image->storeAs('public/profile/', $imageHash);
        } else {
            $imageHash = $checkData->image;
        }

        $user = User::find(Auth::user()->id);
        $user->name = $validation['name'];
        $user->username = $userVerify;
        $user->email = $emailVerify;
        $user->password = Hash::make($validation['password']);
        $user->phone_number = $validation['phone_number'];
        $user->image = $imageHash;
        $user->save();
        return response()->json(
            [
                'message' => 'success, updated',
            ],
            200,
        );
    }
}
