<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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


        return view('pages.admin.pengaduan.index',[
            'url' => $url,
            'items' => $items,
            'pending' => $pending,
            'process' => $process,
            'success' => $success
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Pengaduan::with([
            'details', 'user'
        ])->findOrFail($id);

        $tangap = Tanggapan::where('pengaduan_id',$id)->first();

        return view('pages.admin.pengaduan.detail',[
            'item' => $item,
            'tangap' => $tangap
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        // $status->update($data);
        return redirect('admin/pengaduans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::find($id);
        $pengaduan->delete();

        Alert::success('Berhasil', 'Pengaduan telah di hapus');
        return redirect('admin/pengaduans');
    }

    public function pdf($datas){
        $pdf = PDF::loadview('pages.admin.pengaduan.alldata',['datas'=>$datas])->setpaper('a4', 'landscape');
        $name = 'petugas-laporan-pengaduan-'.Str::random(5);
    	return $pdf->download($name.'.pdf');
    }
}
