@extends('pelanggan.layout.index')

@section('content')
    <form action="{{ route('checkout.bayar') }}" method="post">
        @csrf
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body ekspedisi">
                        <h3>Masukan Alamat Penerima</h3>
                        <div class="row mb-3">
                            <label for="nama_penerima" class="col-form-label col-md-3">Nama Penerima</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nama_penerima" name="namaPenerima"
                                    placeholder="Masukan Nama Penerima" autofocus required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat_penerima" class="col-form-label col-md-3">Alamat Penerima</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="alamat_penerima" name="alamatPenerima"
                                    placeholder="Masukan Alamat Penerima" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tlp" class="col-form-label col-md-3">No.tlp Penerima</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="tlp" name="tlp"
                                    placeholder="Masukan No tlp Penerima" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ekspedisi" class="col-form-label col-md-3">Ekspedisi</label>
                            <div class="col-md-9">
                                <select name="ekspedisi" class="form-control eksp" id="ekspedisi">
                                    <option value="">-- Pilih Ekspedisi --</option>
                                    <option value="grab">Grab Food</option>
                                    <option value="gojek">GoFood</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card">
                    <div class="card-header text-center p-4">
                        <h3>Total Belanja</h3>
                    </div>
                    <div class="card-body pembayaran">
                        <h3 class="mb-3">{{$codeTransaksi}}</h3>
                        <input type="hidden" name="code" value="{{$codeTransaksi}}">
                        <div class="row mb-3">
                            <label for="totalBelanja" class="col-form-label col-md-6">Total Belanja</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control totalBelanja" id="totalBelanja"
                                    name="totalBelanja" value="{{ $detailBelanja }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="discount" class="col-form-label col-md-6">Discount</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control discount" id="discount" name="discount" value="20%" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="PPn" class="col-form-label col-md-6">PPn</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control ppn" id="PPn" name="PPn" value="0" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ongkir" class="col-form-label col-md-6">Ongkir</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control ongkir" id="ongkir" name="ongkir" value="0" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-md-6">Total</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan" name="dibayarkan" value="0" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jumlahBarang" class="col-form-label col-md-6">Jumlah Barang</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" id="jumlahBarang" name="jumlahBarang" value="{{ $jumlahBarang }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="totalQty" class="col-form-label col-md-6">Total Quantity</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" id="totalQty" name="totalQty" value="{{ $qtyOrder }}" readonly>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-print"></i>
                            Bayar
                        </button>

                        <a href="{{ route('cancel.checkout', ['code_transaksi' => $codeTransaksi]) }}" class="btn btn-danger w-100 mt-3">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
