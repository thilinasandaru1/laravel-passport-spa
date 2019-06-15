<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register()
    {
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        return response()->json(['status' => 201]);
    }

    public function login()
    {
       // check if a user with the specified email exists
       $user = User::whereEmail(request('username'))->first();

       if(!$user)
       {
           return response()->json([
               'message' => 'Wrong email or password',
               'status' => 422
           ], 422);
       }

       // If a user with the email was found - check if the specified password
       // belongs to this user
       if(!Hash::check(request('password'), $user->password))
       {
           return response()->json([
               'message' => 'Wrong email or password',
               'status' => 422
           ], 422);
       }

       // Send an internal API request to get an access token
       $clinet = DB::table('oauth_clients')
        ->where('password_client', true)
        ->first();

       // Make sure a password client exists in the DB
       if(!$client)
       {
           return response()->json([
               'message' => 'Laravel Passport is not setup properly.',
               'status' => 500
           ], 500);
       }

       $data = [
           'grant_type' => 'password',
           'client_id' => $client->id,
           'client_secret' => $client->secret,
           'username' => request('username'),
           'password' => request('password')
       ];

       $request = Request::create('/oauth/token', 'POST', $data);
       $response = app()->handle($request);

       // check if the request was successful
       if($response->getStatusCode() != 200)
       {
           return response()->json([
               'message' => 'Wrong email or password',
               'status' => 422
           ], 422);
       }

       // Get the data from the response
       $data = json_decode($response->getContent());

       // Format the final response in a desirable format
       return response()->json([
           'token' => $data->access_token,
           'user' => $user,
           'status' => 200
       ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);
        
        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }
}
