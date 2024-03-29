<?php

namespace App\Http\Controllers\Analytic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class RekapPerolehanSuara extends Controller
{
    public function index()
    {
        $countPemilih = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->where('user_role.role_id', 4)
            ->get();

        $countPemilihVoted = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('user_votes', 'users.id', '=', 'user_votes.user_id')
            ->where('user_role.role_id', 4)
            ->count();

            if(count($countPemilih) < 2){
                return redirect(route('dashboard'))->withErrors('Silahkan input data pemilih untuk membuka page rekap perolehan suara.');
            }

        return view('rekap_perolehan.index')->with('data', [
            'desa' => $countPemilih[1]->desa_kelurahan,
            'totalPemilih' => count($countPemilih),
            'totalVoter' => $countPemilihVoted,
            'presentase' => $countPemilihVoted / count($countPemilih) * 100
        ]);
    }
}
