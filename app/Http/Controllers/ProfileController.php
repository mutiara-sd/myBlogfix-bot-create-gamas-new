<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
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
        $user = Auth::user();

        $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', 'unique:users,username,' . $user->id],
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'telegram_id' => 'nullable|string|max:50',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'password.confirmed' => 'The password confirmation does not match.',
            'email.unique' => 'This email is already taken by another user.',
            'username.unique' => 'This username is already taken.',
            'profile_picture.max' => 'Profile picture must not exceed 2MB.',
        ]);
        
        // Data yang akan di-update
        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
        ];

        // Update email
        if ($request->filled('email')) {
            $updateData['email'] = $request->email;
        } elseif ($request->has('email') && empty($request->email)) {
            // Kalau email dikosongkan, set null
            $updateData['email'] = null;
        }

        // Update telegram_id
        if ($request->filled('telegram_id')) {
            $updateData['telegram_id'] = $request->telegram_id;
        } elseif ($request->has('telegram_id') && empty($request->telegram_id)) {
            // Kalau telegram_id dikosongkan, set null
            $updateData['telegram_id'] = null;
        }

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

                $filename = 'profile_' . time() . '.jpg';

                // Simpan image baru
                Storage::disk('public')->put('profile_pictures/' . $filename, (string) $compressedImage);

                // Hapus foto lama jika ada dan bukan URL eksternal
                if ($user->profile_picture && !filter_var($user->profile_picture, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                // Tambahkan profile_picture ke data update
                $updateData['profile_picture'] = 'profile_pictures/' . $filename;
                
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($updateData);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}