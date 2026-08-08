let currentDate = new Date();

function getHistory(year, month) {
    const history = {
        year: year,
        month: month
    };
    
    fetch(`/historySearch`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(history)
    })
    .then(response => response.json())
    .then(data => {
        console.log('History data:', data);
        markDaysWithEntries(data, year, month);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function markDaysWithEntries(data, year, month) {
    // Hapus semua tanda sebelumnya
    document.querySelectorAll('.has-entry').forEach(el => {
        el.classList.remove('has-entry');
    });
    document.querySelectorAll('.indicators-container').forEach(el => {
        el.remove();
    });
    
    // Buat container untuk indikator di setiap hari
    document.querySelectorAll('.calendar-day').forEach(cell => {
        const indicatorsContainer = document.createElement('div');
        indicatorsContainer.classList.add('indicators-container');
        cell.appendChild(indicatorsContainer);
    });
    
    // Tambahkan indikator untuk post
    if (data.post && data.post.length > 0) {
        data.post.forEach(day => {
            const dayCell = document.querySelector(`[data-day="${day}"][data-month="${month}"][data-year="${year}"]`);
            
            if (dayCell) {
                dayCell.classList.add('has-entry');
                
                const indicatorsContainer = dayCell.querySelector('.indicators-container');
                const indicator = document.createElement('div');
                indicator.classList.add('entry-indicator', 'post-indicator');
                indicator.title = 'Post';
                indicatorsContainer.appendChild(indicator);
            }
        });
    }
    
    // Tambahkan indikator untuk jurnal
    if (data.jurnal && data.jurnal.length > 0) {
        data.jurnal.forEach(day => {
            const dayCell = document.querySelector(`[data-day="${day}"][data-month="${month}"][data-year="${year}"]`);
            
            if (dayCell) {
                dayCell.classList.add('has-entry');
                
                const indicatorsContainer = dayCell.querySelector('.indicators-container');
                const indicator = document.createElement('div');
                indicator.classList.add('entry-indicator', 'jurnal-indicator');
                indicator.title = 'Jurnal';
                indicatorsContainer.appendChild(indicator);
            }
        });
    }
}

// Fungsi untuk generate kalender
function generateCalendar(year, month) {
    // Panggil fungsi untuk mendapatkan history
    getHistory(year, month + 1);
    
    const calendarBody = document.getElementById('calendarBody');
    const monthName = document.getElementById('monthName');
    const yearDisplay = document.getElementById('yearDisplay');
    calendarBody.innerHTML = ''; // Clear calendar sebelumnya

    const today = new Date();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();
    const currentDay = today.getDate();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();

    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    monthName.textContent = monthNames[month];
    yearDisplay.textContent = year;

    let startingDay = firstDay === 0 ? 6 : firstDay - 1; // Adjust for Monday as first day
    let day = 1;

    // Create calendar rows
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');
        
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            
            if (i === 0 && j < startingDay) {
                // Empty cells before the first day
                cell.innerHTML = '';
            } else if (day > daysInMonth) {
                // Empty cells after the last day
                cell.innerHTML = '';
            } else {
                // Create day element
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('tanggal-calendar');
                dayDiv.textContent = day;
                
                // Add data attributes for easier selection
                cell.setAttribute('data-day', day);
                cell.setAttribute('data-month', month + 1);
                cell.setAttribute('data-year', year);
                
                cell.appendChild(dayDiv);
                cell.classList.add('calendar-day');
                
                // Buat container untuk indikator
                const indicatorsContainer = document.createElement('div');
                indicatorsContainer.classList.add('indicators-container');
                cell.appendChild(indicatorsContainer);
                
                // Highlight today
                if (day === currentDay && month === currentMonth && year === currentYear) {
                    cell.classList.add('today');
                }
                
                // Add click event to each day
                cell.addEventListener('click', function() {
                    selectDay(this, day, month + 1, year);
                });
                
                day++;
            }
            
            row.appendChild(cell);
        }
        
        calendarBody.appendChild(row);
        
        // Stop creating rows if we've displayed all days
        if (day > daysInMonth) {
            break;
        }
    }
}

function selectDay(cell, day, month, year) {
    // Remove selection from all cells
    document.querySelectorAll('.calendar-day').forEach(c => {
        c.classList.remove('selected');
    });
    
    // Add selection to clicked cell
    cell.classList.add('selected');
    
    // You can add functionality here to show events for the selected day
    console.log(`Selected: ${day}/${month}/${year}`);
    
    // Example: Show a modal or update another part of the UI
    // showDayEvents(day, month, year);
}

// Initialize the calendar
function initCalendar() {
    populateYearSelect();
    generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
    
    // Add event listeners
    document.getElementById('prevMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
    });

    document.getElementById('nextMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
    });

    // Year dropdown functionality
    const yearDisplay = document.getElementById('yearDisplay');
    const yearDropdown = document.getElementById('yearDropdown');
    
    yearDisplay.addEventListener('click', function(e) {
        e.stopPropagation();
        yearDropdown.style.display = yearDropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.getElementById('yearSelect').addEventListener('change', function() {
        const selectedYear = parseInt(this.value);
        currentDate.setFullYear(selectedYear);
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        yearDropdown.style.display = 'none';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.month-year')) {
            yearDropdown.style.display = 'none';
        }
    });
}

// Populate year dropdown
function populateYearSelect() {
    const yearSelect = document.getElementById('yearSelect');
    const currentYear = new Date().getFullYear();
    
    // Clear existing options
    yearSelect.innerHTML = '';
    
    for (let i = currentYear - 10; i <= currentYear + 10; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        yearSelect.appendChild(option);
    }
    
    yearSelect.value = currentDate.getFullYear();
}

// Run when document is loaded
document.addEventListener('DOMContentLoaded', function() {
    initCalendar();
});

// Optional: Add keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        // Previous month
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
    } else if (e.key === 'ArrowRight') {
        // Next month
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
    }
});