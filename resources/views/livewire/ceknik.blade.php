<div>
    <form wire:submit="create">
        {{ $this->form }}
        <br>
        <button class="btn btn-primary" type="submit" wire:click="submit" wire:confirm="Pastikan data benar!">
            Submit
        </button>
    </form>

    <x-filament-actions::modals />
</div>
