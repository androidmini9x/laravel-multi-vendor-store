<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();

        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(), 
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'birth_date' => 'nullable|date',
            'locale' => 'required|size:2',
            'country' => 'required|size:2',
            'gender' => 'nullable|in:male,female',
        ]);

        $request->user()->profile->fill($request->all())->save();

        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
