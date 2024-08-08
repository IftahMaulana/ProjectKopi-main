<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Http\Requests\StoretransaksiRequest;
use App\Http\Requests\UpdatetransaksiRequest;
use App\Models\product;
use App\Models\tblCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth; 

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::guard('user')->id(); // Ambil ID pengguna yang sedang login
        $best = product::where('quantity_out','>=',5)->get();
        $data = product::paginate(15);
        $countKeranjang = tblCart::where(['idUser' => $userId, 'status' => 0])->count();
        $countPayment = transaksi::where('user_id', $userId)->count();
        return view('pelanggan.page.home', [
            'title'     => 'Home',
            'data'      => $data,
            'best'      => $best,
            'countCart'     => $countKeranjang,
            'countPayment'  => $countPayment,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addTocart(Request $request)
    {
        $idProduct = $request->input('idProduct');
        $userId = Auth::guard('user')->id(); // Ambil ID pengguna yang sedang login

        $db = new tblCart ;
        $product = product::find($idProduct);
        $field = [
            'idUser'    => $userId,
            'id_barang' => $idProduct,
            'qty'       => 1,
            'price'     => $product->harga,
        ];

        $db::create($field);
        return redirect('/');
    }

    public function deleteFromCart($id)
{
    // Temukan item keranjang berdasarkan ID dan hapus
    $cartItem = tblCart::find($id);

    if ($cartItem) {
        $cartItem->delete();
    }

    // Redirect kembali ke halaman keranjang dengan pesan sukses
    return redirect()->route('transaksi')->with('success', 'Item berhasil dihapus dari keranjang.');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretransaksiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetransaksiRequest $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        try {
            $transaction = Transaksi::where('code_transaksi', $request->code_transaksi)->first();
            if ($transaction) {
                $transaction->status = $request->status;
                $transaction->save();
                
                return response()->json(['success' => true]);
            }
            
            return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
