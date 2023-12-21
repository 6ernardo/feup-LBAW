const searchQuestions = document.querySelector('#submitSearch')
if (searchQuestions) {
    searchQuestions.addEventListener('click', async function(event) {
        event.preventDefault();
        const search_query = document.getElementById('search_query').value;
        const orderby = document.getElementById('orderby').value;

        const response = await fetch('../search?search_query=' +  search_query + '&orderby=' + orderby);
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


const searchUsers = document.querySelector('#submitUserSearch')
if(searchUsers) {
    searchUsers.addEventListener('click', async function(event) {
        event.preventDefault();
        const search_query = document.getElementById('user_search_query').value;

        const response = await fetch('../search/users?user_search_query=' +  search_query);
        const users = await response.json();

        const section = document.querySelector('#user_listing');
        section.innerHTML = '';

        if(users.length === 0){
            const msg = document.createElement('p');
            msg.textContent = 'No results found';

            section.appendChild(msg);
        }
        else {
            for(const user of users){
                const article = document.createElement('article');
                article.className = 'user';
                const ul1 = document.createElement('ul');
                const link1 = document.createElement('a');
                link1.href = '/user/' + user.user_id;
                const name = document.createElement('li');
                name.textContent = user.name;
                const userid = document.createElement('li');
                userid.textContent = '#' + user.user_id;
                const email = document.createElement('li');
                email.textContent = user.email;
                const role = document.createElement('li');
                if(user.is_moderator == false){
                    role.textContent = 'User';
                }
                else role.textContent = 'Moderator';

                link1.appendChild(name);
                link1.appendChild(userid);
                link1.appendChild(email);
                link1.appendChild(role);

                ul1.appendChild(link1);

                article.appendChild(ul1);

                section.appendChild(article);
            }
        }
    } )
}

function openFilters(){
    document.getElementById("filters_popup").style.display = "block";
}

function closeFilters(){
    document.getElementById("filters_popup").style.display = "none";
}