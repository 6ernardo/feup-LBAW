



const searchQuestions = document.querySelector('#submitSearch')
if (searchQuestions) {
    searchQuestions.addEventListener('click', async function(event) {
        event.preventDefault();
        const search_query = document.getElementById('search_query').value;

        const response = await fetch('../search?search_query=' +  search_query);
        const questions = await response.json();

        const section = document.querySelector('#results');
        section.innerHTML = '';



        
        for(const question of questions){
            const h2 = document.createElement('h2');
            h2.textContent = question.title;
            const pdes = document.createElement('p');
            pdes.textContent = question.description;
            const ppont = document.createElement('p');
            ppont.textContent = question.score;

            section.appendChild(h2);
            section.appendChild(pdes);
            section.appendChild(ppont);
        }


        /*
        for(const question of questions){


            const ul = document.createElement('ul');
            const link = document.createElement('a');
            link.href = '../pages/ticket.php?id=' + ticket.id;
            const subject = document.createElement('li');
            subject.textContent = ticket.subject;
            const department = document.createElement('li');
            department.textContent = ticket.department_id;
            const status = document.createElement('li');
            status.textContent = ticket.status_id;

            link.appendChild(subject);
            link.appendChild(department);
            link.appendChild(status);

            ul.appendChild(link);

            section.appendChild(ul);
        }*/
    } )
}