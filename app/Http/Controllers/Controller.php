<?php

namespace App\Http\Controllers;

use App\Models\modelDetailTransaksi;
use App\Models\product;
use App\Models\tblCart;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function shop(Request $request)
    {
        
        if ($request->has('kategory') && $request->has('type')) {
            $category = $request->input('kategory');
            $type = $request->input('type');
            $data = product::where('kategory', $category)
                ->orWhere('type', $type)->paginate(5);
        } else {
            $data = product::paginate(5);
        }
        $countKeranjang = tblCart::where(['idUser' => 'guest123', 'status' => 0])->count();


        return view('pelanggan.page.shop', [
            'title'     => 'Shop',
            'data'      => $data,
            'count'     => $countKeranjang,
        ]);
    }
    public function transaksi()
    {
        $userId = Auth::guard('user')->id(); // Ambil ID pengguna yang sedang login        

        $db = tblCart::with('product')->where(['idUser' => $userId, 'status' => 0])->get();
        $countKeranjang = tblCart::where(['idUser' => $userId, 'status' => 0])->count();
        $countPayment = transaksi::where('user_id', $userId)->count();

        // dd($db->product->nama_product);die;
        return view('pelanggan.page.transaksi', [
            'title'     => 'Transaksi',
            'countCart'     => $countKeranjang,
            'countPayment'  => $countPayment,
            'data'      => $db
        ]);
    }
    public function contact()
    {
        $userId = Auth::guard('user')->id(); // Ambil ID pengguna yang sedang login
        $countKeranjang = tblCart::where(['idUser' => $userId, 'status' => 0])->count();
        $countPayment = transaksi::where('user_id', $userId)->count();

        return view('pelanggan.page.contact', [
            'title'     => 'Contact Us',
            'countCart'     => $countKeranjang,
            'countPayment' => $countPayment
        ]);
    }
    public function checkout()
    {
        $userId = Auth::guard('user')->id();
        $countKeranjang = tblCart::where(['idUser' => $userId, 'status' => 0])->count();
        $countPayment = transaksi::where('user_id', $userId)->count();
        
         
        $code = tblCart::count();
        $codeTransaksi = date('Ymd') . $code + 1;
        $detailBelanja = modelDetailTransaksi::where(['code_transaksi' => $codeTransaksi,'status' => 0])
        ->sum('price');
        $jumlahBarang = modelDetailTransaksi::where(['code_transaksi' => $codeTransaksi,'status' => 0])
        ->count('id_barang');
        $totalQty = modelDetailTransaksi::where(['code_transaksi' => $codeTransaksi,'status' => 0])
        ->sum('qty');



        return view('pelanggan.page.checkOut', [
            'title' => 'Check Out',
            'countCart' => $countKeranjang,
            'countPayment' => $countPayment,
            'detailBelanja' => $detailBelanja,
            'jumlahBarang' => $jumlahBarang,
            'qtyOrder' => $totalQty,
            'codeTransaksi' => $codeTransaksi
        ]);
    }
    
    public function prosesCheckout(Request $request)
    {

        $cartItems = tblCart::where('status', 0)->get();

        if ($cartItems->isEmpty()) {
            Alert::toast('Keranjang Anda kosong.', 'warning');
            return redirect()->route('home');
        }

        $code = tblCart::count();
        $codeTransaksi = date('Ymd') . $code + 1;

        

        foreach ($cartItems as $item) {
            
            $detailTransaksi = new modelDetailTransaksi();
            $detailTransaksi->code_transaksi = $codeTransaksi;
            $detailTransaksi->id_barang = $item->id_barang;
            $detailTransaksi->qty = $item->qty;
            $detailTransaksi->price = $item->price;
            $detailTransaksi->save();

            $item->code_transaksi = $codeTransaksi;
            $item->save();
    
        }
    
    
        Alert::toast('Checkout Berhasil', 'success');
        return redirect()->route('checkout');
    }

    // cancel checkout
    public function cancelCheckout(Request $request)
    {
        $code_transaksi = $request->query('code_transaksi');
        $detailTransaksi = modelDetailTransaksi::where('code_transaksi', $code_transaksi)->get();
        foreach ($detailTransaksi as $item) {
            $item->delete();
        }
        return redirect()->route('transaksi');
    }

  

    public function updateQty(Request $request, $id)
    {
        $qty = $request->input('qty');
        $cartItem = tblCart::findOrFail($id);
        $cartItem->qty = $qty;

        // Perhitungan harga baru berdasarkan qty yang diubah
        $product = Product::findOrFail($cartItem->id_barang);
        $cartItem->price = $product->harga * $qty;

        $cartItem->save();

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
    }



    public function prosesPembayaran(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        
        

        $dbTransaksi = new transaksi();
        // dd($data);die

        $dbTransaksi->code_transaksi      = $data['code'];
        $dbTransaksi->user_id           = $user->id;
        $dbTransaksi->total_qty         = $data['totalQty'];
        $dbTransaksi->total_harga       = $data['dibayarkan'];
        $dbTransaksi->nama_customer     = $data['namaPenerima'];
        $dbTransaksi->alamat            = $data['alamatPenerima'];
        $dbTransaksi->no_tlp            = $data['tlp'];
        $dbTransaksi->ekspedisi         = $data['ekspedisi'];

        $dbTransaksi->save();
        DB::beginTransaction();
        try {
            $cartItems = modelDetailTransaksi::where('code_transaksi', $data['code'])->get();
            foreach ($cartItems as $item) {
                // Menyimpan detail transaksi
                $dataUp = modelDetailTransaksi::where('id', $item->id)->first();
                $dataUp->status    = 1;
                $dataUp->save();

                // Mengurangi stok produk
                $product = product::where('id', $item->id_barang)->first();
                $product->quantity = $product->quantity - $item->qty;
                $product->quantity_out = $item->qty;
                $product->save();

            }

            $cartItems = tblCart::where('status', 0)->where('code_transaksi', $data['code'])->get();
            foreach ($cartItems as $item) {
                $item->status = 1;
                $item->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError($e->getMessage());
        }
        

        
        return redirect()->route('keranjang.bayar', ['id' => $dbTransaksi->id]);
    }



    public function bayar($id)
{
    $userId = Auth::guard('user')->id(); // Ambil ID pengguna yang sedang login
    $find_data = transaksi::find($id);

   
    
    $countKeranjang = tblCart::where(['idUser' => $userId, 'status' => 0])->count();
    $countPayment = transaksi::where('user_id', $userId)->count();
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $unique_order_id = $find_data->code_transaksi . '_' . time();

    $params = array(
        'transaction_details' => array(
            'order_id' => $unique_order_id,
            'gross_amount' => $find_data->total_harga,
        ),
        'customer_details' => array(
            'first_name' => 'Mr',
            'last_name' => $find_data->nama_customer,
            'phone' => $find_data->no_tlp,
        ),
    );

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('pelanggan.page.detailTransaksi', [
            'name' => 'Detail Transaksi',
            'title' => 'Detail Transaksi',
            'countCart' => $countKeranjang,
            'countPayment' => $countPayment,
            'token' => $snapToken,
            'data' => $find_data,
        ]);
    } catch (Exception $e) {
        return back()->withError($e->getMessage());
    }
}

    public function admin()
    {
        $dataProduct = product::count();
        $dataStock = product::sum('quantity');
        $dataTransaksi = transaksi::count();
        $dataPenghasilan = transaksi::sum('total_harga');

        // Mengelompokkan transaksi berdasarkan bulan dalam tahun berjalan
        $monthlyTransaksi = transaksi::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('count', 'month')
        ->toArray();

        // Memastikan data untuk semua bulan (1-12) ada
        $monthlyTransaksiData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyTransaksiData[] = $monthlyTransaksi[$i] ?? 0;
        }

        // Mengambil data produk
        $limitedStockProducts = product::where('quantity', '<', 5)
        ->orderBy('quantity', 'asc')
        ->get();
        $topProducts = product::where('quantity_out', '>=', 5)
        ->orderBy('quantity_out', 'desc')
        ->get();


        return view('admin.page.dashboard', [
            'name'          => "Dashboard",
            'title'         => 'Admin Dashboard',
            'totalProduct'  => $dataProduct,
            'sumStock'      => $dataStock,
            'dataTransaksi' => $dataTransaksi,
            'dataPenghasilan' => $dataPenghasilan,
            'monthlyTransaksi'  => $monthlyTransaksiData,
            'limitedStockProducts' => $limitedStockProducts, 
            'topProducts'   => $topProducts, // Data produk terlaris

        ]);
    }

    public function userManagement()
    {
        return view('admin.page.user', [
            'name'      => "User Management",
            'title'     => 'Admin User Management',
        ]);
    }
    public function report()
    {
        return view('admin.page.report', [
            'name'      => "Report",
            'title'     => 'Admin Report',
        ]);
    }
    public function login()
    {
        return view('admin.page.login', [
            'name'      => "Login",
            'title'     => 'Admin Login',
        ]);
    }

    public function loginpelanggan()
    {
        return view('pelanggan.page.login');
    }


    public function loginProses(Request $request)
    {
        Session::flash('error', $request->email);
    
        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        // dd($dataLogin);
    
        $user = new User;
        $proses = $user::where('email', $request->email)->first();
    
        if ($proses === null) {
            Session::flash('error', 'Pengguna tidak ditemukan');
            return back();
        }
        // dd($proses->is_admin);
    
        if ($proses->is_admin === 0) {
            Session::flash('error', 'Kamu bukan admin');
            return back();
        } else {
            if (Auth::attempt($dataLogin)) {
                Alert::toast('Kamu berhasil login', 'success');
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                Alert::toast('Email dan Password salah', 'error');
                return back();
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('admin');
    }}