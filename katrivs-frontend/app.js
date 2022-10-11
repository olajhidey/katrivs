const app = document.getElementById("app");
let answer = ""

async function loadOnboard() {
    app.innerHTML = document.getElementById("onboard").innerHTML
    let username = app.querySelector("#username")
    let code = app.querySelector("#code")

    app.querySelector("button").addEventListener("click", (e) => {

        console.log("clicked!")
        e.preventDefault()
        let user = username.value
        let gameCode = code.value

        if (!user) {
            alert("Enter a valid username")
            return
        }

        if (!gameCode) {
            alert("Enter a valid game code")
            return
        }

        if (gameCode.length > 4) {
            alert("Enter a valid game code")
            return
        }

        const request = axios.post("https://token-gen.azurewebsites.net/api/GenToken", {
            username: user,
            code: gameCode
        }).then((res) => {
            window.localStorage.setItem("token", res.data.token)
            window.localStorage.setItem("username", user)
            window.localStorage.setItem("gameCode", gameCode)
            console.log(res)
            loadWaitingRoom(user, gameCode)
        })
    })
}

function loadWaitingRoom(user, gameCode) {
    app.innerHTML = document.getElementById("waitingRoom").innerHTML

    const token = window.localStorage.getItem("token")
    const gameClient = new SignalWire.Chat.Client({
        token: token
    })

    window.gameClient = gameClient;

    gameClient.on("message", (message) => {
        let response = JSON.parse(message.content)

        game_id = response.game_id

        if (response.start) {
            loadPlayground(gameCode, user, response.game_id)
        }
    })


    gameClient.subscribe([gameCode])

}

async function loadPlayground(gameCode, user, game_id) {

    app.innerHTML = document.getElementById("playground").innerHTML

    const token = window.localStorage.getItem("token")
    const gameClient = new SignalWire.Chat.Client({
        token: token
    })

    window.gameClient = gameClient;

    await gameClient.on("message", (message) => {

        const content = JSON.parse(message.content)

        let time = 10

        let clock = setInterval(function () {
            time = time - 1
            document.getElementById("timer").innerHTML = time
    
            if (time < 0) {
                clearInterval(clock)
                time = 10;
                document.getElementById("timer").innerHTML = "0"
            }
        }, 1000)

        if (content.status === "ended") {
            clearInterval(clock)
            console.log(game_id)
            saveScore(gameCode, game_id)
            loadResult()
        } else {
            console.log(content)
            document.getElementById("question").innerHTML = content.name
            document.getElementById("option1").innerHTML = content.option1
            document.getElementById("option2").innerHTML = content.option2
            document.getElementById("option3").innerHTML = content.option3
            document.getElementById("option4").innerHTML = content.option4
            answer = content.answer
        }
    })

    let time = 10

    let clock = setInterval(function () {
        time = time - 1
        document.getElementById("timer").innerHTML = time

        if (time < 0) {
            clearInterval(clock)
            time = 10;
            document.getElementById("timer").innerHTML = "0"
        }
    }, 1000)

    gameClient.subscribe([gameCode])
}

let score = 0;

function selectAnswer(selected){
    let choice = document.getElementById(selected).innerText
    
    if(choice.toLowerCase() === answer.toLowerCase()){
        score = score + 10
        console.log("you got this right")
    }else{
        if(score >= 10){
            score = score - 10
        }
        console.log("wrong answer")
    }
}

// load the get result template
async function loadResult() {
    
    app.innerHTML = document.getElementById("result").innerHTML
    console.log(score)
    let response = await loadLeaderBoard()
    console.log(response)
    
}

// Get list of users and their scores
async function loadLeaderBoard(){
    const code = window.localStorage.getItem("gameCode")
    const request = await axios.get(`http://127.0.0.1:8000/api/boards/${code}`)
    console.log(request.data)
    return request.data.data
}

// Save score to leaderboard function
async function saveScore(gameCode, game_id){
    let username = window.localStorage.getItem("username")
    
    let request = await axios.post("http://127.0.0.1:8000/api/board/create", {
        game_id: game_id,
        game_code: gameCode,
        score: score,
        username: username
    })

    console.log(request.data)

}

loadOnboard()