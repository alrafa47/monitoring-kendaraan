<?php

namespace App\Http\Controllers;

use App\Models\tahun_ajaran;
use App\Http\Requests\Storetahun_ajaranRequest;
use App\Http\Requests\Updatetahun_ajaranRequest;
use Exception;
use Illuminate\Database\QueryException;
use PhpParser\Node\Stmt\TryCatch;

use function PHPUnit\Framework\returnValue;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunajaran=tahun_ajaran::all();
        return view('tahun_ajaran.index',[
            'data'=>$tahunajaran
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
     * @param  \App\Http\Requests\Storetahun_ajaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storetahun_ajaranRequest $request)
    {
        $tahun_ajaran=$request->input('Tahun_Ajaran');
        $status=$request->input('Status');
        try {
            if ($status == 'aktif') {
                tahun_ajaran::where('status', 'aktif')
                ->update(['status' => 'tidakaktif']);
            }
             tahun_ajaran::create([
                'tahun_ajaran' => $tahun_ajaran,
                'status' => $status 
            ]);
            return redirect()->back()->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil ditambahkan']);
        } catch (QueryException $th) {
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' =>'data gagal ditambahkan']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tahun_ajaran  $tahun_ajaran
     * @return \Illuminate\Http\Response
     */
    public function show(tahun_ajaran $tahun_ajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tahun_ajaran  $tahun_ajaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tahunAjaran=tahun_ajaran::findOrFail($id);
        return view('tahun_ajaran.edit',[
            'tahun_ajaran'=>$tahunAjaran
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatetahun_ajaranRequest  $request
     * @param  \App\Models\tahun_ajaran  $tahun_ajaran
     * @return \Illuminate\Http\Response
     */
    public function update(Updatetahun_ajaranRequest $request, $id)
    {
        $status = $request->input('Status');
        try {
            if ($status == 'aktif') {
                tahun_ajaran::where('status', 'aktif')
                ->update(['status' => 'tidakaktif']);
            }
            $tahunAjaran = tahun_ajaran::findOrFail($id);
            $tahunAjaran->tahun_ajaran = $request->input('Tahun_Ajaran');
            $tahunAjaran->status = $status;
            $tahunAjaran->save();
            return redirect()->route('tahunajaran')->with('pesan', (object)['status' => 'success', 'message' =>'data berhasil diubah']);
        } catch (QueryException $th) {
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' =>'data gagal diubah']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tahun_ajaran  $tahun_ajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            tahun_ajaran::destroy($id);
            return redirect()->route('tahunajaran')->with('pesan', (object)['status' => 'success', 'message' =>'data berhasil dihapus']);
        } catch (QueryException $th) {
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' =>'data gagal dihapus']);
        }
    }
}
