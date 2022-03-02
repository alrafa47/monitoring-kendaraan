<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(5);
        return view('employee.index', compact('employees'));
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
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            Employee::create([
                'nama' => $request->input('nama'),
                'telp' => $request->input('telp'),
                'alamat' => $request->input('alamat'),
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
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employee.detail', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $employee->nama = $request->input('nama');
            $employee->telp = $request->input('telp');
            $employee->alamat = $request->input('alamat');
            $employee->save();
            return redirect()->route('employee.index')->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil diubah']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            Employee::destroy($employee->id);
            return redirect()->route('employee.index')->with('pesan', (object)['status' => 'success', 'message' => 'data berhasil dihapus']);
        } catch (QueryException $th) {
            Log::error("error " . __CLASS__ . "->" . __FUNCTION__ . "-" .  " error code : " . $th->errorInfo[0]);
            return redirect()->back()->with('pesan', (object)['status' => 'danger', 'message' => 'data gagal dihapus']);
        }
    }
}
