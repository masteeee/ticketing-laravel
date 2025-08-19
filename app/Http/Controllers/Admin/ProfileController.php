<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan profil admin
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }

    // Form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    // Update profil admin
    public function update(Request $request)
        {
            $user = Auth::user();

            $request->validate([
                'name'      => 'required|string|max:255',
                'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
                'password'  => 'nullable|min:6|confirmed',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;

            // Jika upload foto baru
            if ($request->hasFile('profile_photo')) {
                // Hapus foto lama kalau ada
                if ($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo))) {
                    unlink(public_path('storage/' . $user->profile_photo));
                }

                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->profile_photo = $path;
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
        }

}
