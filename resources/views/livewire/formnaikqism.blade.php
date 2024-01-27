<div class="flex w-full justify-center justify-self-center py-4">
        <div class="card lg:card-side w-fit bg-base-100 shadow-xl px-4 py-4">
            <div class="card-body">
                <h2 class="card-title self-center text-center text-tsn-header">Pendaftaran Naik Qism</h2>

                <br>
                <div class="card-actions justify-start">
                    <div class="flex w-full bg-transparent justify-center">
                        <form wire:submit="cek">

                            <label class="form-control w-full max-w-xs">
                                <div class="label">
                                    <span class="label-text">Masukkan no KK</span>
                                    {{-- <span class="label-text-alt">Top Right label</span> --}}
                                </div>
                                <input type="text" placeholder="Masukkan no KK" wire:model="kk"
                                    class="input input-bordered w-full max-w-xs" />
                                <div class="label">
                                    {{-- <span class="label-text-alt">Bottom Left label</span> --}}
                                    {{-- <span class="label-text-alt">Bottom Right label</span> --}}
                                </div>
                            </label>
                            <button class="btn bg-tsn-accent focus:bg-tsn-bg" type="submit">Cek</button>
                        </form>
                    </div>
                </div>
                <div class="text-black text-center">
                    {{ $this->table }}
                </div>
            </div>
        </div>
        <x-filament-actions::modals />
</div>
