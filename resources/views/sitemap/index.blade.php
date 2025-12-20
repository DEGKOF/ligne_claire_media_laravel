<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Page d'accueil --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Rubriques --}}
    @foreach($rubriques as $rubrique)
    <url>
        <loc>{{ route('rubrique.show', $rubrique->slug) }}</loc>
        <lastmod>{{ $rubrique->updated_at->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Publications --}}
    @foreach($publications as $publication)
    <url>
        <loc>{{ route('publication.show', $publication->slug) }}</loc>
        <lastmod>{{ $publication->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
