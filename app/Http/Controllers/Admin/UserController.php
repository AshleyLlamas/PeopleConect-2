<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::paginate()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {

        $user = User::with("image")->findOrFail($user->id);

        $posicion = DB::selectOne("
            SELECT numero_consecutivo
            FROM (
                SELECT id,
                    ROW_NUMBER() OVER (PARTITION BY puesto ORDER BY id) AS numero_consecutivo
                FROM users
                WHERE puesto = 'ASESOR DE VENTAS'
            ) AS subquery
            WHERE id = ?
        ", [$user->id]);

        if ($posicion) {
            $user->numero_asesor_de_ventas =  $posicion->numero_consecutivo;
        } else {
            $user->numero_asesor_de_ventas = "-";
        }

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
