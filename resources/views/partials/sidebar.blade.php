@section('sidebar')
    <div id="sidebar">
        <h1>Topics</h1>
        <ul style="list-style=none;">
            @foreach($topics as $topic)
                <li><button id="topics"><i class="fa-solid fa-chevron-right" style="color: #00003e; margin: 2px;"></i>{{ $topic->name }}</button></li>
            @endforeach
        </ul>
        
    </div>
@endsection