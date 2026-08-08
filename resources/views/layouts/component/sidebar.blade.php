<aside id="sidebar" class="fixed hidden md:static w-[20vw] md:w-[6vw] min-h-[100vh] flex-col md:flex z-20 items-center py-5 transition-all duration-300 bg-gray-100">
    <nav class="flex flex-col items-center justify-center flex-1 w-full gap-4 bg-gray-100">
        <div class="flex flex-col items-center gap-4 mb-0 w-full">
            <a href="{{ route('user.profiles') }}" class="w-16 h-16 rounded-full overflow-hidden border-2 border-primary transition-transform duration-200 hover:scale-110 flex items-center justify-center bg-gray-200 text-dark font-bold text-xl">
                @if (Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar_url }}" alt="Foto Profil" class="object-cover w-full h-full">
                @else
                <span>
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                @endif
            </a>
        </div>

        {{-- Meditation --}}
        <a href="{{ route('user.meditation') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat"
           style="background-image: url('{{ request()->routeIs('user.meditation') 
               ? asset('assets/icon_active/meditation.svg') 
               : asset('assets/icon/meditation.svg') }}'); background-size: 70%">
            <p class="mt-14 text-xs font-normal {{ request()->routeIs('user.meditation') ? 'text-primary' : 'text-secondary' }} tracking-wider">Meditation</p>
        </a>

        {{-- Dashboard --}}
        <a href="{{ route('user.dashboard') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat"
           style="background-image: url('{{ request()->routeIs('user.dashboard') 
               ? asset('assets/icon_active/dashboard.svg') 
               : asset('assets/icon/dashboard.svg') }}'); background-size: 70%">
            <p class="mt-14 text-xs font-normal {{ request()->routeIs('user.dashboard') ? 'text-primary' : 'text-secondary' }} tracking-wider">Menu</p>
        </a>

        {{-- Konseling / Chat --}}
        <a href="{{ route('chat.bot') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat"
           style="background-image: url('{{ request()->routeIs('chat.bot') 
               ? asset('assets/icon_active/chat.svg') 
               : asset('assets/icon/chat.svg') }}'); background-size: 90%">
            <p class="mt-14 text-xs font-normal {{ request()->routeIs('chat.bot') ? 'text-primary' : 'text-secondary' }} tracking-wider">Chat</p>
        </a>

        {{-- History --}}
        <a href="{{ route('user.history') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat"
           style="background-image: url('{{ request()->routeIs('user.history') 
               ? asset('assets/icon_active/calendar.svg') 
               : asset('assets/icon/calendar.svg') }}'); background-size: 70%">
            <p class="mt-14 text-xs font-normal {{ request()->routeIs('user.history') ? 'text-primary' : 'text-secondary' }} tracking-wider">History</p>
        </a>

        {{-- Community / Post --}}
        <a href="{{ route('user.comunity') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat"
           style="background-image: url('{{ request()->routeIs('user.comunity') 
               ? asset('assets/icon_active/comunity.svg') 
               : asset('assets/icon/comunity.svg') }}'); background-size: 70%">
            <p class="mt-14 text-xs font-normal {{ request()->routeIs('user.comunity') ? 'text-primary' : 'text-secondary' }} tracking-wider">Post</p>
        </a>

        {{-- Journal --}}
        <a href="{{ route('user.journal') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat"
           style="background-image: url('{{ request()->routeIs('user.journal') 
               ? asset('assets/icon_active/journal.svg') 
               : asset('assets/icon/journal.svg') }}'); background-size: 70%">
            <p class="mt-14 text-xs font-normal {{ request()->routeIs('user.journal') ? 'text-primary' : 'text-secondary' }} tracking-wider">Journal</p>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" 
              class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat" 
              style="background-image: url('{{ asset('assets/icon/logout.svg') }}'); background-size: 70%">
            @csrf
            <button type="submit" 
                    class="flex flex-col items-center justify-center w-12 h-12 transition-transform duration-200 hover:scale-110 bg-cover bg-center bg-no-repeat" 
                    style="background-image: url('{{ asset('assets/icon/logout.svg') }}'); background-size: 70%">
                <p class="mt-14 text-xs font-normal text-primary tracking-wider">Logout</p>
            </button>
        </form>
    </nav>
</aside>
