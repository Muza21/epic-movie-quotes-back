<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie quotes</title>
</head>
<style>
    body {
        background-color: #222030;
    }

    div {
        font-size: 18px;
        line-height: 18px;
        width: 343px;
    }

    h1 {
        color: #DDCCAA;
    }


    header {
        width: 300px;
        margin-left: auto;
        margin-right: auto;
        display: flex;
        flex-direction: column;
        justify-items: center;
    }



    .container {
        width: 1200px;
        color: white;
        margin: 100px auto;
    }

    .text {
        margin-top: 32px;
    }

    #icon {
        width: 30px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 80px;
    }

    #button {
        display: inline-block;
        padding: 1em 3em;
        border-radius: 5px;
        text-decoration: none;
        margin: 0 auto;
        color: white;
        background-color: #E31221;
    }

    #link {
        color: #DDCCAA;
    }

    @media all and (min-width:0px) and (max-width: 1000px) {
        .container {
            width: 100%;
            color: white;
            margin: 50px 5px
        }
    }
</style>

<body>
    <main>
        <header>
            <div id="icon">
                <img src="{{ asset('assets/IconChat.svg') }}" alt="">

            </div>
            <h1>MOVIE QUOTES</h1>
        </header>
        <div class="container">

            <p class="text">
                To recover password click the button below:
            </p>
            <div class="button">
                <a id="button"
                    href="http://127.0.0.1:5173/new-password?email={{ $data['email'] }}&token={{ $data['token'] }}">
                    Reset password
                </a>
            </div>
            <p class="text">If clicking doesn't work, you can try copying and pasting it to your browser:</p>
            <a id="link"
                href="http://127.0.0.1:5173/new-password?email={{ $data['email'] }}&token={{ $data['token'] }}">http://127.0.0.1:5173/new-password?email={{ $data['email'] }}&token={{ $data['token'] }}</a>
            <p class="text">If you have any problems, please contact us: support@moviequotes.ge</p>
            <p class="text">MovieQuotes Crew</p>
        </div>
    </main>
</body>

</html>
