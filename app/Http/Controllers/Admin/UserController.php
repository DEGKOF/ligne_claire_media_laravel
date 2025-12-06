<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {

        $users = User::whereIn('role', [
                'journaliste',
                'redacteur',
                'admin',
                'master_admin'])->latest()->paginate(20);



        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }
public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|email|unique:users',
        'phone' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:255',
        'password' => 'required|string|min:8|confirmed',
        'display_name' => 'nullable|string|max:255',
        'role' => 'required|in:journaliste,redacteur,admin,master_admin',
        'is_active' => 'nullable|boolean',
    ]);

    $validated['password'] = Hash::make($validated['password']);

    // Si is_active n'est pas fourni, définir par défaut à true
    $validated['is_active'] = $validated['is_active'] ?? true;

    User::create($validated);

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'phone' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:255',
        'display_name' => 'nullable|string|max:255',
        'role' => 'required|in:journaliste,redacteur,admin,master_admin',
        'is_active' => 'nullable|boolean',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    if (!empty($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
}

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
