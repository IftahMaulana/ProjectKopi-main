@extends('admin.layout.index')

@section('content')
    <div class="card rounded-full p-2">
        <input type="text" wire:model="search" class="form-control w-25" placeholder="Search....">
        <div class="card-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Id Transaksi</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Nilai Trx</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $x => $item)
                        <tr class="align-middle">
                            <td>{{ ++$x }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->code_transaksi }}</td>

                            <td>
                                @foreach ($item->detailTransaksi as $detail)
                                    {{ $detail->product->nama_product }} <br>
                                @endforeach
                            </td>

                            <td class="text-center">
                                @foreach ($item->detailTransaksi as $detail)
                                {{ $detail->qty }}<br>
                                @endforeach
                            </td>

                            <td>{{ $item->nama_customer }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->total_harga }}</td>
                            
                            <td>
                                <span
                                    class="align-middle {{ $item->status === 'Paid' ? 'badge bg-success text-white' : 'badge bg-danger text-white' }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('transaksi.hapus', ['id' => $item->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>

                           

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination d-flex flex-row justify-content-between">
                <div class="showData">
                    Data ditampilkan {{ $data->count() }} dari {{ $data->total() }}
                </div>
                <div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
