@extends('layouts.app')

@section('title', 'Dashboard')

@section('style')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .indicator {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 9999px;
            z-index: 10;
        }

        .journal-indicator {
            bottom: 4px;
            left: 4px;
            background-color: orange;
        }

        .meditation-indicator {
            bottom: 4px;
            right: 4px;
            background-color: purple;
        }
        
        /* Tambahan untuk memperbaiki layout */
        .dashboard-grid {
            min-height: calc(100vh - 5rem);
            padding-top: 1.5rem;    /* Space atas */
            padding-bottom: 1.5rem;
        }
        
        .calendar-container {
            min-height: 250px;
        }
        
        .mood-chart-container {
            min-height: 200px;
        }
        
        .history-container {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')
    <div class="w-full  dashboard-grid grid grid-cols-1 md:grid-cols-3 gap-5 px-8 py-12">

        <!-- Kolom Kiri -->
        <div class="flex flex-col gap-4">
            <!-- Time & Month -->
            <div class="flex flex-row gap-4 h-20">
                <div id="timeBox"
                    class="click-1 flex-1 border border-dark rounded-playful-lg bg-primary flex items-center justify-center p-3 h-full">
                    <h2 class="text-h2 text-white text-shadow-h1 font-exo2 text-center" id="currentTime"></h2>
                </div>
                <div id="monthBox"
                    class="click-1 flex-1 border border-dark rounded-playful-lg bg-primary flex items-center justify-center p-3">
                    <h2 class="text-h2 text-white text-shadow-h1 font-exo2 text-center" id="currentMonthShort"></h2>
                </div>
            </div>

            <!-- Calendar -->
            <div class="calendar-container bg-primary p-2 rounded-3xl border-2 border-black shadow-lg">
                <div class="bg-white p-0 md:p-4 rounded-3xl border-2 border-dark">
                    <div id="calendarBody" class="grid grid-cols-7 gap-0 md:gap-2 w-[90%] md:w-full">
                    </div>
                </div>
            </div>
            
            <!-- Bottom Section -->
            <div class="flex flex-row gap-4 flex-1">
                <div class="flex flex-col flex-1 gap-4">
                    <div id="weatherBox" class="h-1/2 click-1 border border-dark rounded-playful-lg bg-secondary flex flex-col items-center justify-center p-3 text-dark">
                        <div id="weather-loading" class="text-center">
                            <p class="font-bold">Memuat cuaca...</p>
                            <p class="text-xs">Izinkan lokasi</p>
                        </div>
                        <div id="weather-content" class="hidden text-center">
                            <p id="weather-city" class="font-bold text-sm leading-tight">Nama Kota</p>
                            <p id="weather-temp" class="text-2xl font-bold leading-tight">25°C</p>
                            <p id="weather-desc" class="text-xs leading-tight">Cuaca</p>
                        </div>
                        <div id="weather-error" class="hidden text-center">
                            <p class="font-bold text-sm">Gagal memuat</p>
                        </div>
                    </div>
                    <a href="{{ route('chat.bot') }}" class="h-1/2 border border-dark rounded-playful-lg bg-secondary flex items-center justify-center p-3 gap-3">
                        <img src="{{ asset('assets/component/emote/ai_icon.svg') }}" alt="AI Icon">
                        <p class="text-lg font-bold">Chat Nemo</p>
                    </a>
                </div>
                <div class="w-1/2 flex">
                    <button id="mood-record"
                        class="h-full w-full border border-dark rounded-playful-lg bg-secondary flex flex-col items-center justify-center p-1 text-center">
                        <img src="{{ asset('assets/component/emote/face.svg') }}" alt="">
                        <b>Bagaimana mood anda hari ini?</b>
                    </button>

                    <div id="mood-modal"
                        class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
                        <div
                            class="bg-white rounded-playful-lg p-6 w-11/12 max-w-md shadow-border-offset-lg border-2 border-dark">
                            <h2 class="text-xl font-bold mb-4 text-dark">🌈 Catat Mood Anda</h2>
                            <label for="mood" class="block font-medium text-dark">Mood</label>
                            <select id="mood-select"
                                class="w-full border-2 border-dark rounded-playful-sm p-2 mb-3 focus:outline-none focus:ring-2 focus:ring-primary">
                                <option value="">-- Pilih mood --</option>
                                <option value="happy">😊 Senang</option>
                                <option value="sad">😢 Sedih</option>
                                <option value="anxious">😰 Cemas</option>
                                <option value="stressed">😫 Stres</option>
                                <option value="calm">😌 Tenang</option>
                                <option value="angry">😡 Marah</option>
                                <option value="tired">🥱 Lelah</option>
                                <option value="energetic">⚡ Bersemangat</option>
                                <option value="relaxed">🌿 Santai</option>
                            </select>
                            <label for="note" class="block font-medium text-dark">Catatan</label>
                            <textarea id="mood-note"
                                class="w-full border-2 border-dark rounded-playful-sm p-2 mb-4 focus:outline-none focus:ring-2 focus:ring-primary"
                                placeholder="Tambahkan catatan (opsional)" rows="3"></textarea>
                            <div class="flex justify-end gap-3">
                                <button id="cancel-mood"
                                    class="px-4 py-2 rounded-playful-sm bg-gray-300 text-dark border-2 border-dark shadow-border-offset-sm hover:bg-gray-400 transition-colors">❌
                                    Batal</button>
                                <button id="save-mood"
                                    class="px-4 py-2 rounded-playful-sm bg-primary text-white border-2 border-dark shadow-border-offset-sm hover:bg-green-600 transition-colors">✅
                                    Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Tengah -->
        <div class="flex flex-col gap-6">
            <!-- Riwayat Jurnal -->
            <div
                class="click-1 flex flex-col border-2 border-dark rounded-playful-lg bg-primary shadow-border-offset p-3">
                <h3 class="text-lg font-bold text-white mb-3">Riwayat Jurnal</h3>

                <div class="history-container border-2 border-dark rounded-playful-lg bg-white/10 p-2">
                    @forelse ($user->journals as $item)
                        <div data-id="{{ $item['id'] }}"
                            class="p-3 bg-gray-100 border-2 border-dark rounded-playful-md flex justify-between items-start cursor-pointer shadow-border-offset hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all mb-3 last:mb-0 {{ $item['active'] ? 'history-item-active' : '' }}">
                            <div class="flex flex-col">
                                <p class="text-sm font-bold text-dark">{{ $item['title'] }}</p>
                                <p class="text-xs text-gray-600 truncate w-40">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item['content']), 50, '...') }}
                                </p>
                            </div>
                            <span class="text-xs ml-2 {{ $item['active'] ? 'text-white/80' : 'text-gray-500' }}">
                                {{ \Carbon\Carbon::parse($item['updated_at'])->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    @empty
                        <div class="h-full flex items-center justify-center py-8">
                            <p class="text-white/70">Belum ada jurnal.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Grafik Mood -->
            <div
                class="click-1 border-2 border-dark rounded-playful-lg bg-secondary shadow-border-offset p-5 mood-chart-container flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-dark flex items-center">
                        <span class="mr-2 text-2xl">😊</span> Grafik Mood Mingguan
                    </h3>
                    <div class="flex space-x-1">
                        <div class="w-3 h-3 rounded-full bg-indigo-400"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <div class="w-3 h-3 rounded-full bg-pink-400"></div>
                    </div>
                </div>
                <div class="chart-container flex-1 relative">
                    <canvas id="moodChart"></canvas>
                </div>
            </div>
            
            <!-- Daily Challenges -->
            <div id="daily-challenges"
                class="click-1 bg-secondary border-2 border-dark rounded-playful-lg p-4 shadow-border-offset">
                <h2 class="text-xl font-exo2 font-bold text-dark mb-3">🔥 Daily Challenges</h2>
                <ul class="space-y-2">
                    <li
                        class="flex items-center gap-3 border-2 border-dark rounded-playful-sm bg-white px-3 py-2 hover:bg-primary/10 transition">
                        <input type="checkbox" class="accent-primary w-5 h-5">
                        <span class="font-medium text-dark">Meditasi 5 menit</span>
                    </li>
                    <li
                        class="flex items-center gap-3 border-2 border-dark rounded-playful-sm bg-white px-3 py-2 hover:bg-primary/10 transition">
                        <input type="checkbox" class="accent-primary w-5 h-5">
                        <span class="font-medium text-dark">Tulis 1 hal yang kamu syukuri</span>
                    </li>
                    <li
                        class="flex items-center gap-3 border-2 border-dark rounded-playful-sm bg-white px-3 py-2 hover:bg-primary/10 transition">
                        <input type="checkbox" class="accent-primary w-5 h-5">
                        <span class="font-medium text-dark">Minum air putih 2 gelas</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Kolom Kanan -->
        @php
            $colors = [
                'bg-red-400',
                'bg-blue-400',
                'bg-green-400',
                'bg-yellow-400',
                'bg-purple-400',
                'bg-pink-400',
                'bg-orange-400',
                'bg-grey-400',
            ];
            $randomColor = $colors[array_rand($colors)];
        @endphp
        <div class="flex flex-col gap-6">
            <!-- Top Post -->
            <div
                class="click-1 flex-grow border-2 border-dark rounded-playful-lg bg-primary shadow-border-offset p-4 flex flex-col">
                @if ($topPost)
                    <a href="#" class="flex flex-col gap-3 h-full">
                        <div class="flex justify-between items-center">
                            @if ($topPost->is_anonymous)
                                <div
                                    class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset mr-3 font-bold text-white {{ $randomColor }}">
                                    <img src="{{ asset('assets/component/emote/anonymous.svg') }}" alt="Anonymous"
                                        class="w-10 h-10 rounded-full border-2 border-dark shadow-border-offset object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold font-lexend text-dark text-lg">Anonymous</h3>
                                    <p class="text-sm text-black font-lexend">@anonymous •
                                        {{ $topPost->created_at->diffForHumans() }}</p>
                                </div>
                            @else
                                @if ($topPost->user->avatar)
                                    <img src="{{ $topPost->user->avatar_url }}" alt="{{ $topPost->user->name }}"
                                        class="w-10 h-10 rounded-full border-2 border-dark shadow-border-offset mr-3 object-cover">
                                @else
                                    <div
                                        class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset mr-3 font-bold text-white {{ $randomColor }}">
                                        {{ strtoupper(substr($topPost->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-bold font-lexend text-dark text-lg">{{ $topPost->user->name }}</h3>
                                    <p class="text-sm text-gray-500 font-lexend">{{ strtolower($topPost->user->name) }} •
                                        {{ $topPost->created_at->diffForHumans() }}</p>
                                </div>
                            @endif
                        </div>

                        @if ($topPost->image)
                            <div
                                class="w-full h-48 rounded-playful-lg border-2 border-dark overflow-hidden shadow-border-offset">
                                <img src="{{ asset('storage/' . $topPost->image) }}" alt="Post Image"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="text-sm text-gray-700">
                            <p class="font-medium font-lexend text-dark">
                                {{ \Illuminate\Support\Str::limit($topPost->content, 150, '...') }}</p>
                        </div>
                    </a>
                @else
                    <div class="h-full flex flex-col justify-center items-center py-8">
                        <p class="text-dark font-lexend text-center">Belum ada postingan untuk ditampilkan saat ini. 😢</p>
                    </div>
                @endif
            </div>

            <!-- Quote -->
            <div
                class="click-1 border-2 border-dark rounded-playful-lg bg-primary shadow-border-offset p-3 flex flex-col justify-center items-center text-center min-h-[120px]">
                @if ($quote)
                    <p id="quote" class="text-sm italic font-bold text-gray-700">
                        "{{ $quote['quote'] }}"
                    </p>
                    <span class="mt-2 text-xs text-gray-600">- {{ $quote['author'] }}</span>
                @else
                    <p id="quote" class="text-sm italic text-gray-700">
                        "Tidak ada kata-kata mutiara hari ini."
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const moodRecordBtn = document.getElementById('mood-record');
            const moodModal = document.getElementById('mood-modal');
            const cancelMoodBtn = document.getElementById('cancel-mood');
            const saveMoodBtn = document.getElementById('save-mood');
            const moodSelect = document.getElementById('mood-select');
            const moodNote = document.getElementById('mood-note');

            // Buka modal saat tombol mood record diklik
            moodRecordBtn.addEventListener('click', function() {
                moodModal.classList.remove('hidden');
                moodModal.classList.add('flex');
            });

            // Tutup modal saat tombol batal diklik
            cancelMoodBtn.addEventListener('click', function() {
                moodModal.classList.remove('flex');
                moodModal.classList.add('hidden');
                resetMoodForm();
            });

            // Tutup modal saat klik di luar modal
            moodModal.addEventListener('click', function(e) {
                if (e.target === moodModal) {
                    moodModal.classList.remove('flex');
                    moodModal.classList.add('hidden');
                    resetMoodForm();
                }
            });

            // Simpan mood saat tombol simpan diklik
            saveMoodBtn.addEventListener('click', async function() {
                const mood = moodSelect.value;
                const note = moodNote.value;

                if (!mood) {
                    alert('Silakan pilih mood terlebih dahulu!');
                    return;
                }

                try {
                    const res = await fetch("{{ route('user.mood') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: JSON.stringify({
                            user_id: "{{ auth()->id() }}",
                            mood: mood,
                            note: note
                        })
                    });

                    const data = await res.json();

                    if (data.success) {
                        alert('Mood berhasil disimpan ✅');
                        moodModal.classList.remove('flex');
                        moodModal.classList.add('hidden');
                        resetMoodForm();
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal menyimpan mood ❌');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Terjadi error. Cek console untuk detail.');
                }
            });

            // Fungsi untuk mereset form mood
            function resetMoodForm() {
                moodSelect.value = '';
                moodNote.value = '';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DIUBAH: Menerima riwayatPostingan dari controller, bukan lagi riwayatMeditasi
            const riwayatJurnal = @json($riwayatJurnal ?? []);
            const riwayatPostingan = @json($riwayatPostingan ?? []);

            const monthShortNames = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGT", "SEP", "OKT", "NOV",
                "DES"
            ];
            let currentDate = new Date();

            // Fungsi update jam (sudah dalam format 24 jam)
            function updateTime() {
                const now = new Date();
                let hours = now.getHours();
                let minutes = now.getMinutes();
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                const timeStr = `${hours}:${minutes}`;
                document.getElementById('currentTime').textContent = timeStr;
            }

            // Fungsi update bulan (tidak ada perubahan)
            function updateMonthShort(month) {
                document.getElementById('currentMonthShort').textContent = monthShortNames[month];
            }

            function renderCalendar(month, year) {
                const calendarBody = document.getElementById('calendarBody');
                if (!calendarBody) return;

                calendarBody.innerHTML = '';

                const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                dayNames.forEach(day => {
                    const dayCell = document.createElement('div');
                    dayCell.className = 'md:flex hidden text-center font-bold text-sm text-gray-500 p-0';
                    dayCell.textContent = day;
                    calendarBody.appendChild(dayCell);
                });

                const firstDayOfMonth = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                let startingDay = firstDayOfMonth;

                for (let i = 0; i < startingDay; i++) {
                    const emptyCell = document.createElement('div');
                    calendarBody.appendChild(emptyCell);
                }

                const today = new Date();
                const isCurrentMonthAndYear = month === today.getMonth() && year === today.getFullYear();

                for (let day = 1; day <= daysInMonth; day++) {
                    const cell = document.createElement('div');
                    cell.className = 'text-center w-20 md:w-auto p-1 relative flex items-center justify-center';

                    const dayDiv = document.createElement('div');
                    dayDiv.className = `
                    w-5 h-8 md:w-12 md:h-8 flex flex-col items-center justify-between py-1
                    rounded-lg relative cursor-pointer
                    md:border-2 md:border-dark
                    hover:bg-secondary hover:border-2 hover:border-dark md:hover:bg-gray-100 hover:scale-105 transition-all duration-200
                    shadow-sm
                `;

                    const dayNumber = document.createElement('span');
                    dayNumber.textContent = day;
                    dayDiv.appendChild(dayNumber);

                    const isToday = isCurrentMonthAndYear && day === today.getDate();
                    const weekDay = new Date(year, month, day).getDay();

                    if (isToday) {
                        dayDiv.classList.add('bg-primary', 'text-white', 'font-bold');
                        dayDiv.classList.remove('border-transparent');
                        dayDiv.classList.add('border-black');
                    } else {
                        if (weekDay === 6) {
                            dayNumber.classList.add('text-indigo-600', 'font-semibold');
                        } else if (weekDay === 0) {
                            dayNumber.classList.add('text-red-600', 'font-semibold');
                        }
                    }

                    const indicatorContainer = document.createElement('div');
                    indicatorContainer.className = 'flex items-center justify-center gap-1';

                    if (riwayatJurnal.includes(day)) {
                        const journalIndicator = document.createElement('span');
                        journalIndicator.className = 'block w-2 h-2 rounded-full';
                        journalIndicator.style.backgroundColor = '#876582';
                        indicatorContainer.appendChild(journalIndicator);
                    }

                    if (riwayatPostingan.includes(day)) {
                        const postIndicator = document.createElement('span');
                        postIndicator.className = 'block w-2 h-2 rounded-full';
                        postIndicator.style.backgroundColor = '#FF6600';
                        indicatorContainer.appendChild(postIndicator);
                    }

                    dayDiv.appendChild(indicatorContainer);
                    cell.appendChild(dayDiv);
                    calendarBody.appendChild(cell);
                }
            }

            // Panggil semua fungsi saat halaman pertama kali dimuat (tidak ada perubahan)
            updateMonthShort(currentDate.getMonth());
            renderCalendar(currentDate.getMonth(), currentDate.getFullYear());
            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('moodChart').getContext('2d');

            const moodLabels = @json($labels);
            const moodData = @json($data);
            const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

            // Warna untuk setiap hari
            const backgroundColors = [
                'rgba(251, 146, 60, 0.6)', 'rgba(249, 115, 22, 0.6)', 'rgba(245, 158, 11, 0.6)',
                'rgba(251, 146, 60, 0.6)', 'rgba(249, 115, 22, 0.6)', 'rgba(245, 158, 11, 0.6)',
                'rgba(251, 146, 60, 0.6)'
            ];

            const borderColors = [
                'rgb(251, 146, 60)', 'rgb(249, 115, 22)', 'rgb(245, 158, 11)', 'rgb(251, 146, 60)',
                'rgb(249, 115, 22)', 'rgb(245, 158, 11)', 'rgb(251, 146, 60)'
            ];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: days,
                    datasets: [{
                        label: moodLabels,
                        data: moodData,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 2,
                        borderRadius: 10,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(45, 55, 72, 0.9)',
                            titleFont: {
                                family: 'Nunito',
                                size: 14
                            },
                            bodyFont: {
                                family: 'Nunito',
                                size: 14
                            },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    let label = 'Mood: ' + context.parsed.y + '/5 - ';
                                    switch (context.parsed.y) {
                                        case 1:
                                            label += '😢 Sedih';
                                            break;
                                        case 2:
                                            label += '😐 Biasa';
                                            break;
                                        case 3:
                                            label += '😊 Senang';
                                            break;
                                        case 4:
                                            label += '😁 Bahagia';
                                            break;
                                        case 5:
                                            label += '🤩 Luar Biasa';
                                            break;
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 5,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: 'Nunito',
                                    size: 12,
                                    weight: 'bold'
                                },
                                callback: function(value) {
                                    switch (value) {
                                        case 1:
                                            return '😢';
                                        case 2:
                                            return '😐';
                                        case 3:
                                            return '😊';
                                        case 4:
                                            return '😁';
                                        case 5:
                                            return '🤩';
                                        default:
                                            return '';
                                    }
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                lineWidth: 2
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Nunito',
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeOutBounce'
                    }
                }
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weatherLoading = document.getElementById('weather-loading');
            const weatherContent = document.getElementById('weather-content');
            const weatherError = document.getElementById('weather-error');

            const weatherCity = document.getElementById('weather-city');
            const weatherTemp = document.getElementById('weather-temp');
            const weatherDesc = document.getElementById('weather-desc');

            // FUNGSI PENERJEMAH CUACA
            function translateWeather(description) {
                const descLower = description.toLowerCase();
                switch (descLower) {
                    case 'broken clouds':
                        return 'Cukup Berawan';
                    case 'overcast clouds':
                        return 'Mendung';
                    case 'scattered clouds':
                        return 'Berawan Sebagian';
                    case 'few clouds':
                        return 'Sedikit Berawan';
                    case 'clear sky':
                        return 'Cerah';
                    case 'light rain':
                        return 'Gerimis';
                    case 'moderate rain':
                        return 'Hujan';
                    case 'heavy intensity rain':
                        return 'Hujan Lebat';
                    case 'thunderstorm':
                        return 'Hujan Petir';
                    case 'mist':
                    case 'fog':
                        return 'Berkabut';
                    case 'haze':
                        return 'Sedikit Berkabut';
                    default:
                        return description.charAt(0).toUpperCase() + description.slice(1);
                }
            }

            function showWeatherData(data) {
                const cityName = data.city;
                const maxLength = 12;
                
                weatherCity.textContent = cityName.length > maxLength 
                    ? cityName.substring(0, maxLength) + '...' 
                    : cityName;

                weatherTemp.textContent = `${Math.round(data.temperature)}°C`;
                weatherDesc.textContent = translateWeather(data.description);

                weatherLoading.classList.add('hidden');
                weatherContent.classList.remove('hidden');
                weatherError.classList.add('hidden');
            }

            function handleWeatherError(message) {
                if (weatherError.querySelector('p')) {
                    weatherError.querySelector('p').textContent = message;
                }
                weatherLoading.classList.add('hidden');
                weatherContent.classList.add('hidden');
                weatherError.classList.remove('hidden');
            }

            // Fungsi utama untuk mengambil data cuaca
            async function fetchWeather() {
                if (!('geolocation' in navigator)) {
                    return handleWeatherError('Geolocation tidak didukung.');
                }

                navigator.geolocation.getCurrentPosition(async (position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    try {
                        const response = await fetch(`{{ route('weather.get') }}?lat=${lat}&lon=${lon}`);
                        if (!response.ok) {
                            throw new Error('Respons jaringan tidak baik.');
                        }
                        const data = await response.json();

                        // 4. Simpan data baru dan timestamp ke localStorage
                        const dataToCache = {
                            data: data,
                            timestamp: new Date().getTime() // Simpan waktu saat ini
                        };
                        localStorage.setItem('weatherData', JSON.stringify(dataToCache));
                        
                        // Tampilkan data yang baru diambil
                        showWeatherData(data);

                    } catch (error) {
                        console.error('Fetch error:', error);
                        handleWeatherError('Gagal mengambil data.');
                    }
                }, (error) => {
                    console.error('Geolocation error:', error);
                    if (error.code === error.PERMISSION_DENIED) {
                        handleWeatherError('Izin lokasi ditolak.');
                    } else {
                        handleWeatherError('Lokasi tidak tersedia.');
                    }
                });
            }

            const cachedWeather = localStorage.getItem('weatherData');

            if (cachedWeather) {
                const { data, timestamp } = JSON.parse(cachedWeather);
                const now = new Date().getTime();
                const tenMinutes = 10 * 60 * 1000; // 10 menit dalam milidetik

                // 2. Cek apakah data belum kedaluwarsa (kurang dari 10 menit)
                if ((now - timestamp) < tenMinutes) {
                    console.log("Cuaca: Memuat dari cache (super cepat!)");
                    showWeatherData(data); // Langsung tampilkan dari cache
                } else {
                    // 3. Jika data sudah kedaluwarsa, ambil data baru
                    console.log("Cuaca: Cache kedaluwarsa, mengambil data baru.");
                    fetchWeather();
                }
            } else {
                // 3. Jika tidak ada cache sama sekali, ambil data baru
                console.log("Cuaca: Tidak ada cache, mengambil data baru.");
                fetchWeather();
            }
        });
    </script>
@endsection