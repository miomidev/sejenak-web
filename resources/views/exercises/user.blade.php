@extends('layouts.app')

@section('title', 'Exercise untuk Meringankan Stress')

@section('content')
<div id="main-exercise-page" class="w-full h-full flex flex-col bg-background md:px-8 lg:px-12 font-main">

    <!-- Header Section -->
    <div class="flex flex-row h-full overflow-hidden">
        <!-- Exercise Categories Grid -->
        <div class="flex flex-col gap-6 mb-8 p-3 h-full overflow-scroll">
        <div class="hidden md:block mb-8">
            <h1 class="text-h3 md:text-h2 text-dark font-bold mb-2">Exercise untuk Meringankan Stress</h1>
            <p class="text-gray-600">Pilih teknik yang sesuai untuk membantu menenangkan pikiran dan mengurangi kecemasan</p>
        </div>
        <!-- Grounding Techniques Card -->
        <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center mr-4">
                    <i class="fas fa-mountain text-dark text-xl"></i>
                </div>
                <h3 class="text-h5 text-dark font-bold">Grounding Techniques</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Teknik untuk membantu fokus ke saat ini dan mengurangi kecemasan atau panik.</p>
            <button class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center exercise-btn" data-type="grounding">
                <i class="fas fa-play mr-2"></i> Mulai Exercise
            </button>
        </div>

        <!-- Breathing Exercises Card -->
        <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center mr-4">
                    <i class="fas fa-wind text-dark text-xl"></i>
                </div>
                <h3 class="text-h5 text-dark font-bold">Pernapasan / Breathing</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Latihan pernapasan untuk menenangkan sistem saraf dan menurunkan detak jantung.</p>
            <button class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center exercise-btn" data-type="breathing">
                <i class="fas fa-play mr-2"></i> Mulai Exercise
            </button>
        </div>

        <!-- Mindfulness & Meditation Card -->
        <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                    <i class="fas fa-spa text-dark text-xl"></i>
                </div>
                <h3 class="text-h5 text-dark font-bold">Mindfulness & Meditation</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Meningkatkan fokus dan mengurangi overthinking melalui meditasi.</p>
            <button class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center exercise-btn" data-type="mindfulness">
                <i class="fas fa-play mr-2"></i> Mulai Exercise
            </button>
        </div>

        <!-- Relaksasi Card -->
        <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center mr-4">
                    <i class="fas fa-cloud text-dark text-xl"></i>
                </div>
                <h3 class="text-h5 text-dark font-bold">Relaksasi</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Teknik untuk melepas ketegangan fisik dan mental.</p>
            <button class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center exercise-btn" data-type="relaxation">
                <i class="fas fa-play mr-2"></i> Mulai Exercise
            </button>
        </div>

        <!-- Aktivitas Fisik Card -->
        <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center mr-4">
                    <i class="fas fa-running text-dark text-xl"></i>
                </div>
                <h3 class="text-h5 text-dark font-bold">Aktivitas Fisik Ringan</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Meningkatkan hormon bahagia dan mengurangi stres dengan gerakan ringan.</p>
            <button class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center exercise-btn" data-type="physical">
                <i class="fas fa-play mr-2"></i> Mulai Exercise
            </button>
        </div>

        <!-- Journaling Card -->
        <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                    <i class="fas fa-book text-dark text-xl"></i>
                </div>
                <h3 class="text-h5 text-dark font-bold">Journaling & Cognitive</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Ekspresikan emosi dan refleksi diri melalui tulisan.</p>
            <a href="{{ route('user.journal') }}" class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center block">
                <i class="fas fa-pen mr-2"></i> Buka Journal
            </a>
        </div>
    </div>

    <!-- Exercise Simulation Area (Initially Hidden) -->
    <div id="exercise-simulation" class="hidden md:block fixed md:block h-full md:h-auto w-full max-w-2xl mx-auto my-3 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 id="exercise-title" class="text-h4 text-dark font-bold"></h2>
            <button id="close-exercise" class="click-1 w-10 h-10 rounded-full bg-white text-dark flex items-center justify-center border-2 border-dark shadow-border-offset">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="exercise-content" class="flex flex-col items-center">
            <!-- Content will be dynamically loaded based on exercise type -->
        </div>
    </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exerciseBtns = document.querySelectorAll('.exercise-btn');
        const exerciseSimulation = document.getElementById('exercise-simulation');
        const exerciseTitle = document.getElementById('exercise-title');
        const exerciseContent = document.getElementById('exercise-content');
        const closeExerciseBtn = document.getElementById('close-exercise');

        // Close exercise simulation
        closeExerciseBtn.addEventListener('click', function() {
            exerciseSimulation.classList.add('hidden');
        });

        // Handle exercise button clicks
        exerciseBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const exerciseType = this.getAttribute('data-type');
                loadExercise(exerciseType);
                exerciseSimulation.classList.remove('hidden');
            });
        });

        // Load exercise based on type
        function loadExercise(type) {
            // Clear previous content
            exerciseContent.innerHTML = '';

            switch(type) {
                case 'grounding':
                    loadGroundingExercise();
                    break;
                case 'breathing':
                    loadBreathingExercise();
                    break;
                case 'mindfulness':
                    loadMindfulnessExercise();
                    break;
                case 'relaxation':
                    loadRelaxationExercise();
                    break;
                case 'physical':
                    loadPhysicalExercise();
                    break;
            }
        }

        // Grounding Exercise - 5-4-3-2-1 Technique
        function loadGroundingExercise() {
            exerciseTitle.textContent = 'Grounding Techniques - 5-4-3-2-1';

            const steps = [
                { number: 5, text: 'hal yang bisa Anda lihat' },
                { number: 4, text: 'hal yang bisa Anda sentuh' },
                { number: 3, text: 'hal yang bisa Anda dengar' },
                { number: 2, text: 'hal yang bisa Anda cium' },
                { number: 1, text: 'hal yang bisa Anda rasakan' }
            ];

            let currentStep = 0;

            const container = document.createElement('div');
            container.className = 'w-full text-center';

            const stepDisplay = document.createElement('div');
            stepDisplay.className = 'mb-8';

            const numberCircle = document.createElement('div');
            numberCircle.className = 'w-32 h-32 rounded-full bg-primary flex items-center justify-center mx-auto mb-6 border-4 border-dark';

            const numberText = document.createElement('span');
            numberText.className = 'text-h1 font-bold text-dark';
            numberText.textContent = steps[currentStep].number;
            numberCircle.appendChild(numberText);

            const instruction = document.createElement('p');
            instruction.className = 'text-h5 text-dark font-bold mb-2';
            instruction.textContent = `Cari ${steps[currentStep].text}`;

            const description = document.createElement('p');
            description.className = 'text-gray-600 mb-6';
            description.textContent = 'Fokus pada sensasi dan perhatikan detailnya';

            const nextBtn = document.createElement('button');
            nextBtn.className = 'click-1 px-6 py-3 bg-secondary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent';
            nextBtn.innerHTML = '<i class="fas fa-arrow-right mr-2"></i> Selanjutnya';

            stepDisplay.appendChild(numberCircle);
            stepDisplay.appendChild(instruction);
            stepDisplay.appendChild(description);

            container.appendChild(stepDisplay);
            container.appendChild(nextBtn);
            exerciseContent.appendChild(container);

            nextBtn.addEventListener('click', function() {
                currentStep++;
                if (currentStep < steps.length) {
                    numberText.textContent = steps[currentStep].number;
                    instruction.textContent = `Cari ${steps[currentStep].text}`;
                } else {
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-6xl text-primary mb-4"></i>
                            <h3 class="text-h4 text-dark font-bold mb-2">Exercise Selesai!</h3>
                            <p class="text-gray-600 mb-6">Anda telah menyelesaikan teknik grounding 5-4-3-2-1</p>
                            <button class="click-1 px-6 py-3 bg-primary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent close-exercise">
                                Tutup
                            </button>
                        </div>
                    `;

                    document.querySelector('.close-exercise').addEventListener('click', function() {
                        exerciseSimulation.classList.add('hidden');
                    });
                }
            });
        }

        // Breathing Exercise - Animated Circle
        function loadBreathingExercise() {
            exerciseTitle.textContent = 'Latihan Pernapasan - Box Breathing';

            const container = document.createElement('div');
            container.className = 'w-full text-center';

            const instructions = document.createElement('div');
            instructions.className = 'mb-6';

            const instructionText = document.createElement('p');
            instructionText.className = 'text-h5 text-dark font-bold mb-2';
            instructionText.textContent = 'Tarik Napas';
            instructionText.id = 'breath-instruction';

            const countdownText = document.createElement('p');
            countdownText.className = 'text-gray-600 mb-4';
            countdownText.id = 'breath-countdown';
            countdownText.textContent = '4 detik';

            instructions.appendChild(instructionText);
            instructions.appendChild(countdownText);

            const circleContainer = document.createElement('div');
            circleContainer.className = 'relative w-64 h-64 mx-auto mb-8';

            const breathingCircle = document.createElement('div');
            breathingCircle.id = 'breathing-circle';
            breathingCircle.className = 'w-full h-full rounded-full bg-primary border-4 border-dark flex items-center justify-center transition-all duration-4000 ease-in-out';

            const circleText = document.createElement('span');
            circleText.className = 'text-dark text-h4 font-bold';
            circleText.id = 'circle-text';
            circleText.textContent = '4';

            breathingCircle.appendChild(circleText);
            circleContainer.appendChild(breathingCircle);

            const controls = document.createElement('div');
            controls.className = 'flex justify-center space-x-4';

            const startBtn = document.createElement('button');
            startBtn.className = 'click-1 px-6 py-3 bg-primary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent';
            startBtn.innerHTML = '<i class="fas fa-play mr-2"></i> Mulai';
            startBtn.id = 'start-breathing';

            const pauseBtn = document.createElement('button');
            pauseBtn.className = 'click-1 px-6 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset';
            pauseBtn.innerHTML = '<i class="fas fa-pause mr-2"></i> Jeda';
            pauseBtn.id = 'pause-breathing';
            pauseBtn.disabled = true;

            const resetBtn = document.createElement('button');
            resetBtn.className = 'click-1 px-6 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset';
            resetBtn.innerHTML = '<i class="fas fa-redo mr-2"></i> Ulangi';
            resetBtn.id = 'reset-breathing';

            controls.appendChild(startBtn);
            controls.appendChild(pauseBtn);
            controls.appendChild(resetBtn);

            container.appendChild(instructions);
            container.appendChild(circleContainer);
            container.appendChild(controls);
            exerciseContent.appendChild(container);

            // Breathing exercise logic
            let isBreathing = false;
            let isPaused = false;
            let breathPhase = 0; // 0: inhale, 1: hold after inhale, 2: exhale, 3: hold after exhale
            let countdown = 4;
            let breathInterval;

            const phases = [
                { instruction: 'Tarik Napas', duration: 4000 },
                { instruction: 'Tahan Napas', duration: 4000 },
                { instruction: 'Buang Napas', duration: 4000 },
                { instruction: 'Tahan Napas', duration: 4000 }
            ];

            function startBreathing() {
                isBreathing = true;
                isPaused = false;
                startBtn.disabled = true;
                pauseBtn.disabled = false;
                resetBtn.disabled = false;

                breathInterval = setInterval(updateBreathing, 1000);
                updateBreathingVisual();
            }

            function pauseBreathing() {
                isPaused = !isPaused;
                if (isPaused) {
                    clearInterval(breathInterval);
                    pauseBtn.innerHTML = '<i class="fas fa-play mr-2"></i> Lanjutkan';
                } else {
                    breathInterval = setInterval(updateBreathing, 1000);
                    pauseBtn.innerHTML = '<i class="fas fa-pause mr-2"></i> Jeda';
                }
            }

            function resetBreathing() {
                clearInterval(breathInterval);
                isBreathing = false;
                isPaused = false;
                breathPhase = 0;
                countdown = 4;

                startBtn.disabled = false;
                pauseBtn.disabled = true;
                pauseBtn.innerHTML = '<i class="fas fa-pause mr-2"></i> Jeda';
                resetBtn.disabled = true;

                document.getElementById('breath-instruction').textContent = 'Tarik Napas';
                document.getElementById('breath-countdown').textContent = '4 detik';
                document.getElementById('circle-text').textContent = '4';
                breathingCircle.style.transform = 'scale(1)';
            }

            function updateBreathing() {
                if (!isPaused) {
                    countdown--;
                    document.getElementById('breath-countdown').textContent = `${countdown} detik`;
                    document.getElementById('circle-text').textContent = countdown;

                    if (countdown <= 0) {
                        breathPhase = (breathPhase + 1) % phases.length;
                        countdown = 4;
                        updateBreathingVisual();
                    }
                }
            }

            function updateBreathingVisual() {
                const phase = phases[breathPhase];
                document.getElementById('breath-instruction').textContent = phase.instruction;
                document.getElementById('breath-countdown').textContent = `${countdown} detik`;
                document.getElementById('circle-text').textContent = countdown;

                // Animate circle based on breathing phase
                if (breathPhase === 0) { // Inhale - expand
                    breathingCircle.style.transform = 'scale(1.5)';
                    breathingCircle.style.transition = 'transform 4s ease-in-out';
                } else if (breathPhase === 2) { // Exhale - contract
                    breathingCircle.style.transform = 'scale(1)';
                    breathingCircle.style.transition = 'transform 4s ease-in-out';
                }
            }

            // Event listeners
            startBtn.addEventListener('click', startBreathing);
            pauseBtn.addEventListener('click', pauseBreathing);
            resetBtn.addEventListener('click', resetBreathing);
        }

        // Mindfulness Exercise
        function loadMindfulnessExercise() {
            exerciseTitle.textContent = 'Mindfulness & Meditation';

            const container = document.createElement('div');
            container.className = 'w-full text-center';

            const meditationCircle = document.createElement('div');
            meditationCircle.className = 'w-64 h-64 rounded-full bg-accent border-4 border-dark flex items-center justify-center mx-auto mb-6';

            const meditationText = document.createElement('span');
            meditationText.className = 'text-dark text-h4 font-bold';
            meditationText.textContent = 'Fokus pada Napas';
            meditationCircle.appendChild(meditationText);

            const timer = document.createElement('div');
            timer.className = 'text-h3 text-dark font-bold mb-4';
            timer.textContent = '05:00';
            timer.id = 'meditation-timer';

            const instructions = document.createElement('p');
            instructions.className = 'text-gray-600 mb-6 max-w-md mx-auto';
            instructions.textContent = 'Duduk dengan nyaman, tutup mata, dan fokus pada sensasi napas masuk dan keluar. Jika pikiran melayang, dengan lembut bawa kembali perhatian ke napas.';

            const controls = document.createElement('div');
            controls.className = 'flex justify-center space-x-4';

            const startBtn = document.createElement('button');
            startBtn.className = 'click-1 px-6 py-3 bg-accent text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent';
            startBtn.innerHTML = '<i class="fas fa-play mr-2"></i> Mulai';
            startBtn.id = 'start-meditation';

            const stopBtn = document.createElement('button');
            stopBtn.className = 'click-1 px-6 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset';
            stopBtn.innerHTML = '<i class="fas fa-stop mr-2"></i> Berhenti';
            stopBtn.id = 'stop-meditation';
            stopBtn.disabled = true;

            controls.appendChild(startBtn);
            controls.appendChild(stopBtn);

            container.appendChild(meditationCircle);
            container.appendChild(timer);
            container.appendChild(instructions);
            container.appendChild(controls);
            exerciseContent.appendChild(container);

            // Meditation timer logic
            let meditationTime = 300; // 5 minutes in seconds
            let meditationInterval;
            let isMeditating = false;

            function startMeditation() {
                isMeditating = true;
                startBtn.disabled = true;
                stopBtn.disabled = false;

                meditationInterval = setInterval(function() {
                    meditationTime--;
                    updateTimerDisplay();

                    if (meditationTime <= 0) {
                        clearInterval(meditationInterval);
                        meditationComplete();
                    }
                }, 1000);
            }

            function stopMeditation() {
                isMeditating = false;
                clearInterval(meditationInterval);
                startBtn.disabled = false;
                stopBtn.disabled = true;
                meditationTime = 300;
                updateTimerDisplay();
            }

            function updateTimerDisplay() {
                const minutes = Math.floor(meditationTime / 60);
                const seconds = meditationTime % 60;
                timer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            function meditationComplete() {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-check-circle text-6xl text-primary mb-4"></i>
                        <h3 class="text-h4 text-dark font-bold mb-2">Meditasi Selesai!</h3>
                        <p class="text-gray-600 mb-6">Anda telah menyelesaikan sesi mindfulness 5 menit</p>
                        <button class="click-1 px-6 py-3 bg-primary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent close-exercise">
                            Tutup
                        </button>
                    </div>
                `;

                document.querySelector('.close-exercise').addEventListener('click', function() {
                    exerciseSimulation.classList.add('hidden');
                });
            }

            // Event listeners
            startBtn.addEventListener('click', startMeditation);
            stopBtn.addEventListener('click', stopMeditation);
        }

        // Relaxation Exercise - Progressive Muscle Relaxation
        function loadRelaxationExercise() {
            exerciseTitle.textContent = 'Relaksasi - Progressive Muscle Relaxation';

            const container = document.createElement('div');
            container.className = 'w-full text-center';

            const bodyDiagram = document.createElement('div');
            bodyDiagram.className = 'w-64 h-64 mx-auto mb-6 relative';

            // Simple body diagram using CSS
            bodyDiagram.innerHTML = `
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-16 h-16 rounded-full bg-primary border-2 border-dark" id="head"></div>
                <div class="absolute top-16 left-1/2 transform -translate-x-1/2 w-24 h-32 bg-primary border-2 border-dark rounded-md" id="torso"></div>
                <div class="absolute top-16 left-1/2 transform -translate-x-1/2 -translate-y-1 w-8 h-24 bg-primary border-2 border-dark" id="left-arm"></div>
                <div class="absolute top-16 left-1/2 transform -translate-x-1/2 -translate-y-1 w-8 h-24 bg-primary border-2 border-dark" id="right-arm"></div>
                <div class="absolute top-48 left-1/2 transform -translate-x-1/2 w-8 h-24 bg-primary border-2 border-dark" id="left-leg"></div>
                <div class="absolute top-48 left-1/2 transform -translate-x-1/2 w-8 h-24 bg-primary border-2 border-dark" id="right-leg"></div>
            `;

            const instruction = document.createElement('p');
            instruction.className = 'text-h5 text-dark font-bold mb-2';
            instruction.textContent = 'Tegangkan dan Lemaskan Otot';
            instruction.id = 'relax-instruction';

            const bodyPart = document.createElement('p');
            bodyPart.className = 'text-gray-600 mb-4';
            bodyPart.textContent = 'Wajah dan Leher';
            bodyPart.id = 'relax-bodypart';

            const nextBtn = document.createElement('button');
            nextBtn.className = 'click-1 px-6 py-3 bg-primary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent';
            nextBtn.innerHTML = '<i class="fas fa-arrow-right mr-2"></i> Selanjutnya';
            nextBtn.id = 'next-relaxation';

            container.appendChild(bodyDiagram);
            container.appendChild(instruction);
            container.appendChild(bodyPart);
            container.appendChild(nextBtn);
            exerciseContent.appendChild(container);

            // PMR steps
            const pmrSteps = [
                { part: 'Wajah dan Leher', instruction: 'Tegangkan otot wajah dan leher selama 5 detik' },
                { part: 'Bahu dan Lengan', instruction: 'Tegangkan bahu dan lengan selama 5 detik' },
                { part: 'Tangan dan Jari', instruction: 'Kepalkan tangan erat selama 5 detik' },
                { part: 'Dada dan Perut', instruction: 'Tarik napas dalam dan tegangkan otot perut' },
                { part: 'Punggung', instruction: 'Tegangkan otot punggung selama 5 detik' },
                { part: 'Kaki dan Kaki', instruction: 'Tegangkan otot kaki dan kaki selama 5 detik' },
                { part: 'Seluruh Tubuh', instruction: 'Tegangkan seluruh tubuh selama 5 detik, lalu lepaskan' }
            ];

            let currentStep = 0;

            function updateRelaxationStep() {
                if (currentStep < pmrSteps.length) {
                    bodyPart.textContent = pmrSteps[currentStep].part;
                    instruction.textContent = pmrSteps[currentStep].instruction;

                    // Highlight the current body part (simplified)
                    const bodyParts = ['head', 'torso', 'left-arm', 'right-arm', 'left-leg', 'right-leg'];
                    bodyParts.forEach(part => {
                        document.getElementById(part).classList.remove('bg-secondary');
                    });

                    // Simple mapping for demo purposes
                    if (currentStep === 0) document.getElementById('head').classList.add('bg-secondary');
                    if (currentStep === 1 || currentStep === 2) {
                        document.getElementById('left-arm').classList.add('bg-secondary');
                        document.getElementById('right-arm').classList.add('bg-secondary');
                    }
                    if (currentStep === 3 || currentStep === 4) document.getElementById('torso').classList.add('bg-secondary');
                    if (currentStep === 5) {
                        document.getElementById('left-leg').classList.add('bg-secondary');
                        document.getElementById('right-leg').classList.add('bg-secondary');
                    }
                    if (currentStep === 6) {
                        bodyParts.forEach(part => {
                            document.getElementById(part).classList.add('bg-secondary');
                        });
                    }

                    currentStep++;
                } else {
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-6xl text-primary mb-4"></i>
                            <h3 class="text-h4 text-dark font-bold mb-2">Relaksasi Selesai!</h3>
                            <p class="text-gray-600 mb-6">Anda telah menyelesaikan Progressive Muscle Relaxation</p>
                            <button class="click-1 px-6 py-3 bg-primary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent close-exercise">
                                Tutup
                            </button>
                        </div>
                    `;

                    document.querySelector('.close-exercise').addEventListener('click', function() {
                        exerciseSimulation.classList.add('hidden');
                    });
                }
            }

            nextBtn.addEventListener('click', updateRelaxationStep);
        }

        // Physical Exercise - Light Activity
        function loadPhysicalExercise() {
            exerciseTitle.textContent = 'Aktivitas Fisik Ringan';

            const container = document.createElement('div');
            container.className = 'w-full text-center';

            const exerciseDisplay = document.createElement('div');
            exerciseDisplay.className = 'mb-6';

            const exerciseIcon = document.createElement('div');
            exerciseIcon.className = 'w-32 h-32 rounded-full bg-secondary flex items-center justify-center mx-auto mb-4';
            exerciseIcon.innerHTML = '<i class="fas fa-child text-6xl text-dark"></i>';

            const exerciseName = document.createElement('p');
            exerciseName.className = 'text-h5 text-dark font-bold mb-2';
            exerciseName.textContent = 'Child\'s Pose';
            exerciseName.id = 'exercise-name';

            const exerciseDescription = document.createElement('p');
            exerciseDescription.className = 'text-gray-600 mb-4 max-w-md mx-auto';
            exerciseDescription.textContent = 'Duduk berlutut dengan kaki rapat, bungkukkan badan ke depan hingga dahi menyentuh lantai, dan rentangkan tangan ke depan. Tahan posisi ini selama 30 detik.';
            exerciseDescription.id = 'exercise-description';

            const timer = document.createElement('div');
            timer.className = 'text-h3 text-dark font-bold mb-4';
            timer.textContent = '30 detik';
            timer.id = 'exercise-timer';

            exerciseDisplay.appendChild(exerciseIcon);
            exerciseDisplay.appendChild(exerciseName);
            exerciseDisplay.appendChild(exerciseDescription);
            exerciseDisplay.appendChild(timer);

            const controls = document.createElement('div');
            controls.className = 'flex justify-center space-x-4';

            const startBtn = document.createElement('button');
            startBtn.className = 'click-1 px-6 py-3 bg-secondary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent';
            startBtn.innerHTML = '<i class="fas fa-play mr-2"></i> Mulai';
            startBtn.id = 'start-exercise';

            const nextBtn = document.createElement('button');
            nextBtn.className = 'click-1 px-6 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset';
            nextBtn.innerHTML = '<i class="fas fa-arrow-right mr-2"></i> Selanjutnya';
            nextBtn.id = 'next-exercise';
            nextBtn.disabled = true;

            controls.appendChild(startBtn);
            controls.appendChild(nextBtn);

            container.appendChild(exerciseDisplay);
            container.appendChild(controls);
            exerciseContent.appendChild(container);

            // Exercises data
            const exercises = [
                {
                    name: 'Child\'s Pose',
                    description: 'Duduk berlutut dengan kaki rapat, bungkukkan badan ke depan hingga dahi menyentuh lantai, dan rentangkan tangan ke depan. Tahan posisi ini selama 30 detik.',
                    icon: 'child',
                    duration: 30
                },
                {
                    name: 'Cat-Cow Stretch',
                    description: 'Posisi merangkak, lengkungkan punggung ke atas (seperti kucing) sambil menarik perut, lalu lengkungkan ke bawah sambil mengangkat kepala dan tulang ekor. Ulangi 5 kali.',
                    icon: 'cat',
                    duration: 30
                },
                {
                    name: 'Shoulder Rolls',
                    description: 'Duduk atau berdiri tegak, putar bahu ke belakang dalam gerakan melingkar. Lakukan 10 kali untuk setiap bahu.',
                    icon: 'redo',
                    duration: 30
                }
            ];

            let currentExercise = 0;
            let exerciseTime = exercises[0].duration;
            let exerciseInterval;
            let isExercising = false;

            function startExercise() {
                isExercising = true;
                startBtn.disabled = true;
                nextBtn.disabled = true;

                exerciseInterval = setInterval(function() {
                    exerciseTime--;
                    timer.textContent = `${exerciseTime} detik`;

                    if (exerciseTime <= 0) {
                        clearInterval(exerciseInterval);
                        exerciseComplete();
                    }
                }, 1000);
            }

            function exerciseComplete() {
                isExercising = false;
                startBtn.disabled = false;
                nextBtn.disabled = false;

                if (currentExercise < exercises.length - 1) {
                    startBtn.textContent = 'Ulangi';
                } else {
                    nextBtn.textContent = 'Selesai';
                }
            }

            function nextExercise() {
                if (currentExercise < exercises.length - 1) {
                    currentExercise++;
                    loadExerciseData();
                    startBtn.disabled = false;
                    nextBtn.disabled = true;
                    startBtn.textContent = 'Mulai';
                } else {
                    // All exercises completed
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-6xl text-primary mb-4"></i>
                            <h3 class="text-h4 text-dark font-bold mb-2">Latihan Selesai!</h3>
                            <p class="text-gray-600 mb-6">Anda telah menyelesaikan rangkaian aktivitas fisik ringan</p>
                            <button class="click-1 px-6 py-3 bg-primary text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent close-exercise">
                                Tutup
                            </button>
                        </div>
                    `;

                    document.querySelector('.close-exercise').addEventListener('click', function() {
                        exerciseSimulation.classList.add('hidden');
                    });
                }
            }

            function loadExerciseData() {
                const exercise = exercises[currentExercise];
                exerciseName.textContent = exercise.name;
                exerciseDescription.textContent = exercise.description;
                exerciseIcon.innerHTML = `<i class="fas fa-${exercise.icon} text-6xl text-dark"></i>`;
                exerciseTime = exercise.duration;
                timer.textContent = `${exerciseTime} detik`;
            }

            // Event listeners
            startBtn.addEventListener('click', startExercise);
            nextBtn.addEventListener('click', nextExercise);

            // Load first exercise
            loadExerciseData();
        }
    });
</script>
@endsection
