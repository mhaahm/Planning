(function() {
    
    const url = window.location;
    let dialog = document.querySelector('.js-project-dialog');
    document.querySelector('.js-project-list').addEventListener('click',() => {
        if(typeof dialog.showModal =='function') {
            document.querySelector('#tab-projet').setAttribute("checked",1);
            dialog.showModal();
        } else {
            console.log("function not valid")
        }
    })
    
    document.querySelector('.js-close').addEventListener('click',()=> {
      dialog.close()  
    });

    document.querySelector(".js-task-list").addEventListener('click',() => {
        document.querySelector('#tab-taches').setAttribute("checked",1);
        dialog.showModal();
    });
    
    document.querySelector(".js-parameters").addEventListener('click',() => {
        document.querySelector('#tab-parametres').setAttribute("checked",1);
        dialog.showModal();
    });

    document.querySelector('.js-type-affichage').addEventListener('change', async (event) => {
        var typeAffichage = event.target.options[event.target.options.selectedIndex].value;
        let res = await fetch(url+"/planning.php?typeAffichage="+typeAffichage, {
            method: 'GET'
        });
        let result = await res.text();
        document.querySelector('.js-planning').innerHTML = result;
    });

    document.querySelector(".js-new-project").addEventListener("click",(event) => {
        document.querySelector('.js-newProject').style.display = 'flex';
        document.querySelector('.js-listProject').style.display = 'none';
    });

    document.querySelector(".js-show-project").addEventListener("click",(event) => {
        document.querySelector('.js-newProject').style.display = 'none';
        document.querySelector('.js-listProject').style.display = 'block';
    });

    document.querySelector('.js-save-project').addEventListener('click',async (event) => {
        // save
        let project_name = document.querySelector('#project-name').value;
        if(project_name == '') {
            alert('Project name is empty');
            return;
        }
        let start = document.querySelector('#project-start').value;
        if(start == '') {
            alert('Start date is empty');
            return;
        }
        let end = document.querySelector('#project-end').value;
        if(end == '') {
            alert('End date is empty');
            return;
        }
        let active = document.querySelector("#project-active:checked") != null ? 1:0;
        let finished = document.querySelector("#project-finished:checked") != null ? 1:0;
        let res = await fetch(url+'/saveProject.php',{
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                start,
                end,
                active,
                finished,
                title: project_name
            })
        })
        let result = await res.json();
        if(result.res == 'error') {

        } else {

        }
    });

})();
