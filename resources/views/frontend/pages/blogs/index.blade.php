@extends('frontend.layouts.pages.master-sidebar')
@section('page_title', 'Blog - MitraCom')
@section('meta_title', 'Blog Mitra Com: Info Terkini Pengadaan Barang & Regulasi TKDN')
@section('meta_description', 'Jelajahi berbagai artikel menarik seputar dunia peralatan kantor, kebersihan, kesehatan, dan furniture. Dapatkan tips, panduan, dan informasi terbaru untuk kebutuhan Anda.')
@section('meta_keywords', 'blog, artikel, tips, panduan, peralatan kantor, kebersihan, kesehatan, furniture, informasi terbaru')

@section('content')
    <div class="space-y-6">

        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-sky-500 to-blue-500 text-white p-6 rounded-2xl shadow">
            <h1 class="text-2xl font-bold mb-2">Dashboard</h1>
            <p class="text-sm opacity-90">Ringkasan aktivitas dan informasi penting hari ini.</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Total Pengunjung</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">1,245</h2>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Total Post</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">87</h2>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Komentar</p>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">326</h2>
            </div>
        </div>

        <!-- Activity -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Aktivitas Terbaru</h2>
            <ul class="space-y-3">
                <li class="text-sm text-slate-600">User baru mendaftar</li>
                <li class="text-sm text-slate-600">Post baru ditambahkan</li>
                <li class="text-sm text-slate-600">Komentar baru masuk</li>
            </ul>
        </div>

        <!-- Simple Form -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Kirim Pesan</h2>
            <form class="space-y-4">
                <input type="text" placeholder="Nama"
                    class="w-full border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-sky-400 outline-none">
                
                <input type="email" placeholder="Email"
                    class="w-full border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-sky-400 outline-none">
                
                <textarea placeholder="Pesan"
                    class="w-full border border-slate-200 rounded-lg p-3 h-24 focus:ring-2 focus:ring-sky-400 outline-none"></textarea>
                
                <button type="submit"
                    class="px-5 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                    Kirim
                </button>
            </form>
        </div>

    </div>
@endsection
