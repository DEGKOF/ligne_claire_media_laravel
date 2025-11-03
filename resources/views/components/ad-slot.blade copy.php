@if($ad)
    <div class="advertisement-container" data-ad-id="{{ $ad->id }}" data-position="{{ $position }}">
        @if($ad->content_type === 'image')
            <a href="{{ route('ad.track.click', $ad->id) }}"
               target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
               rel="noopener noreferrer sponsored"
               class="block">
                <img src="{{ $ad->image_url }}"
                     alt="{{ $ad->headline ?? 'Publicité' }}"
                     class="w-full h-auto">
                @if($ad->headline || $ad->caption)
                    <div class="ad-caption p-2 text-sm">
                        @if($ad->headline)
                            <p class="font-semibold">{{ $ad->headline }}</p>
                        @endif
                        @if($ad->caption)
                            <p class="text-gray-600">{{ $ad->caption }}</p>
                        @endif
                    </div>
                @endif
            </a>

        @elseif($ad->content_type === 'video')
            <div class="video-ad-container">
                <iframe src="{{ $ad->video_url }}"
                        frameborder="0"
                        allowfullscreen
                        class="w-full"></iframe>
                <a href="{{ route('ad.track.click', $ad->id) }}"
                   target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
                   class="btn btn-primary mt-2">
                    {{ $ad->cta_text ?? 'En savoir plus' }}
                </a>
            </div>

        @elseif($ad->content_type === 'html')
            <div class="html-ad-container">
                {!! $ad->html_content !!}
                <a href="{{ route('ad.track.click', $ad->id) }}"
                   target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
                   style="display: none;">Track</a>
            </div>
        @endif

        <div class="ad-label text-xs text-gray-400 mt-1">Publicité</div>
    </div>
@elseif($fallback)
    <div class="advertisement-fallback">
        {!! $fallback !!}
    </div>
@endif
