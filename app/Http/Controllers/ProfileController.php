<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Story;
use App\Models\AdminMessage;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('auth.profil', compact('user'));
    }

    public function update(Request $request) {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        if ($request->hasFile('photo')) {
            
            $file = $request->file('photo');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('storage/photos'), $fileName);

            if ($user->photo && file_exists(public_path('storage/' . $user->photo))) {
                unlink(public_path('storage/' . $user->photo));
            }

            $user->photo = 'photos/' . $fileName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function deletePhoto() {
        $user = Auth::user();
        if ($user->photo) {
            Storage::delete('public/' . $user->photo);
            $user->photo = null;
            $user->save();
        }
        return back()->with('success', 'Foto profil dihapus.');
    }

    public function destroy(Request $request) {
        $user = Auth::user();
        
        Auth::logout();
        
        if ($user->photo) {
            Storage::delete('public/' . $user->photo);
        }
        
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Akun Anda telah dihapus.');
    }

    public function inbox()
    {
        $messages = AdminMessage::where('user_id', Auth::id())->latest()->get();
        
        AdminMessage::where('user_id', Auth::id())->update(['is_read' => true]);

        return view('user.inbox', compact('messages'));
    }
}