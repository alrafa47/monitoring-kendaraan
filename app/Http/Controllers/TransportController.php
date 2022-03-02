<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Http\Requests\StoreTransportRequest;
use App\Http\Requests\UpdateTransportRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transports = Transport::all();
        return view('transport.index', compact('transports'));
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
     * @param  \App\Http\Requests\StoreTransportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransportRequest $request)
    {
        try {
            Transport::create([
                'merk' => $request->input('merk'),
                'warna' => $request->input('warna'),
                'jadwal_service' => $request->input('jadwal_service'),
                'konsumsi_bbm' => $request->input('konsumsi_bbm'),
            ]);
            return redirect()->back()->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil ditambahkan']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function show(Transport $transport)
    {
        return view('transport.detail', compact('transport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function edit(Transport $transport)
    {
        return view('transport.edit', compact('transport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransportRequest  $request
     * @param  \App\Models\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransportRequest $request, Transport $transport)
    {
        try {
            $transport->merk = $request->input('merk');
            $transport->warna = $request->input('warna');
            $transport->jadwal_service = $request->input('jadwal_service');
            $transport->konsumsi_bbm = $request->input('konsumsi_bbm');
            $transport->save();
            return redirect()->route('transport.index')->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil diubah']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transport $transport)
    {
        try {
            transport::destroy($transport->id);
            return redirect()->route('transport.index')->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil dihapus']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal dihapus']);
        }
    }
}
