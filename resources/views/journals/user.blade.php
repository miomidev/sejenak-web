@extends('layouts.app')

@section('title', 'Journaling')

@section('style')
<style>
    /* Styling khusus Kalender & Editor Jurnal */
    .calendar-day-circle {
        @apply w-8 h-8 flex justify-center items-center rounded-full border-2 border-dark cursor-pointer transition-all text-xs font-extrabold select-none;
    }

    .calendar-day-circle:hover {
        @apply border-black text-black bg-primary/30 transform -translate-y-0.5;
    }

    .calendar-day-circle.journaled {
        @apply bg-primary/40 border-black font-extrabold text-black;
    }

    .calendar-day-circle.active {
        @apply border-black bg-primary text-black font-extrabold shadow-[2px_2px_0_#080330];
    }

    .calendar-dot {
        @apply w-2 h-2 rounded-full absolute -bottom-1 bg-black;
    }

    .history-item {
        @apply p-3 bg-white border-2 border-dark rounded-playful-md flex justify-between items-center cursor-pointer shadow-border-offset transition-all hover:bg-secondary/30;
    }

    .history-item-active {
        @apply bg-primary border-2 border-dark text-black shadow-none transform translate-x-1 translate-y-1 font-bold;
    }

    .format-dropdown, .color-dropdown {
        position: relative;
        display: inline-block;
    }

    .format-dropdown-content, .color-dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        border: 2px solid #080330;
        border-radius: 12px;
        box-shadow: 4px 4px 0 #080330;
        z-index: 50;
        bottom: 100%;
        left: 0;
        margin-bottom: 8px;
    }

    .format-dropdown-content button {
        display: block;
        width: 100%;
        padding: 8px 14px;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.2s;
    }

    .format-dropdown-content button:hover {
        background-color: #DCD489;
    }

    .color-dropdown-content {
        width: 170px;
        padding: 10px;
    }

    .color-option {
        width: 22px;
        height: 22px;
        border: 2px solid #080330;
        border-radius: 50%;
        display: inline-block;
        margin: 4px;
        cursor: pointer;
        transition: transform 0.15s;
    }

    .color-option:hover {
        transform: scale(1.2);
    }

    .color-option.active {
        border-width: 4px;
    }

    /* Style untuk format teks di editor */
    #editor-content h1 { font-size: 2em; font-weight: bold; margin: 0.5em 0; }
    #editor-content h2 { font-size: 1.5em; font-weight: bold; margin: 0.5em 0; }
    #editor-content h3 { font-size: 1.2em; font-weight: bold; margin: 0.5em 0; }
    #editor-content p { margin: 0.5em 0; line-height: 1.6; }
    #editor-content small { font-size: 0.85em; opacity: 0.8; }

    .toolbar-btn {
        @apply w-9 h-9 flex items-center justify-center rounded-playful-sm border-2 border-dark bg-white hover:bg-secondary/40 text-dark transition-all shadow-[2px_2px_0_#080330] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none;
    }

    .toolbar-btn.active {
        @apply bg-primary border-dark text-black font-bold shadow-none translate-x-0.5 translate-y-0.5;
    }
</style>
@endsection

@section('content')
<div class="flex flex-col md:flex-row w-full h-full gap-4 p-3 md:p-6 rounded-playful-lg overflow-hidden">
    <!-- Left Sidebar: Kalender & Riwayat -->
    <div class="flex flex-col w-full md:w-[340px] min-w-[280px] h-full gap-4">
        <!-- Kalender Widget -->
        <div id="calendar-widget" class="p-4 bg-white border-2 border-dark rounded-playful-lg shadow-border-offset">
            <div class="flex items-center justify-between mb-4 pb-2 border-b-2 border-dark">
                <button id="prev-month-btn" class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-dark bg-gray-100 hover:bg-primary font-bold transition shadow-[2px_2px_0_#080330]" title="Bulan Sebelumnya">&larr;</button>
                <h2 id="calendar-title" class="text-xl font-extrabold text-dark text-center"></h2>
                <button id="next-month-btn" class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-dark bg-gray-100 hover:bg-primary font-bold transition shadow-[2px_2px_0_#080330]" title="Bulan Berikutnya">&rarr;</button>
            </div>
            
            <!-- Nama Hari -->
            <div class="grid grid-cols-7 gap-1 text-center font-extrabold text-xs text-dark/70 mb-2">
                <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
            </div>
            <!-- Grid Tanggal Kalender -->
            <div id="calendar-grid" class="grid grid-cols-7 gap-1 text-center"></div>
        </div>

        <!-- Sidebar Riwayat Jurnal -->
        <div class="flex-1 bg-white border-2 border-dark rounded-playful-lg shadow-border-offset flex flex-col overflow-hidden min-h-[300px]">
            <div class="flex items-center justify-between p-3.5 bg-primary border-b-2 border-dark">
                <h3 class="text-lg font-extrabold text-dark flex items-center gap-2">
                    <span>📖</span> Riwayat Jurnal
                </h3>
                <button id="new-note-btn" class="px-3 py-1.5 bg-secondary hover:bg-secondary/80 border-2 border-dark rounded-playful-md text-dark text-xs font-extrabold shadow-[2px_2px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex items-center gap-1">
                    <span>+</span> Baru
                </button>
            </div>

            <!-- List Jurnal Items -->
            <div id="history-list" class="flex-1 space-y-2.5 overflow-y-auto p-3 m-0">
                @forelse ($journals as $index => $item)
                    <div data-id="{{ $item->id }}" class="history-item {{ ($lastJournal && $lastJournal->id == $item->id) ? 'history-item-active' : '' }}">
                        <div class="flex flex-col flex-1 pr-2 overflow-hidden" onclick="loadJournal('{{ $item->id }}')">
                            <p class="text-sm font-extrabold text-dark truncate">
                                {{ $item->title ?: 'Tanpa Judul' }}
                            </p>
                            <span class="text-xs text-dark/70 font-semibold mt-0.5">
                                {{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                            </span>
                        </div>
                        <button onclick="deleteJournal('{{ $item->id }}', event)" class="delete-btn w-7 h-7 flex items-center justify-center rounded-full bg-red-100 hover:bg-red-500 hover:text-white border border-dark text-red-600 transition-all flex-shrink-0" title="Hapus Jurnal">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                @empty
                    <div id="empty-history-msg" class="text-center py-10 px-4 text-dark/60 font-semibold text-sm flex flex-col items-center">
                        <span class="text-3xl mb-2">📝</span>
                        <p>Belum ada jurnal tersimpan.</p>
                        <p class="text-xs mt-1">Klik "+ Baru" untuk menulis.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Area: Rich Text Editor Jurnal -->
    <div class="flex flex-col flex-1 h-full bg-white border-2 border-dark rounded-playful-lg shadow-border-offset p-5 lg:p-7 min-w-[300px]">
        <!-- Editor Header Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b-2 border-dark gap-2">
            <div class="flex flex-col flex-1 w-full">
                <input id="note-title" type="text" value="{{ $lastJournal ? $lastJournal->title : '' }}" placeholder="Tulis Judul Jurnal..." class="w-full text-2xl md:text-3xl font-extrabold text-dark bg-transparent focus:outline-none border-none p-0 placeholder:text-dark/40" />
            </div>
            <div class="flex items-center gap-2 text-xs md:text-sm text-dark/70 font-bold bg-secondary/30 px-3 py-1.5 border-2 border-dark rounded-playful-md whitespace-nowrap self-end sm:self-auto shadow-[2px_2px_0_#080330]">
                <span>🕒</span>
                <span id="note-time">{{ $lastJournal ? $lastJournal->updated_at->format('H:i') : '-' }}</span>
                <span>•</span>
                <span id="note-date">{{ $lastJournal ? $lastJournal->updated_at->translatedFormat('d F Y') : '-' }}</span>
            </div>
        </div>

        <!-- Area Editor Teks Utama -->
        <div class="flex-1 overflow-y-auto py-4">
            <div id="editor-content" contenteditable="true" data-journal-id="{{ $lastJournal ? $lastJournal->id : 0 }}" class="w-full h-full min-h-[350px] p-2 bg-transparent focus:outline-none text-dark text-base md:text-lg leading-relaxed" placeholder="Tulis pengalaman atau pikiranmu di sini...">
                {!! $lastJournal ? $lastJournal->content : '' !!}
            </div>
        </div>

        <!-- Editor Toolbar & Controls -->
        <div class="flex flex-wrap items-center justify-between pt-4 border-t-2 border-dark gap-3">
            <!-- Format Buttons -->
            <div class="flex flex-wrap items-center gap-2 text-dark">
                <!-- Dropdown Format (Heading) -->
                <div class="format-dropdown">
                    <button class="toolbar-btn" id="format-btn" title="Format Teks">
                        <i class="fas fa-heading"></i>
                    </button>
                    <div class="format-dropdown-content">
                        <button data-command="formatBlock" data-value="h1">Heading 1</button>
                        <button data-command="formatBlock" data-value="h2">Heading 2</button>
                        <button data-command="formatBlock" data-value="h3">Heading 3</button>
                        <button data-command="formatBlock" data-value="p">Paragraf</button>
                        <button data-command="formatBlock" data-value="small">Teks Kecil</button>
                    </div>
                </div>

                <!-- Color Picker -->
                <div class="color-dropdown">
                    <button class="toolbar-btn" id="color-btn" title="Warna Teks">
                        <i class="fas fa-palette"></i>
                    </button>
                    <div class="color-dropdown-content">
                        <div class="color-option" style="background-color: #080330;" data-value="#080330"></div>
                        <div class="color-option" style="background-color: #97C200;" data-value="#97C200"></div>
                        <div class="color-option" style="background-color: #EF4444;" data-value="#EF4444"></div>
                        <div class="color-option" style="background-color: #F59E0B;" data-value="#F59E0B"></div>
                        <div class="color-option" style="background-color: #3B82F6;" data-value="#3B82F6"></div>
                        <div class="color-option" style="background-color: #8B5CF6;" data-value="#8B5CF6"></div>
                        <div class="color-option" style="background-color: #6B7280;" data-value="#6B7280"></div>
                    </div>
                </div>

                <!-- Text Style Buttons -->
                <button class="toolbar-btn" data-command="bold" title="Cetak Tebal (Bold)"><i class="fas fa-bold"></i></button>
                <button class="toolbar-btn" data-command="italic" title="Cetak Miring (Italic)"><i class="fas fa-italic"></i></button>
                <button class="toolbar-btn" data-command="underline" title="Garis Bawah (Underline)"><i class="fas fa-underline"></i></button>
                <button class="toolbar-btn" data-command="strikeThrough" title="Coret (Strikethrough)"><i class="fas fa-strikethrough"></i></button>
                <button class="toolbar-btn" data-command="insertHorizontalRule" title="Garis Pembatas"><i class="fas fa-minus"></i></button>

                <!-- Alignment Buttons -->
                <div class="w-px h-6 bg-dark/20 mx-1"></div>
                <button class="toolbar-btn" data-command="justifyLeft" title="Rata Kiri"><i class="fas fa-align-left"></i></button>
                <button class="toolbar-btn" data-command="justifyCenter" title="Rata Tengah"><i class="fas fa-align-center"></i></button>
                <button class="toolbar-btn" data-command="justifyRight" title="Rata Kanan"><i class="fas fa-align-right"></i></button>
            </div>

            <!-- Save Action Button -->
            <div class="flex items-center gap-2">
                <button id="delete-current-btn" class="px-3.5 py-2 rounded-playful-md bg-red-100 hover:bg-red-500 hover:text-white border-2 border-dark text-red-600 font-extrabold text-xs shadow-[2px_2px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex items-center gap-1.5" title="Hapus Jurnal Ini">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
                <button id="save-journal-btn" class="py-2 px-5 bg-primary hover:bg-primary/90 text-dark font-extrabold rounded-playful-md border-2 border-dark shadow-[3px_3px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex items-center gap-2" title="Simpan Jurnal">
                    <i class="fas fa-check text-lg"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editorContent = document.getElementById("editor-content");
        const titleInput = document.getElementById("note-title");
        const noteTime = document.getElementById("note-time");
        const noteDate = document.getElementById("note-date");
        const historyList = document.getElementById("history-list");
        const saveBtn = document.getElementById("save-journal-btn");
        const newBtn = document.getElementById("new-note-btn");
        const deleteCurrentBtn = document.getElementById("delete-current-btn");

        // Data dari controller
        let currentMonth = {{ $month }};
        let currentYear = {{ $year }};
        let journaledDays = @json($journaledDays);

        // Helper Format DateTime
        function formatDateTime(isoString) {
            const date = new Date(isoString);
            const formattedDate = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
            const formattedTime = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            return { date: formattedDate, time: formattedTime };
        }

        // Render Kalender
        function renderCalendar(month, year) {
            const grid = document.getElementById("calendar-grid");
            const title = document.getElementById("calendar-title");

            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            title.textContent = `${monthNames[month - 1]} ${year}`;

            grid.innerHTML = "";

            const firstDay = new Date(year, month - 1, 1).getDay();
            const totalDays = new Date(year, month, 0).getDate();
            const today = new Date();

            // Cell kosong sebelum tanggal 1
            for (let i = 0; i < firstDay; i++) {
                grid.appendChild(document.createElement("div"));
            }

            for (let day = 1; day <= totalDays; day++) {
                const cell = document.createElement("div");
                cell.className = "relative flex justify-center items-center py-0.5";

                const isJournaled = journaledDays.includes(day);
                const isToday = (day === today.getDate() && month === (today.getMonth() + 1) && year === today.getFullYear());

                const circle = document.createElement("div");
                let classes = "calendar-day-circle ";

                if (isToday) {
                    classes += "active ";
                } else if (isJournaled) {
                    classes += "journaled ";
                } else {
                    classes += "bg-white text-dark ";
                }

                circle.className = classes;
                circle.textContent = day;

                cell.appendChild(circle);

                if (isJournaled && !isToday) {
                    const dot = document.createElement("div");
                    dot.className = "calendar-dot";
                    cell.appendChild(dot);
                }

                grid.appendChild(cell);
            }
        }

        // Navigasi Bulan Kalender
        document.getElementById("prev-month-btn").addEventListener("click", function() {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            window.location.href = `{{ route('user.journal') }}?month=${currentMonth}&year=${currentYear}`;
        });

        document.getElementById("next-month-btn").addEventListener("click", function() {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            window.location.href = `{{ route('user.journal') }}?month=${currentMonth}&year=${currentYear}`;
        });

        renderCalendar(currentMonth, currentYear);

        // Load Jurnal via AJAX
        window.loadJournal = async function(id) {
            try {
                const res = await fetch(`/journal/${id}`);
                const data = await res.json();

                if (data.success && data.data) {
                    const journal = data.data;
                    titleInput.value = journal.title;
                    editorContent.innerHTML = journal.content;
                    editorContent.setAttribute("data-journal-id", journal.id);

                    const dt = formatDateTime(journal.updated_at);
                    noteDate.textContent = dt.date;
                    noteTime.textContent = dt.time;

                    // Update active class pada list
                    document.querySelectorAll(".history-item").forEach(item => {
                        if (item.getAttribute("data-id") == journal.id) {
                            item.classList.add("history-item-active");
                        } else {
                            item.classList.remove("history-item-active");
                        }
                    });
                }
            } catch (err) {
                console.error("Gagal memuat jurnal:", err);
            }
        };

        // Hapus Jurnal via AJAX
        window.deleteJournal = async function(id, event) {
            if (event) event.stopPropagation();

            if (!confirm("Apakah Anda yakin ingin menghapus jurnal ini?")) return;

            try {
                const res = await fetch(`/journal/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                });

                const data = await res.json();

                if (data.success) {
                    const itemToRemove = document.querySelector(`.history-item[data-id="${id}"]`);
                    if (itemToRemove) itemToRemove.remove();

                    // Jika jurnal yang sedang dibuka dihapus, reset editor
                    if (editorContent.getAttribute("data-journal-id") == id) {
                        resetEditor();
                    }

                    // Tampilkan pesan kosong jika riwayat habis
                    if (historyList.querySelectorAll(".history-item").length === 0) {
                        historyList.innerHTML = `
                            <div id="empty-history-msg" class="text-center py-10 px-4 text-dark/60 font-semibold text-sm flex flex-col items-center">
                                <span class="text-3xl mb-2">📝</span>
                                <p>Belum ada jurnal tersimpan.</p>
                                <p class="text-xs mt-1">Klik "+ Baru" untuk menulis.</p>
                            </div>`;
                    }
                } else {
                    alert(data.message || "Gagal menghapus jurnal.");
                }
            } catch (err) {
                console.error(err);
                alert("Terjadi kesalahan koneksi saat menghapus jurnal.");
            }
        };

        // Reset Form Editor ke Jurnal Baru
        function resetEditor() {
            titleInput.value = "";
            titleInput.placeholder = "Judul Jurnal Baru...";
            editorContent.innerHTML = "";
            editorContent.setAttribute("data-journal-id", 0);
            noteTime.textContent = "-";
            noteDate.textContent = "-";

            document.querySelectorAll(".history-item").forEach(i => i.classList.remove("history-item-active"));
        }

        newBtn.addEventListener("click", resetEditor);

        deleteCurrentBtn.addEventListener("click", function() {
            const currentId = editorContent.getAttribute("data-journal-id");
            if (currentId && currentId != 0) {
                deleteJournal(currentId);
            } else {
                resetEditor();
            }
        });

        // Simpan / Edit Jurnal via AJAX
        saveBtn.addEventListener("click", async function() {
            const journalId = editorContent.getAttribute("data-journal-id") || 0;
            const title = titleInput.value.trim();
            const content = editorContent.innerHTML.trim();

            if (!title || !content || content === "<br>") {
                alert("Judul dan konten jurnal tidak boleh kosong!");
                return;
            }

            try {
                saveBtn.disabled = true;
                saveBtn.classList.add("opacity-70");

                const res = await fetch("{{ route('user.journal.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: journalId != 0 ? journalId : null,
                        title: title,
                        content: content
                    })
                });

                const result = await res.json();

                if (result.success && result.data) {
                    const journal = result.data;
                    editorContent.setAttribute("data-journal-id", journal.id);

                    const dt = formatDateTime(journal.updated_at);
                    noteDate.textContent = dt.date;
                    noteTime.textContent = dt.time;

                    // Hapus pesan kosong jika ada
                    const emptyMsg = document.getElementById("empty-history-msg");
                    if (emptyMsg) emptyMsg.remove();

                    // Cek apakah item sudah ada di sidebar
                    let existingItem = document.querySelector(`.history-item[data-id="${journal.id}"]`);

                    if (existingItem) {
                        // Update item yang ada
                        existingItem.querySelector("p").textContent = journal.title;
                    } else {
                        // Buat item baru di bagian paling atas
                        const newItem = document.createElement("div");
                        newItem.setAttribute("data-id", journal.id);
                        newItem.className = "history-item history-item-active";
                        newItem.innerHTML = `
                            <div class="flex flex-col flex-1 pr-2 overflow-hidden" onclick="loadJournal('${journal.id}')">
                                <p class="text-sm font-extrabold text-dark truncate">${journal.title}</p>
                                <span class="text-xs text-dark/70 font-semibold mt-0.5">${dt.date}</span>
                            </div>
                            <button onclick="deleteJournal('${journal.id}', event)" class="delete-btn w-7 h-7 flex items-center justify-center rounded-full bg-red-100 hover:bg-red-500 hover:text-white border border-dark text-red-600 transition-all flex-shrink-0" title="Hapus Jurnal">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        `;

                        document.querySelectorAll(".history-item").forEach(i => i.classList.remove("history-item-active"));
                        historyList.prepend(newItem);
                    }

                    // Tambahkan tanggal ke array kalender dan re-render
                    const dayNum = new Date(journal.created_at).getDate();
                    if (!journaledDays.includes(dayNum)) {
                        journaledDays.push(dayNum);
                        renderCalendar(currentMonth, currentYear);
                    }

                    // Ucapkan sukses tanpa dialog popup mengganggu
                    saveBtn.classList.add("bg-success");
                    setTimeout(() => saveBtn.classList.remove("bg-success"), 1500);
                } else {
                    alert(result.message || "Gagal menyimpan jurnal.");
                }
            } catch (err) {
                console.error(err);
                alert("Terjadi kesalahan saat menyimpan jurnal.");
            } finally {
                saveBtn.disabled = false;
                saveBtn.classList.remove("opacity-70");
            }
        });

        // Rich Text Editor Toolbar Commands
        const executeCommand = (command, value = null) => {
            document.execCommand('styleWithCSS', false, true);
            document.execCommand(command, false, value);
            editorContent.focus();
            updateToolbarState();
        };

        const closeAllDropdowns = () => {
            document.querySelectorAll('.format-dropdown-content, .color-dropdown-content').forEach(d => {
                d.style.display = 'none';
            });
        };

        // Format Dropdown
        const formatBtn = document.getElementById('format-btn');
        if (formatBtn) {
            formatBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const dropdown = formatBtn.nextElementSibling;
                const isVisible = dropdown.style.display === 'block';
                closeAllDropdowns();
                dropdown.style.display = isVisible ? 'none' : 'block';
            });
        }

        document.querySelectorAll('.format-dropdown-content button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const command = this.getAttribute('data-command');
                const value = this.getAttribute('data-value');
                executeCommand(command, value);
                closeAllDropdowns();
            });
        });

        // Color Dropdown
        const colorBtn = document.getElementById('color-btn');
        if (colorBtn) {
            colorBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const dropdown = colorBtn.nextElementSibling;
                const isVisible = dropdown.style.display === 'block';
                closeAllDropdowns();
                dropdown.style.display = isVisible ? 'none' : 'block';
            });
        }

        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                executeCommand('foreColor', value);
                closeAllDropdowns();
            });
        });

        // Toolbar Button Click Handling
        document.querySelectorAll('.toolbar-btn[data-command]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const command = button.getAttribute('data-command');
                if (command) executeCommand(command);
            });
        });

        // Update active status tombol toolbar saat kursor bergerak
        const updateToolbarState = () => {
            document.querySelectorAll('.toolbar-btn[data-command]').forEach(button => {
                const command = button.getAttribute('data-command');
                if (command && document.queryCommandSupported(command)) {
                    if (document.queryCommandState(command)) {
                        button.classList.add('active');
                    } else {
                        button.classList.remove('active');
                    }
                }
            });
        };

        editorContent.addEventListener('keyup', updateToolbarState);
        editorContent.addEventListener('mouseup', updateToolbarState);

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.format-dropdown') && !e.target.closest('.color-dropdown')) {
                closeAllDropdowns();
            }
        });
    });
</script>
@endsection
