<x-filament-widgets::widget>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- SON REZERVASYONLAR --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon
                        icon="heroicon-m-calendar-days"
                        class="h-5 w-5 text-gray-500 dark:text-gray-400"
                    />
                    <span>Son Rezervasyon Talepleri</span>
                </div>
            </x-slot>

            <x-slot name="headerEnd">
                <x-filament::link
                    href="{{ $bookingUrl }}"
                    size="sm"
                    icon="heroicon-m-arrow-top-right-on-square"
                >
                    Tümünü Gör
                </x-filament::link>
            </x-slot>

            <div class="divide-y divide-gray-200 dark:divide-white/10">
                @forelse($latestBookings as $booking)
                    <div class="py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $booking->name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $booking->party_size }} Kişi)</span>
                            </div>
                            <div class="mt-1 flex flex-wrap gap-x-3 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
                                <span class="flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-m-calendar" class="h-3 w-3" />
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-m-clock" class="h-3 w-3" />
                                    {{ $booking->booking_time }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-m-map-pin" class="h-3 w-3" />
                                    {{ $booking->seating_area === 'terrace' || $booking->seating_area === 'TERAS' ? 'Teras' : 'Bahçe' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            @php
                                $statusColor = match($booking->status) {
                                    'approved' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'warning',
                                };
                                $statusLabel = match($booking->status) {
                                    'approved' => 'Onaylandı',
                                    'cancelled' => 'İptal Edildi',
                                    default => 'Bekliyor',
                                };
                            @endphp
                            <x-filament::badge color="{{ $statusColor }}">
                                {{ $statusLabel }}
                            </x-filament::badge>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        Henüz rezervasyon talebi bulunmuyor.
                    </div>
                @endforelse
            </div>
        </x-filament::section>

        {{-- SON GERİ BİLDİRİMLER --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon
                        icon="heroicon-m-chat-bubble-left-ellipsis"
                        class="h-5 w-5 text-gray-500 dark:text-gray-400"
                    />
                    <span>Son Geri Bildirimler</span>
                </div>
            </x-slot>

            <x-slot name="headerEnd">
                <x-filament::link
                    href="{{ $feedbackUrl }}"
                    size="sm"
                    icon="heroicon-m-arrow-top-right-on-square"
                >
                    Tümünü Gör
                </x-filament::link>
            </x-slot>

            <div class="divide-y divide-gray-200 dark:divide-white/10">
                @forelse($latestFeedback as $feedback)
                    <div class="py-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $feedback->name ?: 'Anonim Gönderici' }}
                            </span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $feedback->created_at->diffForHumans() }}
                                </span>
                                @if(!$feedback->is_read)
                                    <x-filament::badge color="warning">Okunmadı</x-filament::badge>
                                @endif
                            </div>
                        </div>
                        @if($feedback->contact)
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $feedback->contact }}
                            </div>
                        @endif
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                            {{ $feedback->message }}
                        </p>
                    </div>
                @empty
                    <div class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        Henüz geri bildirim bulunmuyor.
                    </div>
                @endforelse
            </div>
        </x-filament::section>

    </div>
</x-filament-widgets::widget>
