    @extends('layouts.app')

@section('content')
<div class="w-full min-h-screen h-full flex flex-col md:flex-row overflow-y-auto p-0 justify-center items-center">

    <div class="h-3/4 calendar-section  w-full lg:w-1/2 flex flex-col items-center gap-6">
        <div class="calendar w-full max-w-2xl">

            <div class=" calendar-header flex justify-around items-center p-4 bg-primary rounded-t-playful-lg border-x-2 border-t-2 border-dark shadow-border-offset">
                <button id="prevMonth" class="bg-secondary border-2 border-black text-white rounded-full w-12 h-12 flex items-center justify-center text-3xl shadow-border-offset transition-all hover:bg-orange hover:rotate-[-8deg] hover:scale-110 active:shadow-[1px_2px_0px_#1A1A40] active:translate-x-0.5 active:translate-y-0.5">
                    <span class="-mt-1">⟨</span>
                </button>
                <div class="month-year flex flex-col items-center cursor-pointer">
                    <span id="monthName" class="drop-shadow-md tracking-wide text-white text-2xl font-bold font-exo2">Januari</span>
                    <span id="yearDisplay" class="text-sm font-medium text-white font-lexend">2024</span>
                </div>
                <button id="nextMonth" class="bg-secondary border-2 border-black text-white rounded-full w-12 h-12 flex items-center justify-center text-3xl shadow-border-offset transition-all hover:bg-orange hover:rotate-[8deg] hover:scale-110 active:shadow-[1px_2px_0px_#1A1A40] active:translate-x-0.5 active:translate-y-0.5">
                    <span class="-mt-1">⟩</span>
                </button>
            </div>

            <div class=" bg-white p-4 rounded-b-playful-lg border-2 border-black shadow-border-offset">
                <div class="grid grid-cols-7 gap-2 text-center mb-2">
                    <div class="font-bold text-dark font-lexend text-sm md:text-base">Sen</div>
                    <div class="font-bold text-dark font-lexend text-sm md:text-base">Sel</div>
                    <div class="font-bold text-dark font-lexend text-sm md:text-base">Rab</div>
                    <div class="font-bold text-dark font-lexend text-sm md:text-base">Kam</div>
                    <div class="font-bold text-dark font-lexend text-sm md:text-base">Jum</div>
                    <div class="font-bold text-dark font-lexend text-sm md:text-base">Sab</div>
                    <div class="font-bold text-dark font-lexend text-sm md:text-base">Min</div>
                </div>
                <div id="calendarBody" class="grid grid-cols-7 gap-2">
                </div>
            </div>

        </div>
        <div class="h-1/4 challenge-progress w-full max-w-2xl p-4 rounded-playful-lg border-2 border-dark bg-white shadow-border-offset">
            
                <!-- Tantangan 2 -->
                <div class="flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <p class="font-medium font-lexend text-dark">7 Hari Beruntun Mood Tracker</p>
                        <div class="w-full bg-gray-200 rounded-full h-3 mt-1">
                            <div class="bg-green-500 h-3 rounded-full" style="width: 100%;"></div>
                        </div>
                    </div>
                    <span class="text-sm font-bold font-exo2 text-dark">7/7</span>
                </div>
        </div>


    </div>

    <div class="right-section w-full lg:w-1/2 flex flex-col items-center gap-8">

        <div class="h-1/2 stats-container w-full max-w-2xl p-6 rounded-playful-lg border-2 border-dark bg-primary shadow-border-offset">
            <h2 class="font-bold text-2xl md:text-3xl text-white mb-4 text-center font-exo2 text-shadow-h1">Aktivitasmu 🚀</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="stat-card p-4 rounded-playful-lg border-2 border-dark bg-white text-center shadow-border-offset">
                    <p class="text-4xl font-bold text-orange font-exo2" id="postCount">{{ $postCount }}</p>
                    <p class="text-sm md:text-base text-dark font-medium mt-1 font-lexend">Postingan Dibuat</p>
                </div>
                <div class="stat-card p-4 rounded-playful-lg border-2 border-dark bg-white text-center shadow-border-offset">
                    <p class="text-4xl font-bold text-secondary font-exo2" id="journalCount">{{ $journalCount }}</p>
                    <p class="text-sm md:text-base text-dark font-medium mt-1 font-lexend">Jurnal Ditulis</p>
                </div>
                <div class="stat-card p-4 rounded-playful-lg border-2 border-dark bg-white text-center shadow-border-offset">
                    <p class="text-4xl font-bold text-primary font-exo2" id="streakCount">{{ $streakCount }}</p>
                    <p class="text-sm md:text-base text-dark font-medium mt-1 font-lexend">Hari Berturut-turut</p>
                </div>
            </div>

        </div>

        <div class="h-1/2 mood-container w-full max-w-2xl p-6 rounded-playful-lg border-2 border-dark bg-secondary shadow-border-offset">
            <h2 class="font-bold text-2xl md:text-3xl text-white mb-4 text-center font-exo2 text-shadow-h1">Trafik Mood 🌈</h2>
            <div class="h-48 border-2 border-dark rounded-playful-lg bg-white p-4 shadow-border-offset">
                <canvas id="moodChart"></canvas>
            </div>
            <div id="moodSummaryIcons" class="flex items-center justify-around flex-wrap gap-4 py-2">
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const moodInfo = {
    "Bahagia": { emoji: "😊", color: "bg-yellow-400", borderColor: "border-yellow-600" },
    "Tenang": { emoji: "😌", color: "bg-blue-400", borderColor: "border-blue-600" },
    "Biasa": { emoji: "😐", color: "bg-gray-400", borderColor: "border-gray-600" },
    "Sedih": { emoji: "😢", color: "bg-purple-400", borderColor: "border-purple-600" },
    "Marah": { emoji: "😡", color: "bg-red-400", borderColor: "border-red-600" },
    "Semangat": { emoji: "💪", color: "bg-green-400", borderColor: "border-green-600" }
};

    document.addEventListener('DOMContentLoaded', function() {
        // --- Dummy Data & Setup ---
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        let currentDate = new Date();

    const moodData = @json($moodData);

        const generateDummyData = (year, month) => {
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const postDays = new Set();
            const journalDays = new Set();
            const curhatDays = new Set();
            const moodLogs = {};
            const moodHistory = [];
            const moodCounts = {
                'Bahagia': 0
                , 'Tenang': 0
                , 'Biasa': 0
                , 'Sedih': 0
                , 'Marah': 0
                , 'Semangat': 0
            };

            // Generate weekly mood history
            for (let i = 0; i < 7; i++) {
                const dayMood = Object.keys(moodData)[Math.floor(Math.random() * Object.keys(moodData).length)];
                moodHistory.push({
                    day: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'][i]
                    , mood: dayMood
                    , value: Math.floor(Math.random() * 60) + 40
                });
            }

            // Generate daily activity logs
            for (let i = 0; i < Math.floor(daysInMonth / 4); i++) {
                postDays.add(Math.floor(Math.random() * daysInMonth) + 1);
            }
            for (let i = 0; i < Math.floor(daysInMonth / 5); i++) {
                journalDays.add(Math.floor(Math.random() * daysInMonth) + 1);
            }
            for (let i = 0; i < Math.floor(daysInMonth / 6); i++) {
                curhatDays.add(Math.floor(Math.random() * daysInMonth) + 1);
            }

            for (let i = 1; i <= daysInMonth; i++) {
                if (Math.random() > 0.5) {
                    const mood = Object.keys(moodData)[Math.floor(Math.random() * Object.keys(moodData).length)];
                    moodLogs[i] = {
                        mood
                        , emoji: moodData[mood].emoji
                    };
                    moodCounts[mood]++;
                }
            }

            return {
                postDays: Array.from(postDays).sort((a, b) => a - b)
                , journalDays: Array.from(journalDays).sort((a, b) => a - b)
                , curhatDays: Array.from(curhatDays).sort((a, b) => a - b)
                , moodLogs
                , moodHistory
                , moodCounts
            };
        };

        let currentData = generateDummyData(currentDate.getFullYear(), currentDate.getMonth());

        // --- Calendar Functionality ---
        function renderCalendar() {
            const calendarBody = document.getElementById('calendarBody');
            const monthName = document.getElementById('monthName');
            const yearDisplay = document.getElementById('yearDisplay');

            calendarBody.innerHTML = '';
            monthName.textContent = monthNames[currentDate.getMonth()];
            yearDisplay.textContent = currentDate.getFullYear();

            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
            const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
            let startDay = firstDay === 0 ? 6 : firstDay - 1;

            for (let i = 0; i < startDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'p-2';
                calendarBody.appendChild(emptyCell);
            }

            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const cell = document.createElement('div');
                cell.className = 'calendar-day relative flex flex-col items-center justify-center cursor-pointer transition-all p-2 hover:bg-gray-100 hover:scale-[1.02]';

                // Add day number
                const dayDiv = document.createElement('div');
                dayDiv.className = 'font-bold text-dark font-lexend mb-1';
                dayDiv.textContent = day;
                cell.appendChild(dayDiv);

                // Add mood emoji with hover effect
                if (currentData.moodLogs[day]) {
                    const moodEmoji = document.createElement('span');
                    moodEmoji.className = 'text-xl drop-shadow-sm transition-transform group-hover:scale-125';
                    moodEmoji.textContent = currentData.moodLogs[day].emoji;
                    cell.appendChild(moodEmoji);
                }

                // Indicators for activities
                const indicatorsContainer = document.createElement('div');
                indicatorsContainer.className = 'absolute bottom-1 right-1 flex gap-1';

                if (currentData.postDays.includes(day)) {
                    const postIndicator = document.createElement('div');
                    postIndicator.className = 'w-2 h-2 rounded-full border border-dark bg-yellow-400'; // Kuning untuk Post
                    postIndicator.title = 'Postingan dibuat hari ini';
                    indicatorsContainer.appendChild(postIndicator);
                }
                if (currentData.journalDays.includes(day)) {
                    const journalIndicator = document.createElement('div');
                    journalIndicator.className = 'w-2 h-2 rounded-full border border-dark bg-purple-400'; // Ungu untuk Journal
                    journalIndicator.title = 'Jurnal ditulis hari ini';
                    indicatorsContainer.appendChild(journalIndicator);
                }
                if (currentData.curhatDays.includes(day)) {
                    const curhatIndicator = document.createElement('div');
                    curhatIndicator.className = 'w-2 h-2 rounded-full border border-dark bg-green-400'; // Hijau untuk Curhat
                    curhatIndicator.title = 'Curhat ditulis hari ini';
                    indicatorsContainer.appendChild(curhatIndicator);
                }

                cell.appendChild(indicatorsContainer);

                // Highlight today
                if (day === today.getDate() && currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
                    cell.classList.add('bg-primary', 'text-white', 'font-extrabold', 'today', 'hover:bg-primary/90');
                    dayDiv.classList.add('text-white');
                    cell.style.borderRadius = '0.5rem';
                    cell.style.border = '2px solid black';
                    cell.style.boxShadow = '2px 2px 0px black';
                } else {
                    cell.style.borderRadius = '0.5rem';
                    cell.style.border = '2px solid black';
                    cell.style.boxShadow = '2px 2px 0px black';
                }

                // Add click event to show details
                cell.addEventListener('click', function() {
                    showDayDetails(day, currentDate.getMonth(), currentDate.getFullYear());
                });

                calendarBody.appendChild(cell);
            }

            updateMoodSummary();
        }

        function showDayDetails(day, month, year) {
            const mood = currentData.moodLogs[day] ? currentData.moodLogs[day].emoji : 'Tidak ada';
            const postStatus = currentData.postDays.includes(day) ? 'Ada' : 'Tidak ada';
            const journalStatus = currentData.journalDays.includes(day) ? 'Ditulis' : 'Tidak ada';
            const curhatStatus = currentData.curhatDays.includes(day) ? 'Ditulis' : 'Tidak ada';

            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white p-6 rounded-playful-lg border-2 border-dark max-w-md w-full shadow-border-offset">
                    <h3 class="text-xl font-bold mb-4 font-exo2 text-center text-dark">Detail Aktivitas - ${day} ${monthNames[month]} ${year}</h3>
                    <div class="space-y-3 font-lexend text-dark">
                        <div class="flex items-center gap-2">
                            <span class="text-3xl">${mood}</span>
                            <p>Mood: ${currentData.moodLogs[day] ? Object.keys(moodData).find(key => moodData[key].emoji === mood) : 'Tidak ada'}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded-full bg-yellow-400 border-2 border-dark"></div>
                            <p>Postingan: ${postStatus}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded-full bg-purple-400 border-2 border-dark"></div>
                            <p>Jurnal: ${journalStatus}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded-full bg-green-400 border-2 border-dark"></div>
                            <p>Curhat: ${curhatStatus}</p>
                        </div>
                    </div>
                    <button class="mt-6 bg-primary text-white px-4 py-2 rounded-playful-lg border-2 border-dark w-full hover:bg-orange transition font-lexend shadow-border-offset active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_2px_0px_#1A1A40]">Tutup</button>
                </div>
            `;

            document.body.appendChild(modal);

            modal.querySelector('button').addEventListener('click', function() {
                document.body.removeChild(modal);
            });
        }

       function updateMoodSummary() {
    const summaryContainer = document.getElementById('moodSummaryIcons');
    summaryContainer.innerHTML = '';
    for (const moodName in moodData.moodCounts) {
        if (moodData.moodCounts[moodName] > 0) {
            const moodItem = document.createElement('div');
            moodItem.className = 'flex flex-col items-center flex-grow';
            moodItem.innerHTML = `
                <div class="w-16 h-16 ${moodInfo[moodName].color} rounded-full flex items-center justify-center mb-2 border-2 ${moodInfo[moodName].borderColor}">
                    <span class="text-3xl">${moodInfo[moodName].emoji}</span>
                </div>
                <span class="text-sm font-medium font-lexend text-center">${moodName}</span>
                <span class="text-xs font-bold font-exo2 text-dark mt-1">${moodData.moodCounts[moodName]} hari</span>
            `;
            summaryContainer.appendChild(moodItem);
        }
    }
}


        // --- Stats Functionality ---
        function updateStats() {
            const postCount = currentData.postDays.length;
            const journalCount = currentData.journalDays.length;
            const curhatCount = currentData.curhatDays.length;
            const streakCount = Math.floor(Math.random() * 15) + 1;

            animateValue('postCount', 0, postCount, 1000);
            animateValue('journalCount', 0, journalCount, 1000);
            animateValue('streakCount', 0, streakCount, 1000);
        }

        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // --- Mood chart ---
        let moodChartInstance = null;

        function initMoodChart() {
            if (moodChartInstance) {
                moodChartInstance.destroy();
            }
            
            // Siapkan data untuk chart (contoh, perlu disesuaikan dengan data real)
            const moodHistory = [
                { day: 'Sen', mood: 'Bahagia', value: 80 },
                { day: 'Sel', mood: 'Tenang', value: 70 },
                { day: 'Rab', mood: 'Biasa', value: 60 },
                { day: 'Kam', mood: 'Sedih', value: 40 },
                { day: 'Jum', mood: 'Marah', value: 30 },
                { day: 'Sab', mood: 'Semangat', value: 90 },
                { day: 'Min', mood: 'Bahagia', value: 85 }
            ];
            
            const ctx = document.getElementById('moodChart').getContext('2d');
            moodChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: moodHistory.map(d => d.day),
                    datasets: [{
                        label: 'Tingkat Mood',
                        data: moodHistory.map(d => d.value),
                        backgroundColor: moodHistory.map(d => {
                            const color = moodInfo[d.mood].color;
                            return color === 'bg-yellow-400' ? 'rgba(245, 158, 11, 0.7)' :
                                   color === 'bg-blue-400' ? 'rgba(59, 130, 246, 0.7)' :
                                   color === 'bg-gray-400' ? 'rgba(156, 163, 175, 0.7)' :
                                   color === 'bg-purple-400' ? 'rgba(139, 92, 246, 0.7)' :
                                   color === 'bg-red-400' ? 'rgba(239, 68, 68, 0.7)' :
                                   'rgba(34, 197, 94, 0.7)';
                        }),
                        borderColor: moodHistory.map(d => {
                            const borderColor = moodInfo[d.mood].borderColor;
                            return borderColor === 'border-yellow-600' ? 'rgb(245, 158, 11)' :
                                   borderColor === 'border-blue-600' ? 'rgb(59, 130, 246)' :
                                   borderColor === 'border-gray-600' ? 'rgb(156, 163, 175)' :
                                   borderColor === 'border-purple-600' ? 'rgb(139, 92, 246)' :
                                   borderColor === 'border-red-600' ? 'rgb(239, 68, 68)' :
                                   'rgb(34, 197, 94)';
                        }),
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#1A1A40',
                                font: {
                                    family: 'Lexend'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                                color: '#1A1A40',
                                font: {
                                    family: 'Lexend'
                                }
                            },
                            grid: {
                                color: '#e5e7eb'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const moodName = moodHistory[context.dataIndex].mood;
                                    return `Mood: ${moodName} (${context.raw}%)`;
                                }
                            }
                        }
                    },
                    maintainAspectRatio: false
                }
            });
        }

        // --- Event listeners ---
        document.getElementById('prevMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            currentData = generateDummyData(currentDate.getFullYear(), currentDate.getMonth());
            renderCalendar();
            initMoodChart();
            updateStats();
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            currentData = generateDummyData(currentDate.getFullYear(), currentDate.getMonth());
            renderCalendar();
            initMoodChart();
            updateStats();
        });

        // --- Initialize ---
        renderCalendar();
        updateStats();
        initMoodChart();
    });

</script>
@endsection
