<div>
    <h1>{{ $title }}</h1>

    <ul>
        @foreach($articles as $article)
            <li>{{ $article }}</li>
        @endforeach
    </ul>
</div>