@props(['tag'])

<a href="{{ route('tags.show', $tag->slug) }}" class="badge-tag">
    #{{ $tag->name }}
</a>
