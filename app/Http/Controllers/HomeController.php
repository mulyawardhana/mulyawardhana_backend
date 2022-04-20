<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\AkunBank;
use App\Models\Transaksi\Kas;
use DB;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $type_user = Auth::user()->type_user == 1;
        $user_id = Auth::user()->id;
        $date = Carbon::today()->addDays(30);
        // dd($date);
        if($type_user){
            $expired_posting_count = Kas::where('tanggal_dikeluarkan', '<=', $date)->where('deskripsi','pengeluaran')->count();
            // DD($expired_posting_count);
            $expired_posting = DB::table('kas')
                                ->join('klasifikasi_akuns', 'klasifikasi_akuns.id', '=', 'kas.klasifikasi_id')
                                ->join('akun_banks', 'akun_banks.id', '=', 'kas.akun_bank_id')
                                ->where('tanggal_dikeluarkan', '<=', $date)
                                ->where('deskripsi','pengeluaran')
                                ->get();
            $sisa_saldo = AkunBank::get('saldo')->sum('saldo');
            $jumlah_pengeluaran = Kas::where('deskripsi','pengeluaran')->count();
            $saldo_minimum_sum = DB::SELECT("select count(akun_banks.saldo) AS saldo_minimum_sum from akun_banks where akun_banks.saldo < akun_banks.saldo_minimum")[0];
            // dd($saldo_minimum_sum);
            $saldo_minimum = DB::SELECT("select * from akun_banks where akun_banks.saldo < akun_banks.saldo_minimum");
            return view('home',compact('sisa_saldo','saldo_minimum','saldo_minimum_sum','jumlah_pengeluaran','expired_posting','expired_posting_count'));
        }else{
            $expired_posting_count = DB::table('kas')
                                    ->join('akun_banks', 'akun_banks.id', '=', 'kas.akun_bank_id')
                                    ->join('users_akuns', 'users_akuns.akun_bank_id', '=', 'akun_banks.id')
                                    ->join('users', 'users.id', '=', 'users_akuns.user_id')
                                    ->where('tanggal_dikeluarkan', '<=', $date)->where('deskripsi','pengeluaran')
                                    ->where('users.id', '=', $user_id)
                                    ->count();
                                    // dd($expired_posting_count);
            // DD($expired_posting_count);
            $expired_posting = DB::table('kas')
            ->join('akun_banks', 'akun_banks.id', '=', 'kas.akun_bank_id')
            ->join('users_akuns', 'users_akuns.akun_bank_id', '=', 'akun_banks.id')
            ->join('users', 'users.id', '=', 'users_akuns.user_id')
            ->where('tanggal_dikeluarkan', '<=', $date)->where('deskripsi','pengeluaran')
            ->join('klasifikasi_akuns', 'klasifikasi_akuns.id', '=', 'kas.klasifikasi_id')
            ->where('users.id', '=', $user_id)
            ->get();
            // $sisa_saldo = AkunBank::get('saldo')->sum('saldo');
            $sisa_saldo = DB::select("SELECT sum(akun_banks.saldo) AS saldo FROM akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE users.id=$user_id")[0];
            // dd($sisa_saldo);
            $jumlah_pengeluaran = DB::select("SELECT
            count(kas.id) AS kas
            FROM
            kas
            INNER JOIN
            akun_banks
            ON
            kas.akun_bank_id = akun_banks.id
            INNER JOIN
            users_akuns
            ON
            akun_banks.id = users_akuns.akun_bank_id
            INNER JOIN
            users
            ON
                users_akuns.user_id = users.id
            INNER JOIN
            klasifikasi_akuns
            ON
            kas.klasifikasi_id = klasifikasi_akuns.id
            WHERE
            users.id = $user_id AND
            kas.deskripsi = 'pengeluaran'")[0];

            $saldo_minimum_sum = DB::select("select count(akun_banks.saldo) AS saldo_minimum_sum from akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE akun_banks.saldo < akun_banks.saldo_minimum AND users.id=$user_id")[0];
            $saldo_minimum = DB::select("select * from akun_banks INNER JOIN users_akuns ON akun_banks.id = users_akuns.akun_bank_id INNER JOIN users ON users_akuns.user_id = users.id WHERE akun_banks.saldo < akun_banks.saldo_minimum AND users.id = $user_id");
            return view('home',compact('sisa_saldo','saldo_minimum','saldo_minimum_sum','jumlah_pengeluaran','expired_posting','expired_posting_count'));
        }

    }
}
