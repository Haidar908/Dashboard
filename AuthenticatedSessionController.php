<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Simpan input tambahan ke session
        session([
            'target_jam_running' => $request->input('target_jam_running'),
            'no_mesin' => $request->input('no_mesin'),
            'nama_mesin' => $request->input('nama_mesin'),
            'part_mesin' => $request->input('part_mesin'),
            'shift' => $request->input('shift'),
        ]);

        // Ambil usertype dan atur default jika kosong
        $usertype = Auth::user()->usertype ?? 'user';

        switch ($usertype) {
            case 'admin':
                return redirect(route('admin.dashboard'));
            case 'super_admin':
                return redirect(route('superadmin.dashboard'));
            case 'user':
                return redirect(route('dashboard'));
            default:
                Auth::logout();
                return redirect(route('login'))->with('error', 'Unauthorized access');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->flush(); // Hapus semua session

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logoutAndRedirect()
    {
        Auth::logout(); // Logout user
        request()->session()->invalidate(); // Hapus sesi
        request()->session()->regenerateToken(); // Regenerasi token

        return redirect()->route('combo'); // Redirect ke halaman combo
    }

}
