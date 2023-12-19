function vote(answerId, voteType) {
    //console.log("answerId:", answerId, "voteValue:", voteType);
    //sendAjaxRequest('post', '/answer/vote', { answer_id: answerId, vote: voteType });
    //sendAjaxRequest('post', '/answer/vote', { answer_id: 1, vote: 1 });
    sendAjaxRequest('post', '/answer/vote', { answer_id: answerId, vote: voteType });
    console.log("answerId:", answerId, "voteValue:", voteType);
    updateVoteButtonStyles(answerId, voteType);
}

function sendAjaxRequest(method, url, data) {
    let request = new XMLHttpRequest();
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax(data));
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}


function updateVoteButtonStyles(answerId, voteType) {
    const upvoteButton = document.querySelector(`#answer${answerId} .upvote-button`);
    const downvoteButton = document.querySelector(`#answer${answerId} .downvote-button`);

    if (voteType == 1) {
        upvoteButton.classList.add('active-vote');
        downvoteButton.classList.remove('active-vote');
    } else if (voteType == -1) {
        downvoteButton.classList.add('active-vote');
        upvoteButton.classList.remove('active-vote');
    }
}

function removeVote(answerId) {
    sendAjaxRequest('post', '/answer/vote/remove', { answer_id: answerId });
    document.querySelector(`#answer${answerId} .upvote-button`).classList.remove('active-vote');
    document.querySelector(`#answer${answerId} .downvote-button`).classList.remove('active-vote');
}
