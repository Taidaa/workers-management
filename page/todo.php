<html style="overflow: hidden;">
    <head>
    </head>
    <body>
        <style>
            ::-webkit-scrollbar{
                width: 0;
                background: transparent;
            }

            body, html {
                margin: 0;
                padding: 0;
                font-size: 2rem;
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                height: auto;
                color: white;
                text-shadow: wheat 0px 0px 3px;
                zoom: 65%;
            }

            button, a, input {
                cursor: pointer;
            }
            
            ul{ 
                width: 100%;
                list-style: none;
                padding: 0;
                box-sizing: border-box;
                box-shadow: #0002 3px 3px 5px;
                border-radius: 10px;
                overflow: hidden;
            }
            ul li{
                width: 100%;
                padding: 0.3rem 1.5rem 0.3rem 1.5rem;
                box-sizing: border-box;
                display: flex;
                align-items: center;
                background-color: rgba(255, 255, 255, 0.16);
                transition: 150ms;
            }

            li.checked {
                text-decoration: line-through;
                background: rgba(0, 255, 0, 0.5);
                box-shadow: rgba(0, 255, 0, 0.5) 0px 0px 20px;
            }

            ul li:hover, label:hover {
                background-color: rgba(255, 255, 255, 0.36);
                cursor: pointer;
                box-shadow: rgba(255, 255, 255, 0.36) 0px 0px 10px;
            }

            li:hover .delete-task, li:hover .arrow-holder {
                visibility: visible;
            }

            li.checked:hover {
                background: rgba(0, 200, 0, 0.5);
            }

            li input[type="checkbox"] {
                position: absolute;
                right: 3rem;
                height: 4em;
                width: 4em;
            }

            .arrow-holder {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                transform: translateX(100%);
                height: 100%;
                margin-right: 1.5em;
                visibility: hidden;
            }

            .arrow {
                background: transparent;
                border-top: transparent solid 1em;
                border-right: transparent solid 1em;
                border-bottom: transparent solid 1em;
                border-left: transparent solid 1em;
                padding: 0;
                width: 0;
                height: 0;
                margin: 0.5em 0;
            }

            .ar-up {
                border-bottom: rgba(0, 0, 0, 0.3) solid 1em;
            }

            .ar-up:hover {
                border-bottom: rgba(0, 0, 0, 0.2) solid 1em;
            }

            .ar-down {
                border-top: rgba(0, 0, 0, 0.3) solid 1em;
            }

            .ar-down:hover {
                border-top: rgba(0, 0, 0, 0.2) solid 1em;
            }
            
            label {
                display: flex;
                align-items: center;
            }
            
            label span {
                min-width: 1em;
                text-shadow: black 1px 0px 3px;
            }
            
            #add {
                position: relative;
                left: 50%;
                transform: translateX(-50%);
                font-size: 0.7rem;
                font-weight: bold;
                background: green;
                color: white;
                padding: 0.2rem;
                box-sizing: border-box;
                border-radius: 100%;
                width: 2em;
                height: 2em;
                border: none;
            }

            #add:hover {   
                background: greenyellow;     
                box-shadow: rgba(0, 255, 0, 0.5) 1px 0px 10px;
            }

            .delete-task {
                --size: 0.5em;
                font-size: 0.7em;
                line-height: 0;
                position: relative;
                display: inline-block;
                left: calc(0px - var(--size));
                height: var(--size);
                width: var(--size);
                border-radius: var(--size);
                border: none;
                background: rgba(255, 0, 0, 0.5);
                padding: 0.2em;
                box-sizing: content-box;
                color: white;
                visibility: hidden;
            }

            .delete-task::before {
                content: "x";
                font-size: 0.6em;
                font-weight: bold;
                text-shadow: white 0px 0px 5px;
                text-decoration: none !important;
            }

            .delete-task:hover {
                cursor: pointer;
                background: rgba(255, 0, 0, 1);
                box-shadow: rgba(255, 0, 0, 1) 1px 0px 10px;
            }

            #save {
                display: block;
                color: green;
                margin-left: auto;
                margin-right: auto;
                padding: 1rem 1.5rem;
                font-size: 1.6rem;
                border-radius: 10px;
                border-radius: 1.5rem;
                background: transparent;
                border: 1px solid green;
                transition: 200ms;
            }

            #save:hover {
                border: greenyellow 1px solid;
                box-shadow: greenyellow 0px 0px 10px;
                color: greenyellow;
                text-shadow: greenyellow 0 0 3px;
                cursor: pointer;
                transform: scale(1.01);
            }

            #tasksample {
                display: none;
                visibility: hidden;
            }

            fieldset {
                border: none;
                padding: 2rem 0rem;
            }
            
            legend {
                position: fixed;
                top: 0;
                width: 100%;
                text-align: center;
                z-index: 999;
                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 30px 30px 0px 0px;
                user-select: none;
            }
            
            button {
                user-select: none;
            }

            #status {
                font-size: 0.5em;
                position: relative;
                text-align: center;
                margin-top: 1.5rem;
                text-shadow: black 0px 0px 3px;
            }
        </style>
        <fieldset>

            <!-- THIS IS THE MAIN CONTENT -->
            <legend style="cursor: pointer; text-shadow: black 0px 0px 3px;" onclick="toggleVisibility()">TODO:</legend>
            <ul id="classlist">
                <li id="tasksample" class="list-item">
                    <button class="delete-task"></button>
                    <div class="arrow-holder">
                        <button class="arrow ar-up"  onclick="placeBefore(this.parentNode.parentNode)"></button>
                        <button class="arrow ar-down"  onclick="placeNext(this.parentNode.parentNode)"></button>
                    </div>
                    <label>
                        <span class="task-name" contenteditable="true" spellcheck="false">
                            ...
                        </span> 
                        <input type="checkbox">
                    </label>
                    
                    
                </li>
            </ul>
            <button id="add">+</button>
        </fieldset>
        <button id="save" onclick="Save()">Save</button>
        <div id="status"></div>
            <!-- END OF MAIN CONTENT -->
            
        <script>
            const addTask = document.body.querySelector("#add");
            const ul = document.body.querySelector("#classlist");
            const TaskSample = document.body.querySelector("#tasksample")

            // Add task to the list
            addTask.addEventListener("click", function (){
                let NewTask = TaskSample.cloneNode(true);
                ul.appendChild(NewTask);
                NewTask.removeAttribute("id");
            });

            document.body.addEventListener("click", function (e){
                let el = e.target;

                // Clicked on list item
                if (el.classList.contains("list-item")) {
                    let input = el.querySelector("input");
                    input.checked = !input.checked;
                    if (input.checked){
                        el.classList.add("checked");
                    } else {
                        el.classList.remove("checked")
                    }
            
                    return;
                }

                // Check if clicked on text
                if (el.tagName == "SPAN"){
                    let li = el.parentNode.parentNode;
                    let input =  li.querySelector("input");

                    if (!input.checked){
                        li.classList.add("checked");
                    } else {
                        li.classList.remove("checked")
                    }

                    return
                }

                // Check if clicked on flag
                if (el.tagName === "INPUT") {
                    let li = el.parentNode.parentNode;

                    if (el.checked){
                        li.classList.add("checked");
                    } else {
                        li.classList.remove("checked")
                    }
                }

                // Delete task from list
                if (el.classList.contains("delete-task")){
                    let li =  el.parentNode;
                    li.style.transform = "translateX(-100%)"
                    setTimeout(()=>li.remove(), 200);
                }
            });


            function placeNext(el){
                if (el.nextSibling == null) return
                el.style.transform = "translateY(100%)";
                el.nextSibling.style.transform = "translateY(-100%)";

                setTimeout(()=>{
                    let ul = el.parentNode;
                    ul.insertBefore(el.nextSibling, el);

                    el.style.transform = "";
                    el.previousSibling.style.transform = "";
                }, 200)
                

            }

            function placeBefore(el){
                if (el.previousElementSibling == document.querySelectorAll("li")[0]) return;
                el.style.transform = "translateY(-100%)";
                el.previousSibling.style.transform = "translateY(100%)";


                setTimeout(()=>{
                    let ul = el.parentNode;
                    ul.insertBefore(el, el.previousSibling);

                    el.style.transform = "";
                    el.nextSibling.style.transform = "";
                }, 200)
                
            }

            function Save(){
                let data = new Object;
                let tasks = document.querySelectorAll('li.list-item');
                let taskArr = [];
                tasks.forEach(task => {
                    if (task.id !== "tasksample"){
                        tsk = new Object;
                        tsk.name = task.querySelector('.task-name').innerText;
                        tsk.done = task.classList.contains('checked');
                        taskArr.push(tsk);    
                    }
                });

                data.tasks = taskArr; 
                SaveOnServer(data);
            }

            function SaveOnServer(data) {
                // Giving json to server side script
                let json = JSON.stringify(data);
                
                fetch('/php/savetodo.php', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: 'POST',
                    body: json
                })
                .then((res)=>{
                    if (res.status === 200){
                        document.querySelector('#status').innerText = 'Successfully saved!';

                        setTimeout(()=> {
                            document.querySelector('#status').innerText = '';
                        }, 4000);
                    }
                });
            }

            function toggleVisibility(){
                window.parent.ToggleTODO();
            }

            (function (){
                // Init todo list

                fetch('/json/todo.json').then((res)=>{
                    return res.text();
                }).then((tasks)=>{
                    let tasklist = JSON.parse(tasks).tasks;
                    
                    tasklist.forEach(task=>{
                        let NewTask = TaskSample.cloneNode(true);
                        let li = ul.appendChild(NewTask);
                        li.querySelector('.task-name').innerText = task.name;
                        if (task.done) {
                            li.classList.add('checked');
                        }
                        NewTask.removeAttribute("id");
                    })
                });
            })()
        </script>
    </body>
</html>