@extends('layouts.app')

@section('title', 'Journaling')

@section('style')
<style>
    /* Tambahan styling untuk memoles detail seperti pada gambar */
    .calendar-day-circle {
        @apply w-6 h-6 md: w-8 md:h-8 flex justify-center items-center rounded-full border-2 border-dark cursor-pointer transition-colors text-xs md:text-sm font-semibold;
    }

    /* Efek hover untuk hari di kalender */
    .calendar-day-circle:hover {
        @apply border-primary text-primary bg-primary/20;
        /* Warna border dan teks berubah, latar belakang sedikit transparan */
    }

    /* Efek hover khusus untuk hari yang memiliki jurnal */
    .calendar-day-circle.journaled:hover {
        @apply bg-primary/40;
    }

    /* Efek untuk hari yang dipilih/aktif */
    .calendar-day-circle.active {
        @apply border-primary bg-primary text-white shadow-border-offset-accent-alt;
    }

    .calendar-dot {
        @apply w-2 h-2 rounded-full absolute -bottom-1;
    }

    /* Mengatur item aktif Riwayat agar terlihat "tenggelam" */
    .history-item-active {
        @apply bg-primary border-2 border-dark text-white shadow-none transform translate-x-1 translate-y-1;
    }

    /* Efek hover untuk item riwayat */
    .history-item:hover {
        @apply bg-gray-200 shadow-none transform translate-x-1 translate-y-1;
        /* Menggunakan shadow-none untuk menghilangkan bayangan saat hover */
    }

    /* Styling untuk dropdown format */
    .format-dropdown {
        position: relative;
        display: inline-block;
    }

    .format-dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        border: 2px solid #333;
        border-radius: 8px;
        min-width: 120px;
        box-shadow: 4px 4px 0 #333;
        z-index: 10;
        bottom: 100%;
        left: 0;
        margin-bottom: 8px;
    }

    .format-dropdown-content button {
        display: block;
        width: 100%;
        padding: 8px 12px;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .format-dropdown-content button:hover {
        background-color: #f0f0f0;
    }

    .format-dropdown:hover .format-dropdown-content {
        display: block;
    }

    /* Styling untuk color picker */
    .color-dropdown {
        position: relative;
        display: inline-block;
    }

    .color-dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        border: 2px solid #333;
        border-radius: 8px;
        width: 150px;
        box-shadow: 4px 4px 0 #333;
        z-index: 10;
        bottom: 100%;
        left: 0;
        margin-bottom: 8px;
        padding: 10px;
    }

    .color-option {
        width: 20px;
        height: 20px;
        border: 2px solid #333;
        border-radius: 50%;
        display: inline-block;
        margin: 4px;
        cursor: pointer;
    }

    /* Menambahkan visual untuk warna yang aktif */
    .color-option.active {
        border-width: 4px;
    }

    /* Style untuk format teks di editor */
    #editor-content h1 {
        font-size: 2em;
        font-weight: bold;
        margin: 0.67em 0;
    }

    #editor-content h2 {
        font-size: 1.5em;
        font-weight: bold;
        margin: 0.83em 0;
    }

    #editor-content h3 {
        font-size: 1.17em;
        font-weight: bold;
        margin: 1em 0;
    }

    #editor-content h4 {
        font-size: 1em;
        font-weight: bold;
        margin: 1.33em 0;
    }

    #editor-content h5 {
        font-size: 0.83em;
        font-weight: bold;
        margin: 1.67em 0;
    }

    #editor-content h6 {
        font-size: 0.67em;
        font-weight: bold;
        margin: 2.33em 0;
    }

    #editor-content small {
        font-size: 0.8em;
    }

    /* NEW STYLES: Header dengan warna dan efek shadow */
    .header-journal {
        @apply p-4 rounded-playful-lg;
        background-color: #f0f0f0;
        /* Warna latar belakang abu-abu terang */
        border: 2px solid #333;
        /* Border solid */
        box-shadow: 4px 4px 0 #333;
        /* Offset shadow */
    }

    /* NEW STYLES: Efek hover pada item riwayat */
    .history-item {
        @apply p-3 bg-gray-100 border-2 border-dark rounded-playful-md flex justify-between items-center cursor-pointer shadow-border-offset transition-all;
    }

    .history-item:not(.history-item-active):hover {
        @apply bg-gray-200 transform translate-x-1 translate-y-1 shadow-none;
    }

</style>
@endsection
@section('content')

