<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\Http\Request;

class TransaksiAdminController extends Controller
{
    public function index()
    {
        $data = transaksi::with(['detailTransaksi.product'])->paginate(10);
        return view('admin.page.transaksi', ['title' => "Transaksi", 'name' => 'Transaksi', 'data' => $data]);
    }

    public function destroy($id)
    {
        $transaksi = transaksi::find($id);

        if ($transaksi) {
        
            $transaksi->delete();
            
        }

        return redirect()->route('transaksi.admin')->with('success', 'Transaksi berhasil dihapus');
    }

}


