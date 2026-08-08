@extends('layouts.app')
@section('title', 'chat')

@section('content')
<div class="flex-1 flex w-full h-full p-4 md:p-2 gap-6">
    <div class="w-full md:w-1/3 bg-white border-2 border-dark rounded-playful-lg flex flex-col overflow-hidden shadow-border-offset-lg mt-4 md:mt-0 z-10">
        <div class="p-4 border-b-2 border-dark flex items-center bg-white">
            <h2 class="text-xl font-bold font-exo2">Chat</h2>
        </div>
        <div class="flex flex-col p-2 overflow-y-auto space-y-2">
            <div class="flex items-center p-3 rounded-playful-sm bg-primary border-2 border-dark shadow-border-offset">
                <div class="w-10 h-10 rounded-full bg-dark flex items-center justify-center text-white mr-3">
                    <i class="fas fa-robot text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-dark font-exo2">Nemo</h3>
                    <p class="text-xs text-dark">Temen curhat #1</p>
                </div>
            </div>
            <div class="flex items-center p-3 rounded-playful-sm bg-white border-2 border-dark shadow-border-offset cursor-pointer hover:bg-gray-100 transition-colors">
                <div class="w-10 h-10 rounded-full bg-gray-300 border-2 border-dark flex items-center justify-center text-dark mr-3">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold font-exo2">Nama Kontak</h3>
                    <div class="h-2 bg-gray-300 rounded-full w-2/3 mt-1"></div>
                </div>
            </div>
            <div class="flex items-center p-3 rounded-playful-sm bg-white border-2 border-dark shadow-border-offset cursor-pointer hover:bg-gray-100 transition-colors">
                <div class="w-10 h-10 rounded-full bg-gray-300 border-2 border-dark flex items-center justify-center text-dark mr-3">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold font-exo2">Nama Kontak</h3>
                    <div class="h-2 bg-gray-300 rounded-full w-2/3 mt-1"></div>
                </div>
            </div>
            <div class="flex items-center justify-center p-3 rounded-playful-sm bg-white border-2 border-dark shadow-border-offset cursor-pointer hover:bg-gray-100 transition-colors">
                <i class="fas fa-plus text-2xl text-gray-500"></i>
            </div>
        </div>
    </div>

    <div class="flex-1 hidden md:flex flex-col bg-white border-2 border-dark rounded-playful-lg ml-[-12px] shadow-border-offset-lg mt-4 md:mt-0 p-4 relative">
        <div class="flex-1 p-4 overflow-y-auto space-y-6 pt-16">
            <div class="flex items-end space-x-2">
                <div class="w-8 h-8 rounded-full bg-dark flex items-center justify-center text-white text-xs">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bg-gray-200 rounded-playful-sm p-3 max-w-xs text-sm border-2 border-dark shadow-border-offset">
                    Ini adalah contoh pesan dari Nemo, teman curhat Anda.
                </div>
            </div>

            <div class="flex justify-end">
                <div class="bg-primary text-white rounded-playful-sm p-3 max-w-xs text-sm border-2 border-dark shadow-border-offset">
                    Ini adalah contoh balasan dari Anda.
                </div>
            </div>
            
            <div class="flex items-end space-x-2">
                <div class="w-8 h-8 rounded-full bg-dark flex items-center justify-center text-white text-xs">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bg-gray-200 rounded-playful-sm p-3 max-w-xs text-sm border-2 border-dark shadow-border-offset">
                    Pesan yang lebih panjang untuk menunjukkan bagaimana teks akan mengalir.
                </div>
            </div>
            
            <div class="flex justify-end">
                <div class="bg-gradient-to-r from-primary to-green-400 text-white rounded-playful-sm p-3 max-w-xs text-sm border-2 border-dark shadow-border-offset">
                    Pesan ini menggunakan gradient.
                </div>
            </div>
        </div>
        
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-2 bg-white rounded-playful-sm border-2 border-dark shadow-border-offset flex items-center z-20">
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white mr-2 border-2 border-dark">
                <i class="fas fa-robot text-lg"></i>
            </div>
            <h3 class="font-bold text-base font-exo2 text-dark">Nemo</h3>
        </div>

        <div class="p-4 border-t-2 border-dark sticky bottom-0 bg-white z-10 flex items-center space-x-2">
            <input type="text" placeholder="" class="flex-1 rounded-full py-2 px-4 bg-gray-100 border-2 border-dark focus:outline-none focus:border-primary">
            <button class="bg-primary text-white p-2 rounded-full w-10 h-10 flex items-center justify-center border-2 border-dark shadow-[2px_3px_0px_#080330] hover:bg-primary-dark transition-transform duration-200 hover:scale-105">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
@endsection
