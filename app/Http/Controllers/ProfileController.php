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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        
        // Data yang akan di-update
        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
        ];

        // Proses upload foto jika ada
        if ($request->hasFile('profile_picture')) {
            try {
                $manager = new ImageManager(new Driver);
                $image = $request->file('profile_picture');

                // Compress dan resize image
                $compressedImage = $manager
                    ->read($image->getPathname())
                    ->scale(width: 800)
                    ->toJpeg(75);

                $filename = 'profile_'.time().'.jpg';

                // Simpan image baru
                Storage::disk('public')->put('profile_pictures/'.$filename, (string) $compressedImage);

                // Hapus foto lama jika ada dan bukan URL eksternal
                if ($user->profile_picture && !filter_var($user->profile_picture, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                // Tambahkan profile_picture ke data update
                $updateData['profile_picture'] = 'profile_pictures/'.$filename;
                
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        // Update user
        $user->update($updateData);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}