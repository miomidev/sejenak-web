@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('style')
<style>
    @keyframes frame-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes frame-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }

    .avatar-frame-wrap {
        position: relative;
        display: inline-block;
        border-radius: 9999px;
        transition: all 0.3s ease;
    }

    /* Clean Solid Discord-Style Animated Frames */
    .frame-rainbow {
        padding: 5px;
        background: conic-gradient(from 0deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bf7, #7a00ff, #ff00c8, #ff0000);
        animation: frame-spin 5s linear infinite;
    }
    .frame-neon {
        padding: 5px;
        background: #00f2fe;
        animation: frame-pulse 2s ease-in-out infinite;
        box-shadow: 0 0 10px rgba(0, 242, 254, 0.4);
    }
    .frame-gold {
        padding: 5px;
        background: #fcf6ba;
        border: 2px solid #080330;
        animation: frame-pulse 2.5s ease-in-out infinite;
    }
    .frame-cyber {
        padding: 5px;
        background: #8FD14F;
        border: 2px dashed #080330;
        animation: frame-spin 8s linear infinite;
    }
    .frame-zen {
        padding: 5px;
        background: #52B788;
        animation: frame-pulse 2.5s ease-in-out infinite;
    }
    .frame-fire {
        padding: 5px;
        background: #ff4e50;
        animation: frame-pulse 1.8s ease-in-out infinite;
    }
    .frame-default {
        padding: 4px;
        background: #080330;
    }

    .badge-pill {
        @apply inline-flex items-center gap-1.5 px-3 py-1 rounded-full border-2 border-dark text-xs font-extrabold shadow-[2px_2px_0_#080330] transition-all cursor-pointer;
    }
</style>
@endsection

@section('content')
@php
    $badges = [
        'mindful' => ['name' => 'Mindful Master', 'emoji' => '🧘', 'bg' => 'bg-emerald-100 text-emerald-900'],
        'early' => ['name' => 'Early Pioneer', 'emoji' => '🌟', 'bg' => 'bg-amber-100 text-amber-900'],
        'journal' => ['name' => 'Journal Specialist', 'emoji' => '✍️', 'bg' => 'bg-blue-100 text-blue-900'],
        'streak' => ['name' => 'Streak Warrior', 'emoji' => '🔥', 'bg' => 'bg-orange-100 text-orange-900'],
        'helper' => ['name' => 'Community Helper', 'emoji' => '💖', 'bg' => 'bg-pink-100 text-pink-900'],
        'vip' => ['name' => 'VIP Zen Member', 'emoji' => '👑', 'bg' => 'bg-purple-100 text-purple-900'],
    ];

    $currentBadgeKey = Auth::user()->profile_badge ?? 'mindful';
    $currentBadge = $badges[$currentBadgeKey] ?? $badges['mindful'];
    $currentFrame = Auth::user()->avatar_frame ?? 'default';

    $avatarUrl = Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/icon/nav-profile.svg');
@endphp

<div class="flex flex-col md:flex-row items-start justify-start p-4 md:p-6 w-full h-full gap-6 overflow-y-auto max-w-7xl mx-auto font-main">
    
    <!-- Kolom Kiri: Card Profile Card & Avatar Frame -->
    <div class="w-full md:w-1/3 flex flex-col gap-6">
        <div class="h-auto flex flex-col items-center justify-start p-6 bg-white rounded-playful-lg border-2 border-dark shadow-border-offset relative overflow-hidden">
            <!-- Solid Clean Top Banner -->
            <div class="w-full h-16 bg-primary border-b-2 border-dark absolute top-0 left-0"></div>

            <!-- Avatar Wrapper with Animated Frame -->
            <div class="mt-6 mb-3 relative group cursor-pointer" onclick="openCustomizationModal()">
                <div id="avatar-frame-container" class="avatar-frame-wrap frame-{{ $currentFrame }}">
                    <div class="w-28 h-28 md:w-36 md:h-36 rounded-full overflow-hidden border-2 border-dark bg-white">
                        <img id="profile-avatar-img" src="{{ $avatarUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 bg-primary text-dark text-xs p-1.5 rounded-full border-2 border-dark shadow-[2px_2px_0_#080330] group-hover:scale-110 transition-transform">
                    ✨
                </div>
            </div>

            <!-- Nama User + Active Profile Badge -->
            <div class="flex items-center justify-center gap-2 mb-1 flex-wrap">
                <h4 class="text-xl md:text-2xl font-extrabold text-dark text-center">{{ Auth::user()->name }}</h4>
                <span id="active-badge-display" class="badge-pill {{ $currentBadge['bg'] }}">
                    <span>{{ $currentBadge['emoji'] }}</span> {{ $currentBadge['name'] }}
                </span>
            </div>

            <p class="text-xs md:text-sm text-gray-500 font-bold text-center">{{ Auth::user()->email }}</p>
            <span class="px-3 py-0.5 rounded-full bg-purple-100 text-purple-900 border-2 border-dark text-xs font-extrabold mt-1 mb-4 uppercase shadow-[2px_2px_0_#080330]">
                🛡️ {{ Auth::user()->role->name ?? 'Pengguna' }}
            </span>

            <div class="w-full text-center bg-gray-50 p-3 rounded-playful-md border-2 border-dark shadow-[2px_2px_0_#080330]">
                <h5 class="text-xs font-extrabold text-dark/70 uppercase mb-1">Bio Refleksi</h5>
                <p class="text-sm text-gray-700 italic">"{{ Auth::user()->bio ?? 'Belum ada bio pribadi.' }}"</p>
            </div>

            <!-- Tombol Kustomisasi Frame & Badge -->
            <button onclick="openCustomizationModal()" class="w-full mt-4 py-2.5 bg-primary hover:bg-primary/90 text-dark font-extrabold text-sm rounded-playful-md border-2 border-dark shadow-[3px_3px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <span>🎨</span> Kustomisasi Frame & Badge
            </button>
        </div>

        <div class="bg-white p-5 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <div class="flex items-center justify-between">
                <h5 class="text-sm md:text-base font-extrabold text-dark">Status Langganan</h5>
                <i class="fas fa-crown text-amber-500 text-lg"></i>
            </div>
            <p class="text-xs text-gray-600 font-semibold mt-2 leading-relaxed">
                Anda adalah anggota <strong class="text-dark font-extrabold">Sejenak Gratitude</strong>. 
                <a href="#" class="text-primary underline font-extrabold hover:text-dark">Tingkatkan VIP</a> untuk membuka frame & badge eksklusif.
            </p>
        </div>
    </div>

    <!-- Kolom Tengah: Statistik & Customization Panel -->
    <div class="w-full md:w-1/3 flex flex-col gap-6">
        <div class="bg-white p-5 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="text-lg font-extrabold text-dark mb-4 pb-2 border-b-2 border-dark flex items-center justify-between">
                <span>📊 Statistik Saya</span>
                <i class="fas fa-chart-line text-primary"></i>
            </h3>
            <div class="flex flex-col gap-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-dark font-extrabold text-sm"><i class="fas fa-coins text-amber-500 mr-2"></i> Saldo Token</span>
                    <span class="font-extrabold text-dark text-base">{{ number_format(Auth::user()->tokens_balance) }}</span>
                </div>

                <a href="{{ route('user.token') }}" class="w-full px-4 py-2 bg-secondary hover:bg-secondary/80 text-dark font-extrabold text-center text-xs rounded-playful-sm border-2 border-dark shadow-[2px_2px_0_#080330] transition-all block">
                    <i class="fas fa-cart-plus mr-1.5"></i> Beli Token Refleksi
                </a>

                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-dark font-extrabold text-sm"><i class="fas fa-book-open text-emerald-500 mr-2"></i> Jumlah Jurnal</span>
                    <span class="font-extrabold text-dark text-base">{{ Auth::user()->journals()->count() }}</span>
                </div>

                <div class="flex justify-between items-center py-2">
                    <span class="text-dark font-extrabold text-sm"><i class="fas fa-comments text-blue-500 mr-2"></i> Post Komunitas</span>
                    <span class="font-extrabold text-dark text-base">{{ Auth::user()->posts()->count() }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="text-lg font-extrabold text-dark mb-4 pb-2 border-b-2 border-dark flex items-center justify-between">
                <span>🎖️ Badge & Frame Aktif</span>
                <i class="fas fa-award text-secondary"></i>
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 border-2 border-dark rounded-playful-sm shadow-[2px_2px_0_#080330]">
                    <span class="text-xs font-extrabold text-dark uppercase">Frame Discord Style:</span>
                    <span id="active-frame-label" class="px-2.5 py-1 bg-primary border border-dark rounded-full text-xs font-extrabold text-dark capitalize">
                        {{ $currentFrame }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 border-2 border-dark rounded-playful-sm shadow-[2px_2px_0_#080330]">
                    <span class="text-xs font-extrabold text-dark uppercase">Badge Profil:</span>
                    <span id="active-badge-label" class="badge-pill {{ $currentBadge['bg'] }}">
                        {{ $currentBadge['emoji'] }} {{ $currentBadge['name'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Pengaturan & Akses Cepat -->
    <div class="w-full md:w-1/3 flex flex-col gap-6">
        <div class="bg-white p-5 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="text-lg font-extrabold text-dark mb-4 pb-2 border-b-2 border-dark flex items-center justify-between">
                <span>⚙️ Pengaturan Akun</span>
                <i class="fas fa-cog text-gray-500"></i>
            </h3>
            <div class="flex flex-col gap-3">
                <a href="{{ route('user.profiles.edit', Auth::user()->name) }}" class="w-full px-4 py-2 bg-primary hover:bg-primary/90 text-dark font-extrabold text-xs text-center rounded-playful-sm border-2 border-dark shadow-[2px_2px_0_#080330] transition-all">
                    <i class="fas fa-edit mr-2"></i> Edit Informasi Profil
                </a>
                <a href="#" class="w-full px-4 py-2 bg-white hover:bg-gray-100 text-dark font-extrabold text-xs text-center rounded-playful-sm border-2 border-dark shadow-[2px_2px_0_#080330] transition-all">
                    <i class="fas fa-key mr-2 text-gray-500"></i> Ubah Kata Sandi
                </a>
            </div>
        </div>

        <div class="bg-white p-5 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="text-lg font-extrabold text-dark mb-4 pb-2 border-b-2 border-dark flex items-center justify-between">
                <span>🚀 Akses Cepat</span>
                <i class="fas fa-rocket text-primary"></i>
            </h3>
            <div class="flex flex-col gap-3">
                @if(Auth::check() && in_array(Auth::user()->role->name ?? '', ['super_admin', 'admin']))
                <a href="{{ route('admin.dashboard') }}" class="w-full px-4 py-2 bg-secondary hover:bg-secondary/90 text-dark font-extrabold text-xs text-center rounded-playful-sm border-2 border-dark shadow-[2px_2px_0_#080330] transition-all">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin
                </a>
                @endif
                <a href="{{ route('user.meditation') }}" class="w-full px-4 py-2 bg-emerald-300 hover:bg-emerald-400 text-dark font-extrabold text-xs text-center rounded-playful-sm border-2 border-dark shadow-[2px_2px_0_#080330] transition-all">
                    <i class="fas fa-spa mr-2"></i> Ruang Meditasi
                </a>
                <a href="{{ route('user.journal') }}" class="w-full px-4 py-2 bg-blue-300 hover:bg-blue-400 text-dark font-extrabold text-xs text-center rounded-playful-sm border-2 border-dark shadow-[2px_2px_0_#080330] transition-all">
                    <i class="fas fa-book mr-2"></i> Tulis Jurnal
                </a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KUSTOMISASI AVATAR FRAME & BADGE (DISCORD STYLE) -->
<div id="customization-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white border-3 border-dark rounded-playful-lg shadow-[8px_8px_0_#080330] w-full max-w-xl overflow-hidden relative">
        <div class="flex justify-between items-center p-5 bg-primary border-b-3 border-dark">
            <h3 class="text-lg font-extrabold text-dark flex items-center gap-2">
                <span>🎨</span> Kustomisasi Frame & Badge Profile
            </h3>
            <button onclick="closeCustomizationModal()" class="w-8 h-8 rounded-full bg-white hover:bg-red-100 text-dark font-bold border-2 border-dark flex items-center justify-center shadow-[2px_2px_0_#080330]">
                ✕
            </button>
        </div>

        <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
            <!-- Live Preview Card -->
            <div class="bg-gray-50 border-2 border-dark rounded-playful-md p-4 text-center shadow-[3px_3px_0_#080330]">
                <p class="text-xs font-extrabold text-dark/70 uppercase mb-3">Live Preview Tampilan Profile</p>
                <div class="inline-block relative">
                    <div id="preview-frame" class="avatar-frame-wrap frame-{{ $currentFrame }}">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-dark bg-white">
                            <img src="{{ $avatarUrl }}" class="object-cover w-full h-full">
                        </div>
                    </div>
                </div>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <span class="font-extrabold text-dark text-base">{{ Auth::user()->name }}</span>
                    <span id="preview-badge" class="badge-pill {{ $currentBadge['bg'] }}">
                        {{ $currentBadge['emoji'] }} {{ $currentBadge['name'] }}
                    </span>
                </div>
            </div>

            <!-- Selector Avatar Frames (Discord Style) -->
            <div>
                <label class="block text-xs font-extrabold text-dark uppercase tracking-wider mb-2">1. Pilih Frame / Ring Animasi Avatar:</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="frame-opt p-3 border-2 border-dark rounded-playful-md cursor-pointer text-center bg-white hover:bg-primary/20 shadow-[2px_2px_0_#080330]" onclick="selectFrame('default')">
                        <span class="text-lg">🔘</span>
                        <p class="text-xs font-extrabold text-dark mt-1">Normal</p>
                    </div>
                    <div class="frame-opt p-3 border-2 border-dark rounded-playful-md cursor-pointer text-center bg-white hover:bg-primary/20 shadow-[2px_2px_0_#080330]" onclick="selectFrame('rainbow')">
                        <span class="text-lg">🌈</span>
                        <p class="text-xs font-extrabold text-dark mt-1">Rainbow Spin</p>
                    </div>
                    <div class="frame-opt p-3 border-2 border-dark rounded-playful-md cursor-pointer text-center bg-white hover:bg-primary/20 shadow-[2px_2px_0_#080330]" onclick="selectFrame('neon')">
                        <span class="text-lg">⚡</span>
                        <p class="text-xs font-extrabold text-dark mt-1">Neon Cyan</p>
                    </div>
                    <div class="frame-opt p-3 border-2 border-dark rounded-playful-md cursor-pointer text-center bg-white hover:bg-primary/20 shadow-[2px_2px_0_#080330]" onclick="selectFrame('gold')">
                        <span class="text-lg">✨</span>
                        <p class="text-xs font-extrabold text-dark mt-1">Golden Ring</p>
                    </div>
                    <div class="frame-opt p-3 border-2 border-dark rounded-playful-md cursor-pointer text-center bg-white hover:bg-primary/20 shadow-[2px_2px_0_#080330]" onclick="selectFrame('cyber')">
                        <span class="text-lg">⚙️</span>
                        <p class="text-xs font-extrabold text-dark mt-1">Cyber Dotted</p>
                    </div>
                    <div class="frame-opt p-3 border-2 border-dark rounded-playful-md cursor-pointer text-center bg-white hover:bg-primary/20 shadow-[2px_2px_0_#080330]" onclick="selectFrame('zen')">
                        <span class="text-lg">🌲</span>
                        <p class="text-xs font-extrabold text-dark mt-1">Zen Emerald</p>
                    </div>
                </div>
            </div>

            <!-- Selector Profile Badges -->
            <div>
                <label class="block text-xs font-extrabold text-dark uppercase tracking-wider mb-2">2. Pilih Profile Badge Exklusif:</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($badges as $key => $b)
                        <div class="badge-opt p-2.5 border-2 border-dark rounded-playful-md cursor-pointer flex items-center gap-2 bg-white hover:bg-secondary/30 shadow-[2px_2px_0_#080330]" onclick="selectBadge('{{ $key }}', '{{ $b['emoji'] }}', '{{ $b['name'] }}', '{{ $b['bg'] }}')">
                            <span class="text-xl">{{ $b['emoji'] }}</span>
                            <span class="text-xs font-extrabold text-dark">{{ $b['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="p-4 bg-gray-50 border-t-2 border-dark flex justify-end gap-3">
            <button onclick="closeCustomizationModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-dark font-extrabold text-xs rounded-playful-md border-2 border-dark shadow-[2px_2px_0_#080330]">
                Batal
            </button>
            <button onclick="saveCustomization()" class="px-6 py-2 bg-primary hover:bg-primary/90 text-dark font-extrabold text-xs rounded-playful-md border-2 border-dark shadow-[3px_3px_0_#080330]">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let selectedFrame = '{{ $currentFrame }}';
    let selectedBadgeKey = '{{ $currentBadgeKey }}';
    let selectedBadgeBg = '{{ $currentBadge['bg'] }}';
    let selectedBadgeEmoji = '{{ $currentBadge['emoji'] }}';
    let selectedBadgeName = '{{ $currentBadge['name'] }}';

    function openCustomizationModal() {
        document.getElementById('customization-modal').classList.remove('hidden');
    }

    function closeCustomizationModal() {
        document.getElementById('customization-modal').classList.add('hidden');
    }

    function selectFrame(frameName) {
        selectedFrame = frameName;
        const preview = document.getElementById('preview-frame');
        preview.className = `avatar-frame-wrap frame-${frameName}`;
    }

    function selectBadge(key, emoji, name, bgClass) {
        selectedBadgeKey = key;
        selectedBadgeEmoji = emoji;
        selectedBadgeName = name;
        selectedBadgeBg = bgClass;

        const previewBadge = document.getElementById('preview-badge');
        previewBadge.className = `badge-pill ${bgClass}`;
        previewBadge.innerHTML = `<span>${emoji}</span> ${name}`;
    }

    async function saveCustomization() {
        try {
            const res = await fetch('{{ route("user.profiles.customization") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    avatar_frame: selectedFrame,
                    profile_badge: selectedBadgeKey
                })
            });

            const data = await res.json();
            if (data.success) {
                // Update live page
                document.getElementById('avatar-frame-container').className = `avatar-frame-wrap frame-${selectedFrame}`;
                
                const mainBadge = document.getElementById('active-badge-display');
                if (mainBadge) {
                    mainBadge.className = `badge-pill ${selectedBadgeBg}`;
                    mainBadge.innerHTML = `<span>${selectedBadgeEmoji}</span> ${selectedBadgeName}`;
                }

                document.getElementById('active-frame-label').textContent = selectedFrame;
                
                const activeBadgeLabel = document.getElementById('active-badge-label');
                if (activeBadgeLabel) {
                    activeBadgeLabel.className = `badge-pill ${selectedBadgeBg}`;
                    activeBadgeLabel.innerHTML = `${selectedBadgeEmoji} ${selectedBadgeName}`;
                }

                closeCustomizationModal();
                alert('✨ Perubahan Avatar Frame & Badge Berhasil Disimpan!');
            }
        } catch (err) {
            console.error('Gagal menyimpan kustomisasi:', err);
        }
    }
</script>
@endsection
