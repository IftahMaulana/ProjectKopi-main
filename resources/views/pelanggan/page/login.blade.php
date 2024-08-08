<!DOCTYPE html>
<html lang="en">
    <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="http://127.0.0.1:8000/css/custome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key=""></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <title>NekoNeko | Home</title>

    </head>

<body>

<!-- Modal -->
<div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block;" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
                <button type="button" class="btn-close" aria-label="Close" id="close-button"></button>
                
            </div>
            <div class="modal-body">
                <form action="{{ route('loginproses.pelanggan') }}" method="POST">
                    @csrf                    
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" value="" placeholder="Masukan email Anda">
                        </div>
                    </div>
                    <div class="mb-5 row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password anda">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success col-sm-12 mb-2">Login</button>
                    <a href="{{ route('halaman.register') }}" class="btn btn-primary col-sm-12 mb-2">Register</a>

                    <p class="m-auto text-center p-2" style="font-size:12px">Jika belum ada akun register sekarang .. !
                    </p>
                </form>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>
<script src="http://127.0.0.1:8000/js/custom.js"></script>


<iframe src="https://app.sandbox.midtrans.com/snap/v4/popup?origin_host=http://127.0.0.1:8000#/" id="snap-midtrans" style="display: none;" name="popup_1720697858327"></iframe><iframe src="https://app.sandbox.midtrans.com/snap/v4/popup?origin_host=http://127.0.0.1:8000#/" id="snap-midtrans" style="display: none;" name="popup_1720697858375"></iframe><div class="modal-backdrop fade show"></div><div class="modal-backdrop fade show"></div>

    <script>
        document.getElementById('close-button').addEventListener('click', function() {
            window.location.href = '{{ url("/") }}'; 
        });
    </script>



</body></html>