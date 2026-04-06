<form class="flex justify-end my-4"
    action="{{ $isReserved() ? route('courses.cancel', $course) : route('courses.reserve', $course) }}"
    method="POST">

    @csrf

    @if(!$isTeacher())

        @if($isReserved())
            <button type="submit"
                class="mt-4 rounded-md bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-600 transition">
                Annuler
            </button>

        @elseif($isFull())
            <button type="button"
                class="mt-4 rounded-md bg-red-500 px-4 py-2 text-white cursor-not-allowed">
                Complet
            </button>

        @else
            <button type="submit"
                class="mt-4 rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 transition">
                Réserver
            </button>

        @endif

    @endif

</form>