<div class="flex flex-col md:flex-row w-full h-full gap-2 md:gap-4 p-2 md:p-4  rounded-playful-lg overflow-hidden  md:overflow-hidden">

    <div class=" flex flex-col w-full md:w-[350px] min-w-[280px] h-full gap-4">

        <div id="calendar" class="click-1 hidden md:block p-4 bg-white border-2 border-dark rounded-playful-lg shadow-border-offset">
            <h2 id="calendar-title" class="text-3xl font-extrabold text-dark text-center mb-6"></h2>
            <div id="calendar-grid" class="grid grid-cols-7 gap-2 text-center"></div>
        </div>

        <div class="click-1 flex-1  bg-white border-2 border-dark rounded-playful-lg shadow-border-offset flex flex-col overflow-hidden">
            <h3 class="text-xl font-bold border-b-2 border-dark text-center text-white mb-4 p-2 bg-primary">Riwayat</h3>
            <div class="flex-1 space-y-3 overflow-y-auto pr-2 p-4 m-0">
                @foreach ($journals as $item)
                <div data-id="{{ $item['id'] }}" class="p-3 bg-gray-100 border-2 border-dark rounded-playful-md flex justify-between items-start cursor-pointer shadow-border-offset hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all
     {{ $item['active'] ? 'history-item-active' : '' }}">

                    <div class="flex flex-col">
                        <p class="text-sm font-bold text-dark">
                            {{ $item['title'] ?? 'Tanpa Judul' }}
                        </p>
                        <span class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($item['updated_at'])->format('d M Y') }}
                        </span>
                    </div>
                </div>
                @endforeach

            </div>

            <div class=" mt-4 flex justify-between items-center px-4 pb-4">

                <div class="hover-1 py-2 px-4 bg-gray-200 border-2 border-dark rounded-full cursor-pointer hover:bg-gray-300 transition-colors shadow-border-offset">
                    <button id="new-note-btn" class="text-dark text-xs font-semibold">New</button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col flex-1 h-full bg-white border-2 border-dark rounded-playful-lg shadow-border-offset p-6  min-w-[300px] mb-5 md:mb-0">

        <div class="flex justify-between items-start pb-2 border-b-2 border-dark">
            <div class="flex flex-col">
                <input id="note-title" type="text" value="{{ $lastJournal ? $lastJournal->title : '' }}" placeholder="Judul Baru" class="text-2xl md:text-3xl font-bold text-dark bg-transparent focus:outline-none border-none p-0" />
            </div>
            <div class="flex flex-col items-end text-sm text-gray-500">
                <span id="note-time" class="text-sm">
                    {{ $lastJournal ? $lastJournal->updated_at->format('H:i') : '-' }}
                </span>
                <span id="note-date" class="text-sm">
                    {{ $lastJournal ? $lastJournal->updated_at->translatedFormat('d F, Y') : '-' }}
                </span>
            </div>
        </div>


        <div class="flex-1 overflow-y-auto p-2">
            <div id="editor-content" contenteditable="true" data-journal-id="{{ $lastJournal ? $lastJournal->id : 0 }}" class="w-full h-full p-0 bg-transparent focus:outline-none text-dark text-base md:text-lg min-h-[50vh]" placeholder="Tulis jurnal Anda di sini...">
                {!! $lastJournal ? $lastJournal->content : '' !!}
            </div>
        </div>


        <div class="flex items-center justify-between p-3 mt-4 border-t-2 border-dark">
            <div class="flex space-x-4 text-xl text-dark">
                <div class="format-dropdown">
                    <button class="toolbar-btn" title="Format Teks">
                        <i class="fas fa-heading"></i>
                    </button>
                    <div class="format-dropdown-content">
                        <button data-command="formatBlock" data-value="h1">Heading 1</button>
                        <button data-command="formatBlock" data-value="h2">Heading 2</button>
                        <button data-command="formatBlock" data-value="h3">Heading 3</button>
                        <button data-command="formatBlock" data-value="h4">Heading 4</button>
                        <button data-command="formatBlock" data-value="h5">Heading 5</button>
                        <button data-command="formatBlock" data-value="h6">Heading 6</button>
                        <button data-command="formatBlock" data-value="p">Paragraf</button>
                        <button data-command="formatBlock" data-value="small">Kecil</button>
                    </div>
                </div>

                <div class="color-dropdown hidden">
                    <button class="toolbar-btn" id="color-btn" title="Warna Teks">
                        <i class="fas fa-palette"></i>
                    </button>
                    <div class="color-dropdown-content">
                        <div class="color-option" style="background-color: #FF0000;" data-value="#FF0000"></div>
                        <div class="color-option" style="background-color: #FF6600;" data-value="#FF6600"></div>
                        <div class="color-option" style="background-color: #FFCC00;" data-value="#FFCC00"></div>
                        <div class="color-option" style="background-color: #00CC00;" data-value="#00CC00"></div>
                        <div class="color-option" style="background-color: #0066FF;" data-value="#0066FF"></div>
                        <div class="color-option" style="background-color: #6600CC;" data-value="#6600CC"></div>
                        <div class="color-option" style="background-color: #000000;" data-value="#000000"></div>
                        <div class="color-option" style="background-color: #666666;" data-value="#666666"></div>
                        <div class="color-option" style="background-color: #999999;" data-value="#999999"></div>
                        <div class="color-option" style="background-color: #FFFFFF; border: 2px solid #333;" data-value="#FFFFFF"></div>
                    </div>
                </div>

                <button class="toolbar-btn" data-command="bold" id="btn-bold" title="Bold"><i class="fas fa-bold"></i></button>
                <button class="toolbar-btn" data-command="italic" id="btn-italic" title="Italic"><i class="fas fa-italic"></i></button>
                <button class="toolbar-btn" data-command="underline" id="btn-underline" title="Underline"><i class="fas fa-underline"></i></button>
                <button class="toolbar-btn" data-command="strikeThrough" id="btn-strike" title="Strikethrough"><i class="fas fa-strikethrough"></i></button>
                <button class="toolbar-btn" data-command="insertHorizontalRule" title="Horizontal Rule"><i class="fas fa-minus"></i></button>
            </div>

            <button id="save-journal-btn" class="w-12 h-12 flex justify-center items-center bg-primary border-2 border-dark rounded-full shadow-border-offset-accent click-1">
                <i class="fas fa-check text-dark text-xl"></i>
            </button>
        </div>
    </div>
