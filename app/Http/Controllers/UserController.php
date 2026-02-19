<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Http;

class UserController extends Controller
{
    public function index(Request $request){
        $query = User::with(['details', 'location']);

        /* filter by gender */
        if ($request->gender) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        /* filter by city */
        if ($request->city) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        /* filter by country */
        if ($request->country) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        /* no of records by default 10  */
        $limit = $request->limit ?? 10;
        $users = $query->limit($limit)->get();

        $selected_fields = $request->selected_fields ? explode(',', $request->selected_fields) : ['name','email','gender','city','country'];
        $result = $users->map(function ($user) use ($selected_fields) {

            $data = [
                'name'    => $user->name,
                'email'   => $user->email,
                'gender'  => $user->details?->gender,
                'city'    => $user->location?->city,
                'country' => $user->location?->country,
            ];

            /*  only selected fields */
            return collect($data)->only($selected_fields);
        });

        return response()->json($result);

    }
    
    
}
