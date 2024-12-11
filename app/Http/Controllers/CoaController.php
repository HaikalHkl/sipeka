<?php

namespace App\Http\Controllers;

use App\Models\Coa; //load model dari kelas model coa
use App\Http\Requests\StoreCoaRequest;
use App\Http\Requests\UpdateCoaRequest;

use Illuminate\Support\Facades\Validator;
// https://www.fundaofwebit.com/post/laravel-8-ajax-crud-with-example

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function tabel(){
        // $coa = Coa::all();
        $coa = Coa::where('header_akun', '1')
                    ->get();
        // Menggunakan klausa where untuk mencari produk berdasarkan nama
        return view('coa.view_tabel',
                     [
                        'coa'=>$coa,
                        'title'=>'contoh m2',
                        'nama'=>'Farel Prayoga'
                     ]   
                    );
    }

    public function index()
    {
        // // mengambil data coa dan perusahaan dari database
    	$coa = Coa::getCoaDetailPerusahaan();
   
        return view('coa/view',
            [
                'coa' => $coa,
               
            ]
        );


        // // akses data dari obyek coa
        // $coa = Coa::all();
        // Menggunakan klausa where untuk mencari produk berdasarkan nama
        // $coa = Coa::where('header_akun', '1')
        //             ->where('nama_akun', 'Kas')
        //             ->get();
        // // var_dump($coa);
        // // dd;
        // return view('coa.view',
        //              [
        //                 'coa'=>$coa,
        //                 'title'=>'contoh m2',
        //                 'nama'=>'Farel Prayoga'
        //              ]   
        //             );
    }

    // handle fetch all coas ajax request
	public function fetchAll() {
		// $coas = Coa::all();
        $coas = Coa::getCoaDetailPerusahaan();
		$output = '';
		if (count($coas) > 0) {
			$output .= '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th style="text-align: center">Header</th>
                <th>Saldo</th>
                <th style="text-align: center">Aksi</th>
              </tr>
            </thead>
            <tfoot class="thead-dark">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th style="text-align: center">Header</th>
                    <th>Perusahaan</th>
                    <th style="text-align: center">Aksi</th>
                </tr>
            </tfoot>
            <tbody>';
			foreach ($coas as $coa) {
				$output .= '<tr>
                <td>' . $coa->kode_akun . '</td>
                <td>' . $coa->nama_akun .'</td>
                <td>' . $coa->header_akun . '</td>
                <td>' . $coa->saldo . '</td>
                <td style="text-align: center">
                    <a href="#" onclick="updateConfirm(this); return false;" class="btn btn-success btn-icon-split btn-sm editbtn" value="'.$coa->id.'" data-id="'.$coa->id.'" ><span class="icon text-white-50"><i class="ti ti-pencil"></i></span></a>
                    <a href="#" onclick="deleteConfirm(this); return false;" href="#" value="'.$coa->id.'" data-id="'.$coa->id.'" class="btn btn-danger btn-icon-split btn-sm deletebtn"><span class="icon text-white-50"><i class="ti ti-trash"></i></span>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}


    // fetch data coa ke dalam format json
    public function fetchcoa()
    {
        $coa = Coa::getCoaDetailPerusahaan();
        return response()->json([
            'coas'=>$coa,
        ]);
    }

    // untuk API view data
    public function view($id)
    {
        $coa = Coa::findOrFail($id);
        echo json_encode($coa);    
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
     * @param  \App\Http\Requests\StoreCoaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoaRequest $request)
    {
        // Validasi data input
        $request->validate([
            'kode_akun' => 'required',
            'nama_akun' => 'required',
            'header_akun' => 'required',
            'saldo' => 'required'
        ]);
        $duplicate = Coa::where('kode_akun', $request->input('kode_akun'))->exists();

        if ($duplicate) {
            // Jika kode akun sudah ada, redirect kembali dengan pesan error
            $notification = array(
                'message' => 'Kode akun sudah ada!',
                'alert-type' => 'error'
            );
            return redirect()->route('coa.index')->with($notification);
        }
 
        // Membuat data coa baru
        $coa = new Coa();
        $coa->kode_akun = $request->input('kode_akun');
        $coa->nama_akun = $request->input('nama_akun');
        $coa->header_akun = $request->input('header_akun');
        $coa->saldo = $request->input('saldo');
        $coa->save();
 
        // Menampilkan notifikasi sukses
        $notification = array(
            'message' => 'Data coa berhasil ditambahkan!',
            'alert-type' => 'success'
        );
 
        // Redirect ke halaman coa dengan pesan sukses
        return redirect()->route('coa.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function show(Coa $coa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    // public function edit(Coa $coa)
    public function edit($id)
    {
        $coa = Coa::find($id);
        if($coa)
        {
            return response()->json([
                'status'=>200,
                'coa'=> $coa,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCoaRequest  $request
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoaRequest $request, Coa $coa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Coa $coa)
    public function destroy($id)
    {
        //hapus dari database
        $coa = Coa::findOrFail($id);
        $coa->delete();
        
        // mengambil data coa dan perusahaan dari database
    	$coa = Coa::all();

        return view('coa/view',
            [
                'coa' => $coa,

                'status_hapus' => 'Sukses Hapus'
            ]
        );
    }
}
