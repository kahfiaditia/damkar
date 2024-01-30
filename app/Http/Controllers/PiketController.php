<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\AnggotaModel;
use App\Models\PiketModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PiketController extends Controller
{
    protected $title = 'Kelompok Piket';
    protected $menu = 'Piket';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'label' => 'Kelompok Piket',
            'regu' => PiketModel::all(),
        ];

        return view('piket.index')->with($data);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'label' => 'Data Piket',
           
        ];

        return view('piket.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->kode);
        $validated = $request->validate([
            'kode' => 'required',
                      
        ]);

        DB::beginTransaction();
        try {
            $piket = new PiketModel();
            $piket->kode = $request->kode;
            $piket->deskripsi = $request->deskripsi;
            $piket->status = 1;
            $piket->user_created = Auth::user()->id;
            $piket->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('/piket');
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembinaModel  $pembinaModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembinaModel  $pembinaModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'label' => 'Data Regu Piket',
            'data' => PiketModel::findOrfail($id),
        ];

        return view('piket.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembinaModel  $pembinaModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => 'required',
         ]);

        DB::beginTransaction();
        try {

            $status = $request->has('status') ? 1 : 2;

            $update = PiketModel::findOrFail($id);
            $update->kode = $request->kode;
            $update->deskripsi = $request->deskripsi;
            $update->status = $status;
            $update->user_updated = Auth::user()->id;
            $update->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('/piket');
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembinaModel  $pembinaModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                  
            DB::beginTransaction();
            try {
                $delete = PiketModel::findorfail($id);
                $delete->user_deleted = Auth::user()->id;
                $delete->deleted_at = Carbon::now();
                $delete->save();

                DB::commit();
                AlertHelper::deleteAlert(true);
                return back();
            } catch (\Throwable $err) {
                DB::rollBack();
                AlertHelper::deleteAlert(false);
                return back();
            }
        
    }
}
