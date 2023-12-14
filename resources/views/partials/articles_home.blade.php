@section('content')
    <head>
        <script src="https://kit.fontawesome.com/dbd6c8e80d.js" crossorigin="anonymous"></script>

    </head>
    
    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box-big">
                <form id = 'filterForm' action="{{ route('home')}}" method="GET">
                    <div>
                    <label for="sort">Filter by:</label>
                    <select id="category-filter" onChange="filterArticles()" name="selectedOption">
                        @if ( $columns['sort'] === 'all' )
                            <option value="all" id="all">All</option>
                            <option value="recent" id="recent">Recent</option>
                            <option value="popular" id="popular">Popular</option>
                        @elseif ( $columns['sort'] === 'recent' )
                            <option value="recent" id="recent">All</option>
                            <option value="popular" id="popular">Popular</option>
                            <option value="all" id="all">Recent</option>
                        @else
                            <option value="popular" id="popular">Popular</option>
                            <option value="recent" id="recent">Recent</option>
                            <option value="all" id="all">All</option>
                        @endif
                    </select>
                    </label>
                    </div>
                </form>
                <script>
                    function filterArticles() {
                        // Get the form element
                        var form = document.getElementById('filterForm');
                        var selectedOption = document.getElementById('category-filter').value;

                        console.log(form);

                        form.submit();
                    }
                </script>

                <div>
                    <div class="article-image">
                        <img src="{{ $columns['bigArticle']->photo() }}" alt="Article Image">

                    </div>
                    <div class="article-content">
                        <h1>{{ $columns['bigArticle']->name }}</h1>
                        <p>{{ $columns['bigArticle']->description }}</p>
                        <a href="{{ url('articles/'.$columns['bigArticle']->article_id) }}" class="button">Read More</a>
                    </div>
                </div>
            </div>  

            <div class="additional-box-container">
                <!-- First Column -->
                <div class="column">
                    @foreach($columns['column1'] as $article)
                        <div class="small-box" data-category="{{ $article->category }}">
                            <h2> {{ $article->name }} </h2>
                            <p> {{ $article->description }} </p>
                            <a href="{{ url('articles/'.$article->article_id) }}" class="small-button" style="margin-left: 30px;">Read More</a>
                        </div>
                    @endforeach
                </div>

                <!-- Second Column -->
                <div class="column">
                    
                    @foreach($columns['column2'] as $article)
                        <div class="small-box" data-category="{{ $article->category }}">
                            <h2> {{ $article->name }} </h2>
                            <p> {{ $article->description }} </p>
                            <a href="{{ url('articles/'.$article->article_id) }}" class="small-button" style="margin-left: 30px;">Read More</a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        </div>
    </section>


@endsection
