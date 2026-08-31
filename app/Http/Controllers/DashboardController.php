<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusTiket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $akun = Auth::user();

        $akun->load([
            'pegawai',
            'level',
        ]);

        $namaLevel = $akun->level->nama_level;

        if (in_array($namaLevel, [
            'Super Admin',
            'Admin IT',
            'Manager IT',
        ])) {

            /*
    |--------------------------------------------------------------------------
    | STATISTIK TIKET
    |--------------------------------------------------------------------------
    */

            $totalTiket = Tiket::count();


            $tiketBaru = Tiket::whereHas(
                'statusTiket',
                function ($query) {

                    $query->whereRaw(
                        'UPPER(nama_status) = ?',
                        ['MENUNGGU']
                    );
                }
            )->count();


            $tiketDitugaskan = Tiket::whereHas(
                'statusTiket',
                function ($query) {

                    $query->whereRaw(
                        'UPPER(nama_status) = ?',
                        ['DITUGASKAN']
                    );
                }
            )->count();


            $tiketDiproses = Tiket::whereHas(
                'statusTiket',
                function ($query) {

                    $query->whereRaw(
                        'UPPER(nama_status) = ?',
                        ['DIPROSES']
                    );
                }
            )->count();


            $tiketPending = Tiket::whereHas(
                'statusTiket',
                function ($query) {

                    $query->whereRaw(
                        'UPPER(nama_status) = ?',
                        ['PENDING']
                    );
                }
            )->count();


            $tiketSelesai = Tiket::whereHas(
                'statusTiket',
                function ($query) {

                    $query->whereIn(
                        'nama_status',
                        [
                            'SELESAI',
                            'DITUTUP',
                        ]
                    );
                }
            )->count();


            $tiketMenungguApproval = Tiket::whereHas(
                'statusTiket',
                function ($query) {

                    $query->whereRaw(
                        'UPPER(nama_status) = ?',
                        ['MENUNGGU APPROVAL']
                    );
                }
            )->count();


            /*
    |--------------------------------------------------------------------------
    | TIKET TERBARU
    |--------------------------------------------------------------------------
    */

            $tiketTerbaru = Tiket::with([
                'statusTiket',
                'pelapor',
                'teknisi',
                'prioritasTiket',
            ])
                ->latest()
                ->take(10)
                ->get();


            /*
    |--------------------------------------------------------------------------
    | GRAFIK STATUS TIKET
    |--------------------------------------------------------------------------
    */

            $statusTiketChart = Tiket::join(
                'status_tiket',
                'tiket.status_tiket_id',
                '=',
                'status_tiket.id'
            )
                ->select(
                    'status_tiket.nama_status',
                    DB::raw('COUNT(tiket.id) as total')
                )
                ->groupBy(
                    'status_tiket.id',
                    'status_tiket.nama_status'
                )
                ->orderBy(
                    'status_tiket.id'
                )
                ->get();


            /*
    |--------------------------------------------------------------------------
    | GRAFIK TIKET PER BULAN
    |--------------------------------------------------------------------------
    */

            $tiketPerBulanQuery = Tiket::select(

                DB::raw(
                    'MONTH(created_at) as bulan'
                ),

                DB::raw(
                    'COUNT(*) as total'
                )

            )
                ->whereYear(
                    'created_at',
                    now()->year
                )
                ->groupBy(
                    DB::raw('MONTH(created_at)')
                )
                ->orderBy(
                    DB::raw('MONTH(created_at)')
                )
                ->get();


            /*
    |--------------------------------------------------------------------------
    | FORMAT DATA 12 BULAN
    |--------------------------------------------------------------------------
    */

            $namaBulan = [

                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des',

            ];


            $dataPerBulan = [];


            for ($bulan = 1; $bulan <= 12; $bulan++) {

                $dataBulan = $tiketPerBulanQuery
                    ->firstWhere(
                        'bulan',
                        $bulan
                    );


                $dataPerBulan[] = $dataBulan
                    ? (int) $dataBulan->total
                    : 0;
            }


            /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */

            return view(
                'admin.dashboard',
                compact(

                    'akun',

                    'totalTiket',

                    'tiketBaru',

                    'tiketDitugaskan',

                    'tiketDiproses',

                    'tiketPending',

                    'tiketSelesai',

                    'tiketMenungguApproval',

                    'tiketTerbaru',

                    'statusTiketChart',

                    'namaBulan',

                    'dataPerBulan'

                )
            );
        }
        if ($namaLevel === 'Teknisi') {

            $pegawai = $akun->pegawai;

            $totalTiket = Tiket::where('teknisi_id', $pegawai->id)
                ->count();

            $tiketDitugaskan = Tiket::where('teknisi_id', $pegawai->id)
                ->whereHas('statusTiket', function ($query) {
                    $query->where('nama_status', 'DITUGASKAN');
                })
                ->count();

            $tiketDiproses = Tiket::where('teknisi_id', $pegawai->id)
                ->whereHas('statusTiket', function ($query) {
                    $query->where('nama_status', 'DIPROSES');
                })
                ->count();

            $tiketSelesai = Tiket::where('teknisi_id', $pegawai->id)
                ->whereHas('statusTiket', function ($query) {
                    $query->where('nama_status', 'SELESAI');
                })
                ->count();

            $tiketTerbaru = Tiket::with([
                'statusTiket',
                'pelapor',
                'prioritasTiket',
            ])
                ->where('teknisi_id', $pegawai->id)
                ->latest()
                ->take(5)
                ->get();

            return view('teknisi.dashboard', compact(
                'akun',
                'pegawai',
                'totalTiket',
                'tiketDitugaskan',
                'tiketDiproses',
                'tiketSelesai',
                'tiketTerbaru'
            ));
        }

        if ($namaLevel === 'Pegawai') {

            $pegawai = $akun->pegawai;

            $totalTiket = Tiket::where('pelapor_id', $pegawai->id)
                ->count();

            $menunggu = Tiket::where('pelapor_id', $pegawai->id)
                ->whereHas('statusTiket', function ($query) {
                    $query->where('nama_status', 'Menunggu');
                })
                ->count();

            $diproses = Tiket::where('pelapor_id', $pegawai->id)
                ->whereHas('statusTiket', function ($query) {
                    $query->where('nama_status', 'Diproses');
                })
                ->count();

            $selesai = Tiket::where('pelapor_id', $pegawai->id)
                ->whereHas('statusTiket', function ($query) {
                    $query->where('nama_status', 'Selesai');
                })
                ->count();

            $tiketTerbaru = Tiket::with('statusTiket')
                ->where('pelapor_id', $pegawai->id)
                ->latest()
                ->take(5)
                ->get();

            return view('pegawai.dashboard', compact(
                'akun',
                'pegawai',
                'totalTiket',
                'menunggu',
                'diproses',
                'selesai',
                'tiketTerbaru'
            ));
        }

        abort(403, 'Level akun tidak dikenali.');
    }
}
