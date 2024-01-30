<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'es-ES'; // Configura el idioma según tus necesidades

            const microphoneIcon = document.getElementById('microphone-icon');
            const floatingText = document.getElementById('floating-text');

            // Agrega un evento de clic al icono de micrófono para activar/desactivar el reconocimiento de voz
            microphoneIcon.addEventListener('click', () => {
                if (recognition.running) {
                    recognition.stop();
                } else {
                    recognition.start();
                }
            });

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript.toLowerCase();

                // Verificar si el usuario mencionó "cerrar sesión"
                if (transcript.includes('cerrar sesión')) {
                    // Mostrar el texto flotante
                    floatingText.style.display = 'block';

                    // Responder con una voz
                    speak(floatingText.textContent);

                    // Retrasar la ejecución del formulario y la ocultación del texto
                    setTimeout(() => {
                        // Realizar la acción de cerrar sesión
                        document.forms['logout-form'].submit();

                        // Ocultar el texto flotante después de 5 segundos
                        setTimeout(() => {
                            floatingText.style.display = 'none';
                        }, 5000);
                    }, 3000); // Retraso de 2 segundos (ajustable)
                }
            };

            function speak(message) {
                const synth = window.speechSynthesis;
                const utterance = new SpeechSynthesisUtterance(message);
                synth.speak(utterance);
            }
        });
    </script>

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>


</html>