</div>
</div>
</div>

@endsection


@section('script')
<script>
    const contentDiv = document.getElementById("editor-content");
    const titleInput = document.getElementById("note-title");
    const noteTime = document.getElementById("note-time");
    const noteDate = document.getElementById("note-date");

    function formatDateTime(isoString) {
        const date = new Date(isoString);

        const optionsDate = {
            day: '2-digit'
            , month: 'long'
            , year: 'numeric'
        };
        const optionsTime = {
            hour: '2-digit'
            , minute: '2-digit'
        };

        const formattedDate = date.toLocaleDateString('id-ID', optionsDate);
        const formattedTime = date.toLocaleTimeString('id-ID', optionsTime);

        return {
            date: formattedDate
            , time: formattedTime
        };
    }

    document.getElementById("save-journal-btn").addEventListener("click", async function() {
        const journalId = contentDiv.getAttribute("data-journal-id") || 0;
        const title = titleInput.value.trim();
        const content = contentDiv.innerHTML.trim();

        if (!title || !content) {
            alert("Judul dan konten tidak boleh kosong!");
            return;
        }

        try {
            const response = await fetch("{{ route('user.journal.store') }}", {
                method: "POST"
                , headers: {
                    "Content-Type": "application/json"
                    , "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
                , body: JSON.stringify({
                    id: journalId != 0 ? journalId : null
                    , title: title
                    , content: content
                })
            });

            const result = await response.json();

            if (result.success) {
                // alert(result.message);

                // update id ke element editor
                if (result.data && result.data.id) {
                    contentDiv.setAttribute("data-journal-id", result.data.id);
                }

                // Format tanggal (misalnya "Today" atau "18 Sep 2025")
                const today = new Date();
                const options = {
                    day: "2-digit"
                    , month: "short"
                    , year: "numeric"
                };
                const formattedDate = today.toLocaleDateString("en-GB", options); // ex: "18 Sep 2025"
                const {
                    date
                    , time
                } = formatDateTime(result.data.updated_at);

                noteDate.innerHTML = date; // contoh: 18 September 2025
                noteTime.innerHTML = time; // contoh: 16.28
                // buat elemen baru untuk riwayat
                const historyContainer = document.querySelector(".space-y-3");
                const newHistoryItem = document.createElement("div");
                newHistoryItem.className =
                    "p-3 bg-gray-100 border-2 border-dark rounded-playful-md flex justify-between items-center cursor-pointer shadow-border-offset hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all history-item-active";
                newHistoryItem.innerHTML = `
                <p class="text-sm font-medium">${title}</p>
                <span class="text-xs text-white/80">${formattedDate}</span>
            `;

                // hapus dulu active di item lain
                historyContainer.querySelectorAll(".history-item-active").forEach(el => {
                    el.classList.remove("history-item-active");
                    const dateSpan = el.querySelector("span");
                    if (dateSpan) dateSpan.classList.remove("text-white/80");
                    if (dateSpan) dateSpan.classList.add("text-gray-500");
                });

                // prepend ke atas list (biar entry terbaru muncul pertama)
                historyContainer.prepend(newHistoryItem);
            } else {
                alert("Gagal menyimpan jurnal.");
            }

        } catch (error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat menyimpan jurnal.");
        }
    });

    document.getElementById("new-note-btn").addEventListener("click", function() {
        // Reset judul
        const titleInput = document.getElementById("note-title");
        titleInput.value = "";
        titleInput.placeholder = "Judul Baru";

        // Reset tanggal & waktu
        document.getElementById("note-time").textContent = "-";
        document.getElementById("note-date").textContent = "-";

        // Kosongkan isi editor
        const editor = document.getElementById("editor-content");
        editor.innerHTML = "";
        editor.setAttribute("data-journal-id", 0);
    });











    document.addEventListener('DOMContentLoaded', function() {
        const editorContent = document.getElementById('editor-content');
        const toolbarButtons = document.querySelectorAll('.toolbar-btn');
        const formatDropdown = document.querySelector('.format-dropdown');
        const formatButtons = document.querySelectorAll('.format-dropdown-content button');
        const colorDropdown = document.querySelector('.color-dropdown');
        const colorOptions = document.querySelectorAll('.color-option');
        const checkButton = document.querySelector('.fa-check').closest('button');
        const colorBtn = document.getElementById('color-btn');

        // Helper function to execute a command and refocus
        const executeCommand = (command, value = null) => {
            document.execCommand('styleWithCSS', false, true);
            document.execCommand(command, false, value);
            editorContent.focus();
        };

        // Helper function to close all dropdowns
        const closeAllDropdowns = () => {
            document.querySelectorAll('.format-dropdown-content, .color-dropdown-content').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        };

        // Toggle dropdowns on click
        formatDropdown.querySelector('.toolbar-btn').addEventListener('click', (e) => {
            e.stopPropagation();
            const dropdownContent = formatDropdown.querySelector('.format-dropdown-content');
            closeAllDropdowns();
            dropdownContent.style.display = 'block';
        });

        colorDropdown.querySelector('.toolbar-btn').addEventListener('click', (e) => {
            e.stopPropagation();
            const dropdownContent = colorDropdown.querySelector('.color-dropdown-content');
            closeAllDropdowns();
            dropdownContent.style.display = 'block';
        });

        // Add event listeners for format buttons
        formatButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const command = this.getAttribute('data-command');
                const value = this.getAttribute('data-value');
                if (command) {
                    executeCommand(command, value);
                }
                closeAllDropdowns();
            });
        });

        // Add event listeners for color options
        colorOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                executeCommand('foreColor', value);
                closeAllDropdowns();
                updateToolbarState(); // Perbarui status toolbar setelah memilih warna
            });
        });

        // Event listeners for toolbar buttons (bold, italic, etc.)
        toolbarButtons.forEach(button => {
            const command = button.getAttribute('data-command');
            if (command && command !== 'formatBlock' && command !== 'foreColor') {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    executeCommand(command);
                });
            }
        });

        // Update toolbar state based on cursor position
        const updateToolbarState = () => {
            // Update bold, italic, underline state
            toolbarButtons.forEach(button => {
                const command = button.getAttribute('data-command');
                if (command && document.queryCommandSupported(command)) {
                    if (document.queryCommandState(command)) {
                        button.classList.add('text-primary');
                    } else {
                        button.classList.remove('text-primary');
                    }
                }
            });

            // Update color button state
            const currentColor = document.queryCommandValue('foreColor').toLowerCase();
            const hexColor = rgbToHex(currentColor);

            // Hapus class 'active' dari semua opsi warna
            colorOptions.forEach(option => option.classList.remove('active'));

            // Tambahkan class 'active' ke opsi warna yang cocok
            const activeOption = document.querySelector(`.color-option[data-value="${hexColor.toUpperCase()}"]`);
            if (activeOption) {
                activeOption.classList.add('active');
                colorBtn.style.color = hexColor;
            } else {
                colorBtn.style.color = 'initial'; // Reset ke warna default jika tidak ada kecocokan
            }
        };

        // Helper function to convert RGB to Hex
        function rgbToHex(rgb) {
            if (rgb.indexOf('rgb') === -1) {
                return rgb;
            }
            const match = /rgb\((\d+),\s*(\d+),\s*(\d+)\)/.exec(rgb);
            if (!match) return rgb;
            const r = parseInt(match[1]).toString(16).padStart(2, '0');
            const g = parseInt(match[2]).toString(16).padStart(2, '0');
            const b = parseInt(match[3]).toString(16).padStart(2, '0');
            return `#${r}${g}${b}`.toUpperCase();
        }

        editorContent.addEventListener('keyup', updateToolbarState);
        editorContent.addEventListener('mouseup', updateToolbarState);
        editorContent.addEventListener('focus', updateToolbarState);

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.format-dropdown') && !e.target.closest('.color-dropdown')) {
                closeAllDropdowns();
            }
        });

        // Optional: Add a simple click handler for the save button
        checkButton.addEventListener('click', () => {
            const journalTitle = document.querySelector('input[type="text"]').value;
            const journalContent = editorContent.innerHTML;
            console.log("Journal Title:", journalTitle);
            console.log("Journal Content:", journalContent);
            // alert("Journal saved! (Check console for data)");
        });
        const historyContainer = document.querySelector(".space-y-3");

        // delegasi klik biar jalan juga untuk item baru
        historyContainer.addEventListener("click", async function(e) {
            const item = e.target.closest("div.p-3"); // klik wrapper item
            if (!item) return;

            // ambil id journal dari data-id
            const journalId = item.getAttribute("data-id");
            if (!journalId) return;

            try {
                const response = await fetch(`/journal/${journalId}`);
                const result = await response.json();

                if (result.success) {
                    const journal = result.data;

                    // set ke editor
                    editorContent.innerHTML = journal.content;
                    editorContent.setAttribute("data-journal-id", journal.id);
                    titleInput.value = journal.title;

                    // update active class
                    historyContainer.querySelectorAll("div.p-3").forEach(el => {
                        el.classList.remove("history-item-active");
                        const span = el.querySelector("span");
                        if (span) {
                            span.classList.remove("text-white/80");
                            span.classList.add("text-gray-500");
                        }
                    });
                    item.classList.add("history-item-active");
                    const span = item.querySelector("span");
                    if (span) {
                        span.classList.remove("text-gray-500");
                        span.classList.add("text-white/80");
                    }
                    const {
                        date
                        , time
                    } = formatDateTime(result.data.updated_at);

                    noteDate.innerHTML = date; // contoh: 18 September 2025
                    noteTime.innerHTML = time; // contoh: 16.28
                } else {
                    alert("Gagal mengambil data jurnal.");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat mengambil jurnal.");
            }
        });
        // Initial state update
        updateToolbarState();
        const grid = document.getElementById("calendar-grid");
        const title = document.getElementById("calendar-title");

        // --- Data kalender ---
        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth(); // 0 = Januari
        const activeDay = today.getDate();

        // Nama bulan
        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni"
            , "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Hitung jumlah hari dalam bulan
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        // Hari pertama bulan (0 = Minggu, 6 = Sabtu)
        const startDay = new Date(currentYear, currentMonth, 1).getDay();

        // Dummy data jurnal (nanti bisa ambil dari backend)
        const journaledDays = [3, 4, 5, 8, 9, 10];

        // --- Render judul kalender ---
        title.textContent = `${monthNames[currentMonth]} ${currentYear}`;

        // Kosongkan grid
        grid.innerHTML = "";

        // Tambahkan slot kosong sebelum tanggal 1
        for (let i = 0; i < startDay; i++) {
            const emptyCell = document.createElement("div");
            grid.appendChild(emptyCell);
        }

        // Render tanggal
        for (let day = 1; day <= daysInMonth; day++) {
            const cell = document.createElement("div");
            cell.className = "relative flex justify-center items-center";

            const isJournaled = journaledDays.includes(day);
            const isActive = day === activeDay;

            // Lingkaran tanggal
            const dayCircle = document.createElement("div");
            dayCircle.className = `calendar-day-circle ${
                isJournaled
                    ? isActive
                        ? "border-primary bg-white"
                        : "border-dark bg-white"
                    : "bg-white border-gray-300"
            } hover:border-primary hover:text-primary`;
            dayCircle.textContent = day;

            cell.appendChild(dayCircle);

            // Dot indikator kalau ada jurnal
            if (isJournaled) {
                const dot = document.createElement("div");
                dot.className = "calendar-dot bg-primary";
                cell.appendChild(dot);
            }

            grid.appendChild(cell);
        }
    });

</script>
@endsection
