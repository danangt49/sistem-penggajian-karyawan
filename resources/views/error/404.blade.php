@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <section class="content">
                    <div class="error-page">
                        <h2 class="headline text-warning"> 404</h2>
                        <div class="error-content">
                            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Halaman Tidak Diketahui.</h3>
                            <p>
                                Kami tidak dapat menemukan halaman yang Anda cari.
                                Sementara itu, Anda dapat <a href="{{ url('/') }}">kembali ke Home</a> atau mencoba menggunakan
                                formulir pencarian.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop
