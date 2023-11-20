@section('content')
    <head>
        <script src="https://kit.fontawesome.com/dbd6c8e80d.js" crossorigin="anonymous"></script>

    </head>
    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-image">
                    <img src="{{ asset('images/teste2.jpg') }}" alt="Article Image">
                </div>
                <div class="article-content">
                    <h1>Messi O MELHOR DO MUNDO, GOAT D10Sx</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>

            <div class="additional-box-container">
                <!-- First Column -->
                <div class="column">

                    @foreach($columns['column1'] as $article)
                        <div class="small-box">
                            <h2> {{ $article->name }} </h2>
                            <p> {{ $article->description }} </p>
                            <a href="#" class="small-button">Read More </a>
                        </div>
                    @endforeach

                    <!--
                    <div class="small-box">
                        <h2>Additional Small Box 1 Title</h2>
                        <p>Additional Small Box 1 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 2 Title</h2>
                        <p>Bme vindo a vila moleza, o Porto aqui vai jogar e vai ganhar</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 3 Title</h2>
                        <p>Additional Small Box 3 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>
                    
                    <div class="small-box">
                        <h2>Additional Small Box 3 Title</h2>
                        <p>Additional Small Box 3 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>-->


                </div>

                <!-- Second Column -->
                <div class="column">
                    
                    @foreach($columns['column2'] as $article)
                        <div class="small-box">
                            <h2> {{ $article->name }} </h2>
                            <p> {{ $article->description }} </p>
                            <a href="#" class="small-button">Read More </a>
                        </div>
                    @endforeach
                    
                    <!--<div class="small-box">
                        <h2>Additional Small Box 4 Title</h2>
                        <p>Additional Small Box 4 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 5 Title</h2>
                        <p>Bme vindo a vila moleza, o Porto aqui vai jogar e vai ganhar</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 6 Title</h2>
                        <p>Additional Small Box 6 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 6 Title</h2>
                        <p>Additional Small Box 6 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>-->
                
                
                
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection
