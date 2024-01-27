<button {{ $attributes->merge(['type' => 'submit', 'class' => 'hover:text-white inline-flex items-center px-4 py-2 bg-tsn-accent border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-tsn-header focus:bg-tsn-header active:bg-tsn-header focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
