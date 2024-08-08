@extends('pelanggan.layout.index')

@section('content')
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .desc {
            display: flex;
            flex-direction: column;
        }

        .desc .row {
            margin: 0;
        }

        .card-body img {
            width: 100%;
            max-width: 300px;
        }

        .row.align-items-center {
            align-items: center;
        }

        .desc .row.mb-3 {
            margin-bottom: 1rem !important;
        }

        .checkout-btn-wrapper {
            display: flex;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .card-body {
                flex-direction: row;
            }

            .card-body .desc {
                flex: 1;
            }

            .card-body img {
                width: 300px;
            }

            .delete-form {
                align-self: flex-end;
            }
        }

        @media (max-width: 767px) {
            .checkout-btn-wrapper {
                justify-content: flex-start;
            }
        }
    </style>
    <h3 class="mt-5 mb-5">Keranjang Belanja</h3>

    @php
        $totalKeseluruhan = 0;
    @endphp

    @if (!$data || $data->isEmpty())
        <p>Keranjang belanja Anda kosong.</p>
    @else
        @foreach ($data as $x)
            <div class="card mb-3">
                <div class="card-body">
                    <img src="{{ asset('assets/images/' . $x->product->foto) }}" alt="">
                    <div class="desc w-100">
                        <p style="font-size:24px; font-weight:700;">{{ $x->product->nama_product }}</p>
                        <p style="">{{ $x->product->deskripsi }}</p>
                        <input type="hidden" name="idBarang" value="{{ $x->product->id }}">
                        <input class="form-control border-0 fs-1 harga" name="harga" id="harga" value="{{ $x->product->harga }}" readonly>
                        <div class="row mb-3 align-items-center">
                            <label for="qty" class="col-sm-4 col-form-label fs-5">Quantity</label>
                            <div class="col-sm-4 d-flex align-items-center">
                                <input type="number" name="qty" class="form-control text-center qty" value="{{ $x->qty }}" min="1" data-id="{{ $x->id }}">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="price" class="col-sm-3 col-form-label fs-4">Total</label>
                            <input type="text" class="form-control border-0 fs-5 total w-50 ms-2" name="total" value="{{ intval($x->product->harga * $x->qty) }}" readonly>
                        </div>
                    </div>
                    <!-- Form Delete -->
                    <form action="{{ route('deleteFromCart', ['id' => $x->id]) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash-alt"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            @php
                $totalKeseluruhan += $x->product->harga * $x->qty;
            @endphp

        @endforeach

        <div class="row mb-3">
            <label for="totalKeseluruhan" class="col-sm-3 col-form-label fs-5">Total Keseluruhan</label>
            <input type="text" class="form-control w-50 border-0 fs-5" name="totalKeseluruhan" value="{{ intval($totalKeseluruhan) }}" readonly id="totalKeseluruhan">
        </div>

        <form action="{{ route('checkout.product') }}" method="POST" class="checkout-btn-wrapper">
            @csrf
            <div class="row w-50 gap-1">
                <button type="submit" class="btn btn-success col-sm-12 mb-2">
                    <i class="fa fa-shopping-cart"></i>
                    Checkout
                </button>
            </div>
        </form>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qtyInputs = document.querySelectorAll('.qty');
            const hargaInputs = document.querySelectorAll('.harga');
            const totalInputs = document.querySelectorAll('.total');
            const totalKeseluruhanInput = document.getElementById('totalKeseluruhan');

            function updateTotal() {
                let totalKeseluruhan = 0;
                qtyInputs.forEach((qtyInput, index) => {
                    const qty = parseInt(qtyInput.value);
                    const harga = parseFloat(hargaInputs[index].value);
                    const total = qty * harga;
                    totalInputs[index].value = parseInt(total);
                    totalKeseluruhan += parseInt(total);

                    // Kirim request AJAX untuk update qty di tabel tbl_carts
                    const id = qtyInput.dataset.id;
                    fetch(`{{ route('updateQty', ['id' => ':id']) }}`.replace(':id', id), {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ qty: qty })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Lakukan sesuatu setelah berhasil diupdate
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
                totalKeseluruhanInput.value = parseInt(totalKeseluruhan);
            }

            qtyInputs.forEach((input) => {
                input.addEventListener('change', function() {
                    if (input.value < 1) {
                        input.value = 1;
                    }
                    updateTotal();
                });
            });

            updateTotal();
        });
    </script>
@endsection
