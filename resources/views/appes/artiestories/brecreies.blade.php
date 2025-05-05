
        @php
            $username = $story->usericonStories->username ?? 'defaultuser';
            $improfil = $story->usericonStories->improfil ?? 'default.png';
            $path = $username . '/profil/' . $improfil;
            $ext = pathinfo($improfil, PATHINFO_EXTENSION);
        @endphp
        @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
            <img src="{{ asset($path) }}" class="creatorstories">
        @endif