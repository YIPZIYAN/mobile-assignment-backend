<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {

        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json([
                'errors' => 'Credentials does not match',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        Auth::login($user);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('login')->plainTextToken,
        ], 200);
    }

    public function register(StoreUserRequest $request)
    {
        //user register
        $tel = '+60'.$request->phone;
        $companyTel = '+60'.$request->contact_number;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $tel,
            'description' => $request->description,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        //employer register
        if ($request->is_employer) {

            if ($request->is_new_company=="true") {
                //new company register
                $company = Company::firstOrCreate([
                    'name' => $request->company_name,
                    'contact_number' => $companyTel,
                    'email' => $request->company_email,
                    'reg_no' => $request->reg_no,
                    'location' => $request->company_location,
                    'description' => $request->company_description,
                ]);
            } else {
                $company = Company::where('name', 'LIKE', "%{$request->search_company}%")->first();
            }

            $user->is_employer = true;
            $user->company()->associate($company)->save();
        }

        event(new Registered($user));

        // Auth::login($user);

        // $response = array_merge($request->all(), [
        //     'token' => $user->createToken('login')->plainTextToken,
        // ]);

        return response()->json([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->about,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ], 200);
    }

    public function logout()
    {

        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout successfully',
        ], 200);
    }

    //show my profile
    public function myProfile()
    {
        return response()->json(Auth::user());
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        $phone = "+60".$request->phone;
        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $phone,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        return response()->json();
    }

    public function resetPassword(UpdatePasswordRequest $request)
    {
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json();
    }
}
