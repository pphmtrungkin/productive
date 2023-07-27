window.addEventListener('load', ()=> {
    const form = document.querySelector("#todo-form");
    const input = document.querySelector("#todo-input");
    const list_el = document.querySelector(".todo-list");
    const body = document.getElementsByTagName("body")[0];

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const value = input.value;
        let list_item = document.createElement("li");
        list_item.classList.add("todo-item");
        list_el.appendChild(list_item);

        let iconElement = document.createElement("i");
        iconElement.classList.add("bi");
        iconElement.classList.add("bi-circle");
        iconElement.classList.add("check-icon");

        const mouseOverCheckIcon= () => {
            iconElement.classList.remove("bi-circle");
            iconElement.classList.add("bi-check-circle");
        };
        const mouseLeaveCheckIcon= ()=> {
            iconElement.classList.remove("bi-check-circle");
            iconElement.classList.add("bi-circle");
        };
        
        iconElement.addEventListener('mouseover', mouseOverCheckIcon);
        
        iconElement.addEventListener('mouseleave', mouseLeaveCheckIcon);
        let isCheckRunning = false;

        
        list_item.appendChild(iconElement);
        
        let taskContent = document.createElement("input");
        taskContent.type = "text";
        taskContent.value = value;
        taskContent.setAttribute("readonly", "");
        taskContent.classList.add("task-input");
        list_item.appendChild(taskContent);
        
        iconElement.addEventListener('click', ()=>{
            if(isCheckRunning==false){
                iconElement.classList.remove("bi-circle");
                iconElement.classList.add("bi-check-circle");
                iconElement.removeEventListener('mouseleave', mouseLeaveCheckIcon);
                taskContent.classList.toggle("checked");
                isCheckRunning=true;
            } else if(isCheckRunning==true){
                taskContent.classList.remove("checked");
                iconElement.classList.remove("bi-check-circle");
                iconElement.classList.add("bi-circle");
                iconElement.addEventListener('mouseover', mouseOverCheckIcon);
                iconElement.addEventListener('mouseleave', mouseLeaveCheckIcon);
                isCheckRunning=false;
            }
        })

        let taskBtnSection = document.createElement("div");
        taskBtnSection.classList.add("task-btn-section");
        list_item.appendChild(taskBtnSection);


        let editBtn = document.createElement("button");
        editBtn.innerHTML="Edit";
        editBtn.type="button";
        editBtn.classList.add("task-btn");
        editBtn.classList.add("edit-btn");
        taskBtnSection.appendChild(editBtn);

        let deleteBtn = document.createElement("button");
        deleteBtn.innerHTML="Delete";
        deleteBtn.type="button";
        deleteBtn.classList.add("task-btn");
        deleteBtn.classList.add("delete-btn");
        taskBtnSection.appendChild(deleteBtn);

        input.value="";

        editBtn.addEventListener('click', () => {
            if(editBtn.textContent=="Save"){
                if(taskContent.value==""){
                    alert("You should type something in this input.");
                } else {
                    taskContent.setAttribute("readonly", "");
                    editBtn.textContent="Edit";
                }
                return;
            }
            taskContent.removeAttribute("readonly");
            taskContent.focus();
            editBtn.textContent="Save";
        })

        deleteBtn.addEventListener('click', ()=> {
            list_el.removeChild(list_item);
        })
    })
    
    const pomodoroMode = {
        'Pomodoro': 1500,
        'Short break': 300,
        'Long break': 900,
    }
    const modeBackground = {
        'Pomodoro': `var(--red)`,
        'Short break': `var(--green)`,
        'Long break': `var(--blue)`,
    }

    let mode = "Pomodoro";
    let remainingTime = pomodoroMode[mode];
    let isClockTicking = false;
    let numberOfSession = 0;

    let pomodoroTimer = document.querySelector("#pomodoro-timer");
    let startButton = document.querySelector("#pomodoro-start");
    let pauseButton = document.querySelector("#pomodoro-pause");
    let restartButton = document.querySelector("#pomodoro-restart");

    
    let modeButtons = document.getElementsByClassName("mode-btn");
    let controlButtons = document.getElementsByClassName("control-btn");
    var buttonSound = new Audio();
    
    for(let i=0;i<3;i++){
        modeButtons[i].addEventListener('click', ()=>{
            buttonSound.src = './src/button-sound.mp3';
            buttonSound.play();
            if(isClockTicking==true){
                stopTimer();
                startButton.style.display="initial";
            }
            for(let j=0;j<3;j++){
                modeButtons[j].classList.remove("active");
                controlButtons[j].style.color = modeBackground[modeButtons[i].innerText]
            }
            modeButtons[i].classList.add("active");
            remainingTime = pomodoroMode[modeButtons[i].innerText];
            body.style.backgroundColor= modeBackground[modeButtons[i].innerText];
            displayTimer();  
        })
    }
    
    const switchMode = () => {
        if(mode=='Pomodoro'){
            numberOfSession++;
            if(numberOfSession==3){
                mode="Long break";
                numberOfSession=0;
            } else {
                mode="Short break";
            }
        } else if(mode=="Short break"){
            mode="Pomodoro";
        }
        for(let i=0;i<3;i++){
            modeButtons[i].classList.remove("active");
            if(modeButtons[i].innerText==mode){
                modeButtons[i].classList.add("active");
                remainingTime = pomodoroMode[mode];
                body.style.backgroundColor= modeBackground[modeButtons[i].innerText];    
                displayTimer();
            }
        }
    }
    
    const displayTimer = () => {
        const minutes = Math.floor(remainingTime/ 60);
        const seconds = remainingTime % 60;
        const formattedTime = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
        pomodoroTimer.innerHTML= formattedTime;
    }
    
    displayTimer();
    
    startButton.addEventListener('click', () => {
        buttonSound.src = './src/button-press.mp3';
        buttonSound.play();
        if(isClockTicking==false){
            timeStart = setInterval(() => {
                remainingTime--;
                displayTimer();
                if(remainingTime==0){
                    buttonSound.src = './src/alarm-kitchen.mp3';
                    buttonSound.play();
                    switchMode();
                    stopTimer();
                }
            }, 1000);
            isClockTicking=true;
            startButton.style.display="none";
        }
    })
    
    const stopTimer = () => {
        clearInterval(timeStart);
        isClockTicking=false;
        startButton.style.display="initial";
    }
    pauseButton.addEventListener('click', ()=> {
        stopTimer();
        buttonSound.src = './src/button-press.mp3';
        buttonSound.play();
        startButton.style.display="initial";
    });
    restartButton.addEventListener('click', ()=> {
        buttonSound.src = './src/button-press.mp3';
        buttonSound.play();
        if(isClockTicking==false){
            for(let i=0;i<3;i++){
                if(modeButtons[i].classList.contains("active")){
                    remainingTime = pomodoroMode[modeButtons[i].innerText];
                    displayTimer();
                }
            }
        } else if(isClockTicking==true){
            stopTimer();
            for(let i=0;i<3;i++){
                if(modeButtons[i].classList.contains("active")){
                    remainingTime = pomodoroMode[modeButtons[i].innerText];
                    displayTimer();
                    startButton.style.display="initial";
                }
            }
        }
    })
})

let currentPath = window.location.pathname;
loginFile = `./login.html`;
if(currentPath===loginFile){
    let header = document.getElementsByTagName("header")[0];
    header.style.display="none";
}