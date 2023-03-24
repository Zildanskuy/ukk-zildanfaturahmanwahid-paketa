<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(request $request, Pengaduan $model)
    {
        $url = $request->fullUrl();
        $status = $request->status;

        if ($request->status && $request->status != 'all') {
            $model = $model->where('status', $request->status);
        }
        $items = $model->get();

        $pending = Pengaduan::where('status', 'Belum di Proses')->count();

        $process = Pengaduan::where('status', 'Sedang di Proses')->count();

        $success = Pengaduan::where('status', 'Selesai')->count();

        if ($request->pdf == true) {
            return $this->pdf($items);
        }


        return view('pages.admin.dashboard',[
            'url' => $url,
            'items' => $items,
            'pending' => $pending,
            'process' => $process,
            'success' => $success
        ]);


        // return view('pages.admin.dashboard',[
        //     'pengaduan' => Pengaduan::count(),
        //     'user' => User::where('roles','=', 'USER')->count(),
        //     'petugas' => User::where('roles', '=', 'PETUGAS')->count(),
        //     'admin' => User::where('roles', '=', 'ADMIN')->count(),
        //     'tanggapan' => Tanggapan::count(),
        //     'pending' => Pengaduan::where('status', 'Belum di Proses')->count(),
        //     'process' => Pengaduan::where('status', 'Sedang di Proses')->count(),
        //     'success' => Pengaduan::where('status', 'Selesai')->count(),
        // ]);
    }
}
