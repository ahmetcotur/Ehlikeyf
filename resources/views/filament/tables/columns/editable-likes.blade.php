<div x-data="{ 
        likes: {{ (int) $getState() }}, 
        isEditing: false,
        isSaving: false,
        save() {
            if(this.likes == {{ (int) $getState() }} || this.likes < 0) {
                this.isEditing = false;
                return;
            }
            this.isSaving = true;
            fetch('/api/menu/like/{{ $getRecord()->id }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content')
                },
                body: JSON.stringify({ action: 'set', count: this.likes })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    this.likes = data.likes_count;
                }
            })
            .finally(() => {
                this.isSaving = false;
                this.isEditing = false;
            });
        }
    }" 
    class="flex items-center gap-2"
>
    <!-- View State: Badge -->
    <button 
        x-show="!isEditing" 
        @click="isEditing = true; $nextTick(() => $refs.input.focus())"
        class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl text-danger-700 bg-danger-50 hover:bg-danger-100 ring-1 ring-inset ring-danger-600/10 dark:text-danger-400 dark:bg-danger-400/10 dark:ring-danger-400/20 transition-all"
        title="Edit Likes"
    >
        <svg class="w-4 h-4 mr-1.5 text-danger-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        <span x-text="likes"></span>
    </button>

    <!-- Edit State: Input next to Icon -->
    <div x-show="isEditing" x-cloak class="flex items-center gap-1.5 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-white/10 p-1">
        <svg class="w-4 h-4 text-danger-500 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        <input 
            x-ref="input"
            x-model="likes" 
            type="number" 
            min="0"
            :disabled="isSaving"
            class="block w-16 text-sm py-0.5 px-1.5 border-0 focus:ring-0 bg-transparent text-gray-900 dark:text-white"
            @keydown.enter="save()"
            @keydown.escape="isEditing = false; likes = {{ (int) $getState() }}"
            @click.away="save()"
        >
        <div x-show="isSaving" class="px-1 text-gray-400">
            <svg class="animate-spin h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</div>
