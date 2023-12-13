@section('sidebar')
    <div id="sidebar">
        <h1>Topics</h1>
        <ul style="list-style: none;">
            @foreach($topics as $topic)
                <li>
                    <a href="{{ url('/home/'.$topic->topic_id) }}">
                        <i class="fa-solid fa-chevron-right" style="color: #00003e; margin: 2px;"></i>{{ $topic->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
