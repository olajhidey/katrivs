const app = document.getElementById("app");
let answer = ""
let local = "http://127.0.0.1:8000/api/"
let tunnel = "https://ce00-102-89-46-196.ngrok.io/api/"

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

async function loadWaitingRoom(user, gameCode) {
    app.innerHTML = document.getElementById("waitingRoom").innerHTML

    const token = window.localStorage.getItem("token")
    const gameClient = new SignalWire.Chat.Client({
        token: token
    })

    window.gameClient = gameClient;

    await gameClient.on("message", async (message) => {
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


    let time = 10

    let clock = setInterval(function () {
        time = time - 1
        document.getElementById("clock").innerHTML = time
        console.log(time)

        if (time == 0) {
            document.getElementById("starter").style.display = "none"
            document.getElementById("playCanva").style.display = "block"
            clearInterval(clock)
        }
    }, 1000)


    const token = window.localStorage.getItem("token")
    const gameClient = new SignalWire.Chat.Client({
        token: token
    })

    window.gameClient =  gameClient

    await gameClient.on("message", async (message) => {

        const content = JSON.parse(message.content)

        let option1 = document.getElementById("option1")
        let option2 = document.getElementById("option2")
        let option3 = document.getElementById("option3")
        let option4 = document.getElementById("option4")

        option1.disabled = false;
        option1.classList.remove("is-disabled")
        option2.disabled = false;
        option2.classList.remove("is-disabled")
        option3.disabled = false;
        option3.classList.remove("is-disabled")
        option4.disabled = false;
        option4.classList.remove("is-disabled")

        let time = 10

            let clock = setInterval(function () {
              

                let tag = document.getElementById("timer")

                if(tag === null){
                    clearInterval(clock)
                }else{
                    time = time - 1
                    document.getElementById("timer").innerHTML = time
                }
              
                if(content.status === "ended"){
                    clearInterval(clock)
                }

                if (time == 0) {
                    clearInterval(clock)
                    time = 10;
                    document.getElementById("timer").innerHTML = "10"
                }
                
               
            }, 1000)


        if (content.status === "ended") {
            // await gameClient.unsubscribe([gameCode])
            saveScore(gameCode, game_id)
            loadResult()
        } else {

            console.log(content)

            // document.getElementById("option2").style.display = "block"

            document.getElementById("question").innerHTML = content.name

            // document.getElementById("option2").innerHTML = content.option2

            if (content.option1 == null) {
                document.getElementById("option1").style.display = "none"
            } else {
                document.getElementById("option1").style.display = "block"
                document.getElementById("option1").innerHTML = content.option1
            }

            if (content.option2 == null) {
                document.getElementById("option2").style.display = "none"
            } else {
                document.getElementById("option2").style.display = "block"
                document.getElementById("option2").innerHTML = content.option2
            }

            if (content.option3 == null) {
                document.getElementById("option3").style.display = "none"
            } else {
                document.getElementById("option3").style.display = "block"
                document.getElementById("option3").innerHTML = content.option3
            }

            if (content.option4 == null) {
                document.getElementById("option4").style.display = "none"
            } else {
                document.getElementById("option4").style.display = "block"
                document.getElementById("option4").innerHTML = content.option4
            }

            answer = content.answer
        }
    })


    gameClient.subscribe([gameCode])
}

let score = 0;

function selectAnswer(selected) {
    let choice = document.getElementById(selected).innerText

    let option1 = document.getElementById("option1")
    let option2 = document.getElementById("option2")
    let option3 = document.getElementById("option3")
    let option4 = document.getElementById("option4")

    option1.disabled = true
    option1.classList.add("is-disabled")
 
    option2.disabled = true
    option2.classList.add("is-disabled")
 
    option3.disabled = true
    option3.classList.add("is-disabled")
 
    option4.disabled = true
    option4.classList.add("is-disabled")
 


    if (choice.toLowerCase() === answer.toLowerCase()) {
        score = score + 10
        console.log("you got this right")
    } else {
        if (score >= 10) {
            score = score - 10
        }
        console.log("wrong answer")
    }
}

// load the get result template
async function loadResult() {
    app.innerHTML = document.getElementById("result").innerHTML
    console.log(score)
    setTimeout(async function () {
        let response = await loadLeaderBoard()

        let list = document.getElementById("list");
        document.getElementById("loader").style.display = "none"

        response.forEach(element => {
            let html = ""
            html = "<tr><td>" + element.username + "</td><td>" + element.score + "</td></tr>"
            list.innerHTML += html
        });

    }, 7000)

}

// Get list of users and their scores
async function loadLeaderBoard() {
    const code = window.localStorage.getItem("gameCode")
    const request = await axios.get(`${tunnel}boards/${code}`)
    return request.data.data
}

// Save score to leaderboard function
async function saveScore(gameCode, game_id) {
    let username = window.localStorage.getItem("username")

    let request = await axios.post(`${tunnel}board/create`, {
        game_id: game_id,
        game_code: gameCode,
        score: score,
        username: username
    })

    console.log(request.data)

}

loadOnboard()