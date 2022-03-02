<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Employee;
use App\Models\Transport;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

use function PHPUnit\Framework\throwException;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Employee::all();
        $transports = Transport::where('status', true)->get();
        $rentals = Rental::with(['transport', 'employee'])->paginate(5);
        return view('rental.index', compact('rentals', 'drivers', 'transports'));
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
     * @param  \App\Http\Requests\StoreRentalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRentalRequest $request)
    {
        try {
            Rental::create([
                'employee_id' => $request->input('driver'),
                'transport_id' => $request->input('transport')
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
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $rental)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function edit(Rental $rental)
    {
        return view('rental.edit', compact('rental'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRentalRequest  $request
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRentalRequest $request, Rental $rental)
    {
        try {
            $rental->employee_id = $request->input('driver');
            $rental->transport_id = $request->input('transport');
            $rental->save();
            return redirect()->route('rental.index')->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil diubah']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rental $rental)
    {
        try {
            Rental::destroy($rental->id);
            return redirect()->route('rental.index')->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil dihapus']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal dihapus']);
        }
    }

    public function acc(Rental $rental)
    {
        switch (Auth::user()->role) {
            case 'kabag_umum':
                $rental->acc_divisi_umum = now();
                break;
            case 'kabag_pegawai':
                $rental->acc_divisi_kepegawaian = now();
                break;
            default:
                return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'tidak dapat melakukan Acc']);
                break;
        }
        if (!is_null($rental->acc_divisi_umum) && !is_null($rental->acc_divisi_kepegawaian)) {
            $rental->tgl_keluar = now();
            $transport = $rental->transport;
            $transport->status = false;
            $transport->save();
        }
        $rental->save();

        return redirect()->back()->with('pesan', (object)['status' => 'success', 'message' => 'tidak dapat melakukan Acc']);
    }

    public function kembali(Rental $rental)
    {
        try {
            $rental->tgl_kembali = now();
            $rental->save();
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal dihapus']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal dihapus']);
        }
    }
}
