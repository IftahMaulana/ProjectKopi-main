@extends('pelanggan.layout.index')

@section('content')
    <div class="row mt-4 align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="content-text">
                Kami di Coffee NekoNeko selalu siap mendengar dari Anda! Apakah Anda ingin tahu lebih banyak tentang menu kami, memiliki pertanyaan khusus, atau hanya ingin berbagi pengalaman Anda dengan kami, jangan ragu untuk menghubungi. Tim kami yang ramah siap membantu Anda dengan sepenuh hati. Kunjungi kami di kedai, hubungi kami melalui telepon, atau kirimkan pesan melalui email. Setiap masukan dari Anda sangat berarti bagi kami untuk terus menyajikan yang terbaik. Let's stay connected over a perfect cup of coffee!
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="Coffee NekoNeko Logo">
        </div>
    </div>

    <h4 class="text-center mt-md-5 mb-md-2"></h4>
    <hr class="mb-5">
    <div class="row mb-md-5">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card h-100">
                <div class="card-header text-center">
                    <h4>Lokasi Kami</h4>
                </div>
                <div class="card-body">
                    <div class="embed-responsive embed-responsive-16by9 h-100">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.067093833488!2d106.7971986!3d-6.3853425999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e94bb6d486c1%3A0x412111910d6ea17f!2sJl.%20Matoa%20II%2C%20Mampang%2C%20Kec.%20Pancoran%20Mas%2C%20Kota%20Depok%2C%20Jawa%20Barat%2016433!5e0!3m2!1sid!2sid!4v1721719907238!5m2!1sid!2sid" frameborder="0" style="border:0; width:100%; height:500px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
