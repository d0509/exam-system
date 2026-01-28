<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Plank\Mediable\Facades\MediaUploader;

class ProfileController extends Controller
{

    public function showUser($id)
    {
        $user = Auth::user();
        return view('admin.pages.profile.show', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        return view('admin.pages.profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $oldEmail = Auth::user()->email;
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ];
        $validated = $request->validate($rules);
        // Find the user
        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            $rules['profile_photo'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
            if ($user->hasMedia('profile_photo')) {
                $user->getMedia('profile_photo')->each->delete();
            }
            $media = MediaUploader::fromSource($request->file('profile_photo'))
                ->toDisk('public')
                ->toDirectory('profile_photos')
                ->upload();
            $user->attachMedia($media, 'profile_photo');
        }

        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->save();
        if ($oldEmail != $validated['email']) {
            Auth::logout();
        }
        return redirect()->route('admin.profile.edit', $id)->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
        }

        $newPassword = Hash::make($request->password);
        $user = Auth::user();
        $user->password = $newPassword;
        $user->save();
        Auth::logout();
        return redirect()->route('login')->with('success', 'Password updated successfully.');
    }
}
