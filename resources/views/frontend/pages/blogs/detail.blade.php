@extends('frontend.layouts.pages.master-sidebar')

@section('content')
<article class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" itemscope itemtype="https://schema.org/BlogPosting">
    @if (!empty($blog->image_featured))
        @php
            $mediaItem = $media->firstWhere('fileencrypt', str_replace('/storage/', '', $blog->image_featured));
        @endphp
        <div class="relative">
            <img src="{{ asset($blog->image_featured) }}"
                 alt="{{ $mediaItem->alternative_text ?? $blog->title }}"
                 class="w-full h-[260px] md:h-[420px] object-cover"
                 loading="lazy"
                 decoding="async"
                 itemprop="image">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
            <div class="absolute bottom-4 left-4 md:bottom-6 md:left-6 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/90 text-slate-700 text-xs md:text-sm font-medium">
                <span class="inline-block w-2 h-2 bg-sky-500 rounded-full"></span>
                {{ optional($blog->category)->name ?? 'Uncategorized' }}
            </div>
        </div>
    @endif

    <div class="px-5 py-6 md:px-10 md:py-10">
        <header class="mb-6 border-b border-slate-100 pb-5">
            <h1 class="text-2xl md:text-4xl font-bold text-slate-900 leading-tight" itemprop="headline">
                {{ $blog->title }}
            </h1>
            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <time itemprop="datePublished" datetime="{{ optional($blog->publish_date ?? $blog->created_at)->format('Y-m-d') }}">
                        {{ optional($blog->publish_date ?? $blog->created_at)->format('d M Y') }}
                    </time>
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.878 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $blog->author ?: 'Admin' }}
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $readingTime }} min read
                </span>
            </div>
        </header>

        @if(!empty($blog->meta_description))
            <p class="text-base md:text-lg text-slate-600 leading-relaxed mb-6" itemprop="description">
                {{ $blog->meta_description }}
            </p>
        @endif

        <div class="prose prose-slate max-w-none prose-headings:text-slate-900 prose-a:text-sky-600 prose-img:rounded-xl prose-img:shadow-sm" itemprop="articleBody">
            {!! $blog->content !!}
        </div>

        <footer class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to articles
            </a>
            <div class="text-xs text-slate-400">Last updated: {{ optional($blog->updated_at)->format('d M Y, H:i') }}</div>
        </footer>
    </div>
</article>
@endsection
