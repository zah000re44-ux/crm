<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
            'role' => ['required','in:admin,agent'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'تم إضافة المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        // فقط الأدمن
        abort_unless(auth()->user()->role === 'admin', 403);

        // منع حذف نفسك
        if ($user->id === auth()->id()) {
            return back()->with('status', 'لا يمكنك حذف حسابك وأنت مسجل دخول');
        }

        // منع حذف آخر Admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('status', 'لا يمكن حذف آخر مسؤول (Admin)');
        }

        $user->delete();

        return back()->with('status', 'تم حذف المستخدم بنجاح');
    }
}
