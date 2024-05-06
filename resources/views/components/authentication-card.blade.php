<div class="flex flex-col sm:justify-center items-center sm:pt-0" style="background-image: url('{{ asset('bg.jpg') }}'); height: 100vh;">

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg mt-10 bg-no-repeat bg-cover bg-center border-2 border-red-300"  style="background-image: url('{{ asset('bg.gif') }}');">
        {{ $slot }}
    </div>
</div>
