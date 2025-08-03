<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-lime border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-lime/90 focus:outline-none focus:ring-2 focus:ring-lime focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
