@section('sidebar')
    <div id="sidebar">
        <h1>Topics</h1>
        @foreach($topics as $topic)
            <a href="#"><i class="fa-solid fa-chevron-right" style="color: #00003e; margin: 2px;"></i>{{ $topic->name }}</a>
        @endforeach
    </div>
@endsection