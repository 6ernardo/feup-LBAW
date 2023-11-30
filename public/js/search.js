const searchQuestions = document.querySelector('#submitSearch')
if (searchQuestions) {
    searchQuestions.addEventListener('click', async function(event) {
        event.preventDefault();
        const search_query = document.getElementById('search_query').value;

        const response = await fetch('../search?search_query=' +  search_query);
        const questions = await response.json();

        const section = document.querySelector('#results');
        section.innerHTML = '';

        if(questions.length === 0){
            const msg = document.createElement('p');
            msg.textContent = 'No results found';

            section.appendChild(msg);
        }
        else {
            for(const question of questions){
                const link = document.createElement('a');
                link.href = '/questions/' + question.question_id;
                const h2 = document.createElement('h2');
                h2.textContent = question.title;
                const pdes = document.createElement('p');
                pdes.textContent = question.description;
                const ppont = document.createElement('p');
                ppont.textContent = question.score;
    
                link.appendChild(h2);
                link.appendChild(pdes);
                link.appendChild(ppont);
    
                section.appendChild(link);
            }
        }
    } )
}