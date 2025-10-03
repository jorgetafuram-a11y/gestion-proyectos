<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show a simple admin dashboard index.
     */
    public function index(Request $request)
    {
        // Minimal implementation: show a simple text response or redirect to users list
        // This keeps the admin area routes resolvable for artisan and tests.
        return redirect()->route('admin.users.index');
    }
}
