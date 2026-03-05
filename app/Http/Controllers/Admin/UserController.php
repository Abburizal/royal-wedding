<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required|in:super_admin,wedding_planner,finance,vendor,client',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'is_active' => 'boolean',
            'password'  => ['required', 'confirmed', Password::min(8)],
        ]);

        $validated['password']  = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['email_verified_at'] = now();

        $user = User::create($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'Pengguna berhasil dibuat!');
    }

    public function show(User $user)
    {
        $user->load('weddings.package');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:super_admin,wedding_planner,finance,vendor,client',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Password::min(8)]]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'Data pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        if ($user->weddings()->exists()) {
            return back()->with('error', 'Pengguna tidak bisa dihapus karena memiliki data wedding.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna dihapus.');
    }
}
