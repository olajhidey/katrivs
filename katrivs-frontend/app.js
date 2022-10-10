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
        if (message.content === "start") {
            loadPlayground(gameCode, user)
        }
    })


    gameClient.subscribe([gameCode])

}

function loadPlayground(gameCode, user) {

    app.innerHTML = document.getElementById("playground").innerHTML

    const token = window.localStorage.getItem("token")
    const gameClient = new SignalWire.Chat.Client({
        token: token
    })

    window.gameClient = gameClient;

    gameClient.on("message", (message) => {

        const content = JSON.parse(message.content)

        if (content.status === "ended") {
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
        console.log("wrong answer")
    }
}

function loadResult() {
    console.log(score)
    app.innerHTML = document.getElementById("result").innerHTML
    
}

loadOnboard()