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
                    <select id="category-filter" onChange="filterArticles()" name="selectedOption">
                        @if ( $columns['sort'] === 'all' )
                            <option value="all" id="all">All</option>
                            <option value="recent" id="recent">Recent</option>
                            <option value="popular" id="popular">Popular</option>
                            @if(Auth::user())
                                <option value="user-feed" id="user-feed">User Feed</option>
                            @endif
                        @elseif ( $columns['sort'] === 'recent' )
                            <option value="recent" id="recent">Recent</option>
                            <option value="popular" id="popular">Popular</option>
                            <option value="all" id="all">All</option>
                            @if(Auth::user())
                                <option value="user-feed" id="user-feed">User Feed</option>
                            @endif
                        @elseif ( $columns['sort'] === 'popular' )
                            <option value="popular" id="popular">Popular</option>
                            <option value="recent" id="recent">Recent</option>
                            <option value="all" id="all">All</option>
                            @if(Auth::user())
                                <option value="user-feed" id="user-feed">User Feed</option>
                            @endif                        
                        @else
                            @if(Auth::user())
                                <option value="user-feed" id="user-feed">User Feed</option>
                            @endif                            
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

                @if (isset($columns['bigArticle']))
                    <div>
                    @if ($columns['bigArticle']->photo())

                        <div class="article-image">
                            <img src="{{ $columns['bigArticle']->photo() }}" alt="Article Image">

                        </div>
                    @endif
                        <div class="article-content">
                            <h1>{{ $columns['bigArticle']->name }}</h1>
                            <p class = "big-text">{{ $columns['bigArticle']->description }}</p>
                            <a href="{{ url('articles/'.$columns['bigArticle']->article_id) }}" class="button">Read More</a>
                        </div>

                    </div>
                @endif
            </div>  

            <div class="additional-box-container">
                <!-- First Column -->
                <div class="column">
                    @if (isset($columns['column1']))
                        @foreach($columns['column1'] as $article)
                            <div class="small-box" data-category="{{ $article->category }}">
                                <h2> {{ $article->name }} </h2>
                                <p> {{ $article->description }} </p>
                                <a href="{{ url('articles/'.$article->article_id) }}" class="small-button" style="margin-left: 30px;">Read More</a>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Second Column -->
                <div class="column">
                    @if (isset($columns['column2']))
                        @foreach($columns['column2'] as $article)
                                <div class="small-box" data-category="{{ $article->category }}">
                                    <h2> {{ $article->name }} </h2>
                                    <p> {{ $article->description }} </p>
                                    <a href="{{ url('articles/'.$article->article_id) }}" class="small-button" style="margin-left: 30px;">Read More</a>
                                </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
        </div>
    </section>


@endsection
