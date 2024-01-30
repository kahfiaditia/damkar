<?php

namespace App\Http\Controllers;

use App\Models\AbsensiPiketModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsenPiketController extends Controller
{
    protected $title = 'Absensi Piket';
    protected $menu = 'Absensi Piket';
    protected $label = 'Absensi Piket';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::now()->format('N'); // 'N' mengembalikan nomor hari (1 = Senin, 2 = Selasa, dst.)

        $list = DB::table('table_jadwal_piket')
            ->select(
                'table_jadwal_piket.*',
                'table_hari.nama_hari',
                'users.name as ketua_kelompok',
                'users.id as id_user',
                'piket.kode',
                'piket.id'
            )
            ->join('table_hari', 'table_jadwal_piket.id_hari', '=', 'table_hari.id')
            ->leftJoin('users', 'table_jadwal_piket.id_kelompok', '=', 'users.id')
            ->leftJoin('piket', 'table_jadwal_piket.id_piket', '=', 'piket.id')
            ->whereNull('table_jadwal_piket.deleted_at')
            ->where('table_hari.kode', '=', $today)
            ->get();

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'kegiatan' => 'Absensi',
            'list' => $list,
        ];
        return view('absensi_piket.list_jadwal')->with($data);
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

        // dd($request->ketua_kelompok_id);
        DB::beginTransaction();
        try {

            $datajadwal = $request->input('dataToSend');

            // Simpan data jadwal ke database
            foreach ($datajadwal as $data) {
                AbsensiPiketModel::create([
                    'id_kelompok' => $request->ketua_kelompok_id,
                    'id_anggota' => $data['id_anggota'],
                    'id_piket' => $request->grup_piket_id,
                    'id_hari' => $request->id_hari,
                    'status' =>  $data['status_piket'],
                    'keterangan' => $data['keterangan'],
                    'user_created' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            }

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
        $today = Carbon::now()->format('N'); // 'N' mengembalikan nomor hari (1 = Senin, 2 = Selasa, dst.)

        $list = DB::table('table_jadwal_piket')
            ->select(
                'table_jadwal_piket.*',
                'table_hari.nama_hari',
                'users.name as ketua_kelompok',
                'users.id as id_ketua',
                'piket.kode as kode'
            )
            ->join('table_hari', 'table_jadwal_piket.id_hari', '=', 'table_hari.id')
            ->leftJoin('users', 'table_jadwal_piket.id_kelompok', '=', 'users.id')
            ->leftJoin('piket', 'table_jadwal_piket.id_piket', '=', 'piket.id')
            ->whereNull('table_jadwal_piket.deleted_at')
            ->where('table_hari.kode', '=', $today)
            ->where('table_jadwal_piket.id_piket', '=', $id)
            ->first();

        // dd($list);

        $userdata = DB::table('table_anggota')
        ->join('users', 'table_anggota.piket', '=', 'users.id')
        ->join('piket', 'table_anggota.piket', '=', 'piket.id')
        ->select('users.id as id_user', 'users.nis', 'users.name', 'table_anggota.nama', 'table_anggota.jabatan','table_anggota.id', 'table_anggota.piket as grup_piket')
        ->where('table_anggota.piket', '=', $id)
        ->get();

        $count = $userdata->count();

            // dd($userdata);


        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'label' => $this->label,
            'kegiatan' => 'Ekstrakulikuler',
            'absensinya' => $userdata,
            'data_kegiatan' => $id,
            'absen_kegiatan' =>  $list,
            'jumlah_anggota' =>  $count,

        ];
        return view('absensi_piket.input_absen_piket')->with($data);
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
