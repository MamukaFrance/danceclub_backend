
@props([
    'types' => ['success', 'error', 'info', 'warning'],
])

@php
    // Stocker tous les messages trouvés
    $messages = [];

    foreach ($types as $type) {
        if (session()->has($type)) {
            $msg = session($type);
            if (is_array($msg)) {
                foreach ($msg as $m) {
                    $messages[] = ['type' => $type, 'message' => $m];
                }
            } else {
                $messages[] = ['type' => $type, 'message' => $msg];
            }
        }
    }

    // Classes par type
    $typeClasses = [
        'success' => 'border-green-500 bg-green-50 text-green-700',
        'error'   => 'border-red-500 bg-red-50 text-red-700',
        'info'    => 'border-blue-500 bg-blue-50 text-blue-700',
        'warning' => 'border-yellow-500 bg-yellow-50 text-yellow-700',
    ];
@endphp

@foreach ($messages as $msg)
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        class="relative max-w-md mx-auto mb-4 rounded-lg border p-3 text-center {{ $typeClasses[$msg['type']] ?? 'border-gray-400 bg-gray-50 text-gray-700' }}"
        style="transition: opacity 0.5s;"
    >
        <span class="block text-center">
            {{ $msg['message'] }}
        </span>

        <button
            @click="show = false"
            class="absolute right-3 top-1/2 -translate-y-1/2 font-bold"
        >
            &times;
        </button>
    </div>
@endforeach

