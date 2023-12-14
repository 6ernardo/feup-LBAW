document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.vote-button').forEach(button => {
        button.addEventListener('click', function() {
            const answerId = this.dataset.answerId;
            const voteType = this.dataset.voteType;
            vote(answerId, voteType);
        });
    });
});

function vote(answerId, voteType) {
    let answer = document.querySelector('#answer' + answerId);
    if (!answer) {
        console.error('Elemento da resposta não encontrado:', answerId);
        return;
    }
    let voteCounter = answer.querySelector('#vote-count-' + answerId);

    sendAjaxRequest('post', '/answer/vote', { answer_id: answerId, vote: voteType }, function() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                try {
                    let responseData = JSON.parse(this.responseText);
                    voteCounter.innerText = responseData.newVoteCount;
                } catch (error) {
                    console.error("Erro ao analisar a resposta JSON:", error);
                    alert("Ocorreu um erro ao processar a votação.");
                }
            } else if (this.status === 409) {
                alert("Você já votou dessa maneira nesta resposta.");
            } else {
                alert("Erro ao processar o voto.");
            }
        }
    });
}

function sendAjaxRequest(method, url, data, callback) {
    let request = new XMLHttpRequest();
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.onreadystatechange = callback;
    request.send(encodeForAjax(data));
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}