<section class="py-24 md:py-32 bg-brand-light text-brand-dark px-4 sm:px-6 lg:px-8 border-t border-brand-dark/10 relative overflow-hidden">
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%235E4A3F' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.1'%3E%3Cpath d='M60 100 C 60 70 45 40 20 20'/%3E%3Cpath d='M60 100 C 65 70 85 40 110 20'/%3E%3Cellipse cx='35' cy='45' rx='10' ry='5' transform='rotate(-35 35 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='45' cy='75' rx='8' ry='4' transform='rotate(-45 45 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='85' cy='45' rx='10' ry='5' transform='rotate(35 85 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='75' cy='75' rx='8' ry='4' transform='rotate(45 75 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Ccircle cx='60' cy='60' r='4' fill='%235E4A3F'/%3E%3Ccircle cx='55' cy='85' r='3.5' fill='%235E4A3F'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <h2 class="gsap-fade-in text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-4">{{ __('Blog') }}</h2>
            <h3 class="gsap-fade-in text-3xl md:text-5xl font-light leading-tight text-brand-dark">{{ __('Latest Articles') }}</h3>
        </div>

        @if($error)
            <div class="text-center py-12 text-gray-500 font-light italic">
                {{ __('Curently unable to load the latest stories. Please check our') }} <a href="https://Ehl-i Keyfkas.com.tr/blog" class="text-brand-olive hover:underline" target="_blank">{{ __('blog page') }}</a>.
            </div>
        @elseif(empty($posts))
            <div class="text-center py-12 text-gray-500 font-light italic">
                Loading stories...
            </div>
        @else
            <!-- Premium Editorial Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 pb-12 pt-4" data-gsap-stagger>
                @foreach($posts as $post)
                    <a href="{{ $post['link'] }}" class="group flex flex-col bg-white/70 backdrop-blur-md rounded-2xl overflow-hidden border border-white/60 shadow-[0_10px_30px_rgba(91,78,58,0.04)] hover:shadow-[0_20px_40px_rgba(91,78,58,0.08)] transition-all duration-500 hover:-translate-y-1.5 flex-grow" data-gsap-item>
                        
                        <!-- Image Container with Date Tag -->
                        <div class="aspect-[16/10] w-full overflow-hidden relative bg-brand-light flex-shrink-0">
                            @php
                                $imgSrc = trim((string)$post['image']);
                                if (empty($imgSrc) || str_contains($imgSrc, '/plugins/')) {
                                    $blogPlaceholders = ['029A0982.jpg', '029A0973.jpg', '029A5151.jpg', '029A5168.jpg', '029A1008.jpg'];
                                    $randomBlogPh = $blogPlaceholders[array_rand($blogPlaceholders)];
                                    $finalImg = asset('images/gallery/' . $randomBlogPh);
                                } else {
                                    $finalImg = $imgSrc;
                                }
                                
                                // Mock reading time (e.g. 3-5 min) based on title length
                                $readTime = (strlen($post['title']) % 3) + 3;
                            @endphp
                            <img src="{{ $finalImg }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-brand-dark/15 group-hover:bg-brand-dark/5 transition-colors duration-500"></div>
                            
                            <!-- Date Tag -->
                            <div class="absolute top-4 left-4 bg-brand-light/95 backdrop-blur-sm border border-white/40 px-3.5 py-1.5 rounded-full shadow-sm">
                                <span class="text-[10px] text-brand-olive font-semibold uppercase tracking-wider">{{ $post['date'] }}</span>
                            </div>
                        </div>
                        
                        <!-- Content area -->
                        <div class="p-8 flex flex-col flex-grow justify-between">
                            <div class="space-y-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] text-brand-olive uppercase tracking-[0.15em] font-semibold">Ehl-i Keyf Günce</span>
                                    <span class="w-1 h-1 rounded-full bg-brand-olive/30"></span>
                                    <span class="text-[10px] text-brand-dark/45 font-medium tracking-wide">{{ $readTime }} {{ __('min read') ?? 'Dk Okuma' }}</span>
                                </div>
                                
                                <h4 class="text-xl font-serif font-light text-brand-dark leading-snug group-hover:text-brand-olive transition-colors duration-300">
                                    {{ \Illuminate\Support\Str::limit($post['title'], 55) }}
                                </h4>
                                
                                <p class="text-brand-dark/65 font-light text-[13px] leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($post['description'], 110) }}
                                </p>
                            </div>
                            
                            <!-- Action footer -->
                            <div class="mt-8 pt-5 border-t border-brand-dark/5 flex items-center justify-between">
                                <span class="text-[11px] text-brand-dark font-semibold uppercase tracking-[0.2em] group-hover:text-brand-olive transition-colors duration-300">
                                    {{ __('Read Article') }}
                                </span>
                                <div class="w-7 h-7 rounded-full bg-brand-light flex items-center justify-center text-brand-olive group-hover:bg-brand-olive group-hover:text-white transition-all duration-300">
                                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        @endif
        
        <div class="mt-16 text-center">
            <a href="/blog" class="gsap-fade-in inline-block px-10 py-4 border border-brand-dark text-brand-dark hover:bg-brand-dark hover:text-white transition-colors duration-300 uppercase tracking-widest text-xs font-medium rounded-full">{{ __('View All Stories') }}</a>
        </div>
    </div>
</section>
