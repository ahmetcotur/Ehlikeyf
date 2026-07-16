<div class="pt-32 pb-24 bg-brand-light min-h-screen relative overflow-hidden">
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%235E4A3F' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.1'%3E%3Cpath d='M60 100 C 60 70 45 40 20 20'/%3E%3Cpath d='M60 100 C 65 70 85 40 110 20'/%3E%3Cellipse cx='35' cy='45' rx='10' ry='5' transform='rotate(-35 35 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='45' cy='75' rx='8' ry='4' transform='rotate(-45 45 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='85' cy='45' rx='10' ry='5' transform='rotate(35 85 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='75' cy='75' rx='8' ry='4' transform='rotate(45 75 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Ccircle cx='60' cy='60' r='4' fill='%235E4A3F'/%3E%3Ccircle cx='55' cy='85' r='3.5' fill='%235E4A3F'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center mb-16">
            <h1 class="gsap-fade-in text-4xl md:text-5xl lg:text-6xl text-center font-light text-brand-dark mb-6 tracking-wide">
                {{ __('Blog') }}
            </h1>
            <p class="gsap-fade-in text-gray-500 font-light max-w-2xl mx-auto text-lg">
                {{ __('Discover the latest news, recipes, and stories from the heart of the Mediterranean.') }}
            </p>
        </div>

        @if($posts->isEmpty())
            <div class="text-center py-20 text-gray-500 font-light italic">
                {{ __('No stories published yet.') }}
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts as $post)
                    <a href="/{{ $post->slug }}" wire:navigate class="gsap-fade-in group flex flex-col h-full bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-500 border border-brand-dark/5">
                        
                        <!-- Image Container with aspect ratio -->
                        <div class="aspect-[4/3] overflow-hidden relative border-b border-brand-dark/5">
                            @if($post->image_url)
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            @else
                                @php
                                    $indexPlaceholders = ['029A0982.jpg', '029A0973.jpg', '029A5151.jpg', '029A5168.jpg', '029A1008.jpg'];
                                    $randomIndexPh = $indexPlaceholders[array_rand($indexPlaceholders)];
                                @endphp
                                <img src="{{ asset('images/gallery/' . $randomIndexPh) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            @endif
                            <div class="absolute inset-0 bg-brand-dark/5 group-hover:bg-transparent transition-colors duration-500"></div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-8 flex flex-col flex-grow">
                            @if($post->published_at)
                                <span class="text-xs text-brand-olive uppercase tracking-widest font-semibold mb-3">{{ $post->published_at->translatedFormat('d M Y') }}</span>
                            @endif
                            <h2 class="text-xl font-medium text-brand-dark mb-4 leading-snug group-hover:text-brand-olive transition-colors">{{ $post->title }}</h2>
                            <p class="text-gray-500 font-light text-sm leading-relaxed flex-grow">
                                {{ Str::limit(strip_tags(html_entity_decode($post->description)), 120) }}
                            </p>
                            
                            <div class="mt-6 pt-6 border-t border-brand-dark/10 flex items-center text-xs text-brand-dark uppercase tracking-widest font-medium group-hover:text-brand-olive transition-colors">
                                {{ __('Read Article') }}
                                <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
        
    </div>
</div>
