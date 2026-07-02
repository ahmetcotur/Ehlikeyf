<div class="pt-32 pb-24 bg-brand-light min-h-screen relative overflow-hidden">
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%235B6E4E' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.1'%3E%3Cpath d='M60 100 C 60 70 45 40 20 20'/%3E%3Cpath d='M60 100 C 65 70 85 40 110 20'/%3E%3Cellipse cx='35' cy='45' rx='10' ry='5' transform='rotate(-35 35 45)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='45' cy='75' rx='8' ry='4' transform='rotate(-45 45 75)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='85' cy='45' rx='10' ry='5' transform='rotate(35 85 45)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='75' cy='75' rx='8' ry='4' transform='rotate(45 75 75)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Ccircle cx='60' cy='60' r='4' fill='%235B6E4E'/%3E%3Ccircle cx='55' cy='85' r='3.5' fill='%235B6E4E'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center mb-12">
            <a href="{{ route('blog.index') }}" wire:navigate class="inline-flex items-center text-xs text-brand-dark uppercase tracking-widest font-medium hover:text-brand-olive transition-colors mb-8">
                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                {{ __('Back to Journal') }}
            </a>
            
            @if($post->published_at)
                <div class="gsap-fade-in text-brand-olive text-sm font-semibold tracking-[0.2em] uppercase mb-4">
                    {{ $post->published_at->translatedFormat('d F Y') }}
                </div>
            @endif
            
            <h1 class="gsap-fade-in text-4xl md:text-5xl lg:text-6xl font-light text-brand-dark leading-tight mb-8">
                {{ $post->title }}
            </h1>
        </div>

        @if($post->image)
            <div class="gsap-fade-in w-full aspect-[21/9] mb-16 overflow-hidden rounded-3xl shadow-sm relative">
                <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-brand-dark/5 pointer-events-none"></div>
            </div>
        @endif

        <div class="gsap-fade-in prose prose-lg md:prose-xl prose-stone max-w-none prose-headings:font-light prose-headings:text-brand-dark prose-a:text-brand-olive hover:prose-a:text-brand-dark prose-img:rounded-3xl prose-img:shadow-sm">
            {!! $post->content !!}
        </div>
        
    </article>
</div>
