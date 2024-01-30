<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\HariModel;
use App\Models\jadwalPiketModel;
use App\Models\PiketModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JadwalPiketController extends Controller
{
    protected $title = 'Jadwal Piket';
    protected $menu = 'Jadwal';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $userdata = JadwalPiketModel::select(
                'piket.id',
                'piket.kode',
                'table_hari.nama_hari',
                'users.name',
                'table_jadwal_piket.id_piket',
                'table_jadwal_piket.status'
            )
            ->join('table_hari', 'table_jadwal_piket.id_hari', '=', 'table_hari.id')
            ->join('piket', 'table_jadwal_piket.id_piket', '=', 'piket.id')
            ->join('users', 'table_jadwal_piket.id_kelompok', '=', 'users.id')
            ->whereNull('table_jadwal_piket.deleted_at')
            ->get();
            

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'label' => $this->menu,
            'jadwal' => $userdata
        ];

        
        return view('jadwal_piket.data')->with($data);
    }

    public function data_list_jadwal(Request $request)
    {

        $userdata = DB::table('table_jadwal_hari AS jh')
            ->select('jh.id', 'ek.name AS nama_kegiatan', 'h.nama_hari AS nama_hari', 'u.name AS name', 'jh.jam_mulai', 'jh.jam_selesai')
            ->join('ekstrakurikuler AS ek', 'jh.id_kegiatan', '=', 'ek.id')
            ->join('table_hari AS h', 'jh.id_hari', '=', 'h.id')
            ->join('users AS u', 'jh.id_pembina', '=', 'u.id')
            ->whereNull('jh.deleted_at');
        // ->get();


        if ($request->get('search_manual') != null) {
            $search = $request->get('search_manual');
            // $search_rak = str_replace(' ', '', $search);
            $userdata->where(function ($where) use ($search) {
                $where
                    ->orWhere('nama_kegiatan', 'like', '%' . $search . '%')
                    ->orWhere('nama_hari', 'like', '%' . $search . '%')
                    ->orWhere('jam_mulai', 'like', '%' . $search . '%')
                    ->orWhere('jam_selesai', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });

            $search = $request->get('search');
            // $search_rak = str_replace(' ', '', $search);
            if ($search != null) {
                $userdata->where(function ($where) use ($search) {
                    $where
                        ->orWhere('nama_kegiatan', 'like', '%' . $search . '%')
                        ->orWhere('nama_hari', 'like', '%' . $search . '%')
                        ->orWhere('jam_mulai', 'like', '%' . $search . '%')
                        ->orWhere('jam_selesai', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%');
                });
            }
        } else {
            if ($request->get('ketua_name') != null) {
                $ketua_name = $request->get('ketua_name');
                $userdata->where('ketua_name', '=', $ketua_name);
            }
            if ($request->get('wakil_name') != null) {
                $wakil_name = $request->get('wakil_name');
                $userdata->where('wakil_name', '=', $wakil_name);
            }
            if ($request->get('no_urut') != null) {
                $no_urut = $request->get('no_urut');
                $userdata->where('no_urut', '=', $no_urut);
            }
            if ($request->get('periode_name') != null) {
                $periode_name = $request->get('periode_name');
                $userdata->where('periode_name', '=', $periode_name);
            }
            if ($request->get('quote') != null) {
                $quote = $request->get('quote');
                $userdata->where('quote', '=', $quote);
            }
            if ($request->get('visi_misi') != null) {
                $visi_misi = $request->get('visi_misi');
                $userdata->where('visi_misi', '=', $visi_misi);
            }
        }

        return DataTables::of($userdata)
            ->addColumn('action', 'jadwal.buttonjadwal')
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
            'label' => $this->menu,
            'piket' => PiketModel::whereNull('deleted_at')->get(),
            'ketua' => User::where('roles', 'Kelompok')->get(),

        ];
        return view('jadwal_piket.tambah')->with($data);
    }

    public function ketua_kelompok()
    {
        $kelompok = DB::table('users')
            ->whereNull('deleted_at')
            ->where('roles', '=', "Kelompok")
            ->get();

        if (count($kelompok) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $kelompok,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    public function cari_hari()
    {
        $hariList = HariModel::all();
        return response()->json(['data' => $hariList]);
    }

    public function getHari()
    {
        $hariList = HariModel::all();
        return response()->json(['data' => $hariList]);
    }

    public function simpan_data_piket(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            $datajadwal = $request->input('datajadwal');

            // Simpan data jadwal ke database
            foreach ($datajadwal as $data) {
                jadwalPiketModel::create([
                    'id_kelompok' => $data['kelompok'],
                    'id_piket' => $data['piket'],
                    'id_hari' => $data['nilaiSelect'],
                    'status' => 1,
                    'jam_mulai' => $data['jam_mulai'],
                    'jam_selesai' => $data['jam_selesai'],
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


    public function edit($id)
    {
        $dataedit = DB::table('table_jadwal_hari')
            ->select('table_jadwal_hari.*', 'users.name as nama_pembina', 'ekstrakurikuler.name as nama_kegiatan', 'table_hari.nama_hari')
            ->join('users', 'table_jadwal_hari.id_pembina', '=', 'users.id')
            ->join('ekstrakurikuler', 'table_jadwal_hari.id_kegiatan', '=', 'ekstrakurikuler.id')
            ->join('table_hari', 'table_jadwal_hari.id_hari', '=', 'table_hari.id')
            ->where('table_jadwal_hari.id', $id)
            ->first();

        // dd($dataedit);

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'data' => 'Edit Jadwal',
            'jadwal' => $dataedit,
            'nama_harinya' => HariModel::all(),
        ];
        return view('jadwal_piket.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalKegiatanModel  $JadwalKegiatanModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        DB::beginTransaction();
        try {
            // dd($request->hari);

            $jadwal = PiketModel::findOrFail($id);
            $jadwal->id_pembina = $request->pembina;
            $jadwal->id_kegiatan = $request->kegiatan;
            $jadwal->id_hari = $request->hari;
            $jadwal->jam_mulai = $request->mulai;
            $jadwal->jam_selesai = $request->selesai;
            $jadwal->status = $request->status1;
            $jadwal->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('/jadwal_piket');
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
     * @param  \App\Models\JadwalExtraModel  $jadwalExtraModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $hapus = PiketModel::findorfail($id);
            $hapus->user_deleted = Auth::user()->id;
            $hapus->deleted_at = Carbon::now();
            $hapus->save();

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
