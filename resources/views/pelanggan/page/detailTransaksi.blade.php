@extends('pelanggan.layout.index')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <div class="container mt-5">
        <div class="card" style="max-width: 600px;">
            <div class="card-header text-center">
                <h4>Total yang harus dibayar</h4>
            </div>
            <div class="card-body">
                <h6><strong>Id Transaksi:</strong> {{ $data->code_transaksi }}</h6>
                <h6><strong>Nama Penerima:</strong> {{ $data->nama_customer }}</h6>
                <h6><strong>Total Harga:</strong> {{ number_format($data->total_harga, 0, ',', '.') }}</h6>
            </div>

            <div class="p-2 text-center">
                <button class="btn btn-success" id="pay-button">Bayar Sekarang</button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Trigger snap popup on button click
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{$token}}', {
                onSuccess: function(result) {
                    alert("Payment successful!");
                    console.log(result);
                    updateTransactionStatus(result.order_id, 'paid');
                },
                onPending: function(result) {
                    alert("Waiting for payment!");
                    console.log(result);
                },
                onError: function(result) {
                    alert("Payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    alert('You closed the popup without finishing the payment');
                }
            });
        });

        function updateTransactionStatus(orderId, status) {
            // split order id by _ and take the first part as transaction id
            var orderIdParts = orderId.split('_');
            var code_transaksi = orderIdParts[0];
            fetch('/update-transaction-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        code_transaksi: code_transaksi,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("data", data);
                    if (data.success) {
                        alert('Transaction status updated successfully');
                        window.location.href = '/';
                    } else {
                        alert('Failed to update transaction status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
