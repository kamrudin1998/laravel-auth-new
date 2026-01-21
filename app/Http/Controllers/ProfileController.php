<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (WITH PHOTO)
     * 
     * ✅ OPTIMIZED: 
     * - Wrapped in transaction for data integrity
     * - Proper error handling for file operations
     * - Only deletes old photo if new upload succeeds
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = $request->user();
            $oldPhotoPath = $user->profile_photo;

            // ✅ Update name & email
            $user->fill($request->validated());

            // 📸 PROFILE PHOTO UPLOAD with error handling
            if ($request->hasFile('profile_photo')) {
                try {
                    // Store new photo first
                    $newPath = $request->file('profile_photo')
                        ->store('profile_photos', 'public');

                    // Update user with new path
                    $user->profile_photo = $newPath;

                    // Email verification reset if email changed
                    if ($user->isDirty('email')) {
                        $user->email_verified_at = null;
                    }

                    // Save user first
                    $user->save();

                    // Only delete old photo if everything succeeded
                    if ($oldPhotoPath) {
                        Storage::disk('public')->delete($oldPhotoPath);
                    }

                } catch (\Exception $e) {
                    DB::rollBack();
                    // Delete newly uploaded file if something went wrong
                    if (isset($newPath)) {
                        Storage::disk('public')->delete($newPath);
                    }
                    throw $e;
                }
            } else {
                // Email verification reset if email changed
                if ($user->isDirty('email')) {
                    $user->email_verified_at = null;
                }
                $user->save();
            }

            DB::commit();

            return Redirect::route('profile.edit')
                ->with('status', 'profile-updated');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::route('profile.edit')
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Delete the user's account.
     * 
     * ✅ OPTIMIZED: 
     * - Wrapped in transaction
     * - Proper error handling
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();

            // Delete profile photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Delete user from database
            $user->delete();

            // Logout and invalidate session
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            DB::commit();

            return Redirect::to('/');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()
                ->with('error', 'Failed to delete account. Please try again.');
        }
    }
}
