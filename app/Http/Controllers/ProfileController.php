<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile.index', [
            'title' => 'Profile',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', 'unique:users,username,'.Auth::id()],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $manager = new ImageManager(new Driver);

            $image = $request->file('profile_picture');

            $compressedImage = $manager
                ->read($image->getPathname())
                ->scale(width: 800)
                ->toJpeg(75);

            $filename = 'profile_'.time().'.jpg';

            Storage::disk('public')->put('profile_pictures/'.$filename, (string) $compressedImage);

            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = 'profile_pictures/'.$filename;
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'profile_picture' => $user->profile_picture,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
