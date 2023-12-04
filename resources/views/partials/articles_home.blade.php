@section('content')
    <head>
        <script src="https://kit.fontawesome.com/dbd6c8e80d.js" crossorigin="anonymous"></script>

    </head>
    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <select id="category-filter" onChange="filterArticles()">
                    <option value="all">All</option>
                    <option value="recent">Recent</option>
                    <option value="popular">Popular</option>
                </select>
                <div>
                    <div class="article-image">
                        <img src="{{ asset('images/teste2.jpg') }}" alt="Article Image">
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
                            <a href="{{ url('articles/'.$article->article_id) }}" class="small-button">Read More</a>
                        </div>
                    @endforeach
                </div>

                <!-- Second Column -->
                <div class="column">
                    
                    @foreach($columns['column2'] as $article)
                        <div class="small-box" data-category="{{ $article->category }}">
                            <h2> {{ $article->name }} </h2>
                            <p> {{ $article->description }} </p>
                            <a href="{{ url('articles/'.$article->article_id) }}" class="small-button">Read More</a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        </div>
    </section>


@endsection
