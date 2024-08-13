<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class StudentProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('student.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile picture.
     */
    public function updateProfilePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_picture_data' => 'nullable|string',
        ]);

        $user = Auth::user();

        if ($request->profile_picture_data) {
            $data = $request->profile_picture_data;
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $imageName ='profile-pics/' . uniqid() . '.png';
            Storage::disk('public')->put($imageName, $data);
            $user->profile_picture = $imageName;
        } elseif ($request->hasFile('profile_picture')) {
            $originalFileName = $request->file('profile_picture')->getClientOriginalName();
            $user->profile_picture = $request->file('profile_picture')->storeAs('profile-pics', $originalFileName, 'public');
        }

        $user->save();

        return back()->with('status', 'Profile picture updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');


    }
}