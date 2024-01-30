<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\AnggotaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AnggotaController extends Controller
{
    protected $title = 'Anggota';
    protected $menu = 'Anggota';
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
            'label' => 'Data Anggota',
        ];

        return view('anggota.index')->with($data);
    }

    public function list_data_anggota(Request $request)
    {
        $userdata = AnggotaModel::select(
            'piket.id',
            'piket.kode',
            'table_anggota.nama',
            'table_anggota.jabatan',
            'table_anggota.piket'
        )
            ->join('piket', 'table_anggota.piket', '=', 'piket.id')
            ->whereNull('table_anggota.deleted_at');

        

        if ($request->get('search_manual') != null) {
            $search = $request->get('search_manual');
            // $search_rak = str_replace(' ', '', $search);
            $userdata->where(function ($where) use ($search) {
                $where
                    ->orWhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('piket', 'like', '%' . $search . '%');
                
            });

            $search = $request->get('search');
            // $search_rak = str_replace(' ', '', $search);
            if ($search != null) {
                $userdata->where(function ($where) use ($search) {
                    $where
                        ->orWhere('nama', 'like', '%' . $search . '%')
                        ->orWhere('jabatan', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%')
                        ->orWhere('piket', 'like', '%' . $search . '%');
                   
                });
            }
        } else {
            if ($request->get('nama') != null) {
                $nama = $request->get('nama');
                $userdata->where('nama', '=', $nama);
            }
            if ($request->get('jabatan') != null) {
                $jabatan = $request->get('jabatan');
                $userdata->where('jabatan', '=', $jabatan);
            }
            if ($request->get('status') != null) {
                $status = $request->get('status');
                $userdata->where('status', '=', $status);
            }
            if ($request->get('piket') != null) {
                $piket = $request->get('piket');
                $userdata->where('piket', '=', $piket);
            }
        }

        return DataTables::of($userdata)
            ->addColumn('action', 'pembina.a')
            ->rawColumns(['action'])
            ->make(true);
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
            'label' => 'Input Anggota',
        ];

        return view('anggota.tambah')->with($data);
    }

    public function get_grup_data()
    {
        $piket = DB::table('piket')
            ->whereNull('deleted_at')
            ->where('status', '=', "1")
            ->get();

        if (count($piket) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $piket,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $inputanggota = new AnggotaModel();
            $inputanggota->nama = $request->nama;
            $inputanggota->jabatan = $request->jabatan;
            $inputanggota->piket = $request->piket_id;
            $inputanggota->status = 1;
            $inputanggota->user_created =  Auth::user()->id;
            
            $inputanggota->save();

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Input Data',
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Input Data',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
