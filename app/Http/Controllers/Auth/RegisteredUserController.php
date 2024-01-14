<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {   
        // Make a get request to get just the names of all countries, ordered by name
        $countries = json_decode(file_get_contents('https://restcountries.com/v3.1/all?fields=name'), true);

        // Order the array by the name of the country
        usort($countries, function($a, $b) {
            return $a['name']['common'] <=> $b['name']['common'];
        });

        $skills = Skill::all();
        return view('website.signup' , compact('skills' , 'countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required' , 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:15', 'unique:'.User::class],
            'country' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:255'],
            'profile_picture' => 'image|mimes:png,jpg,jpeg,svg|max:2048',
            'skills' => 'required|array|min:1|max:5',
        ]);

        // Store the profile picture in the storage folder
        if($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $request->profile_picture = $path;
        }else{
            $request->profile_picture = 'profile_pictures/pp.png';
        }


        // Create the user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?? null,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'country' => $request->country,
            'bio' => $request->bio ?? null,
            'profile_picture' => $request->profile_picture ?? null,
        ]);

        

        // Store the user's skills in the pivot table
        foreach($request->skills as $skill) {
            $user->skills()->attach($skill);
        }


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::ROOMS);
    }
}
