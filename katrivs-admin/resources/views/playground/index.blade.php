<div class="container">

    <fieldset style="margin: auto; max-width: 600px; text-align: center;">
        <a href="{{ route('game.view', ['id'=> $trivia->id]) }}">Back</a>
        <h3>{{ $trivia->title }}</h3>
        <p>{{ $trivia->description }}</p>
        <p>Copy the generated code and give to players to login </p>
        <h1>{{$code}}
            <button onclick="copy({{$code}})">Copy</button>
        </h1>

        <p>
            <button onclick="start({{$code}}, {{$trivia->id}})">Start Game</button>
        </p>

    </fieldset>

</div>

<script src="https://unpkg.com/@signalwire/js@3.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

    function copy(code) {
        console.log(code)
        navigator.clipboard.writeText(code)
        alert(code + " Copied!!")
    }

    async function start(code, id) {

        const data = await getQuestions(id)

        const started = await saveGameHistory(code, id)

        console.log(started)

        console.log(data)

        const url = "https://token-gen.azurewebsites.net/api/GenToken"
        const request = await axios.post(url, {
            username: "admin",
            code: code
        })

        const token = request.data.token

        const gameClient = new SignalWire.Chat.Client({
            token: token
        })

        window.gameClient = gameClient;

        const game = await gameClient.publish({
            channel: code,
            content: JSON.stringify({
                start: true,
                game_id: data.game.id
            })
        })

        let i = 0;
        let questions = data.questions

        console.log("starting interval")
        let timer = setInterval(async function () {
            if (i !== questions.length) {
                await gameClient.publish({
                    channel: code,
                    content: JSON.stringify(questions[i++])
                })

                console.log(i, new Date().toLocaleTimeString())

            } else {
                console.log("ending interval", new Date().toLocaleTimeString())
                await gameClient.publish({
                    channel: code,
                    content: JSON.stringify({
                        status: "ended"
                    })
                })
                clearInterval(timer)
            }

        }, 10000)

        console.log("-----Game has started------")

        const ended = await gameEnded(code, id)
        console.log(ended)
        console.log("----- Game has ended--------")
    }

    async function getQuestions(id) {
        const url = `http://127.0.0.1:8000/api/games/${id}`
        const request = await axios.get(url)
        return request.data
    }

    async function saveGameHistory(code, id) {

        try {
            const url = `http://127.0.0.1:8000/api/player/${id}`;
            const request = await axios.post(url, {
                status: 0,
                code: code
            })
            return request.data
        } catch (e) {
            console.log(e)
        }
    }

    async function gameEnded(code, id) {

        try {
            const url = `http://127.0.0.1:8000/api/player/${id}`
            const request = await axios.put(url, {
                status: 1,
                code: code
            })
            return request.data
        } catch (e) {
            console.log(e)
        }

    }
</script>
