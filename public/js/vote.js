function vote(answerId, voteType) {
    //console.log("answerId:", answerId, "voteValue:", voteType);
    //sendAjaxRequest('post', '/answer/vote', { answer_id: answerId, vote: voteType });
    //sendAjaxRequest('post', '/answer/vote', { answer_id: 1, vote: 1 });
    sendAjaxRequest('post', '/answer/vote', { answer_id: answerId, vote: voteType });
    //console.log("answerId:", answerId, "voteValue:", voteType);
    updateVoteButtonStyles(answerId, voteType,1); //1 ->answer
}

function voteQuestion(questionId,voteType){
    const url = `/questions/${questionId}/vote`;
    sendAjaxRequest('post', url, { question_id: questionId, vote: voteType });
    updateVoteButtonStyles(questionId, voteType, 0); //0 ->question
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

function voteCommentQuestion(commentId, voteType) {
    sendAjaxRequest('post', `/comment_question/${commentId}/vote`, { comment_id: commentId, vote: voteType });
    updateVoteButtonStyles(commentId, voteType, 2); // 2 para comentários de perguntas
}

function removeVoteCommentQuestion(commentId) {
    sendAjaxRequest('post', `/comment_question/${commentId}/vote/remove`, { comment_id: commentId });
    document.querySelector(`#comment_question${commentId} .upvote-button`).classList.remove('active-vote');
    document.querySelector(`#comment_question${commentId} .downvote-button`).classList.remove('active-vote');
}


function updateVoteButtonStyles(entityId, voteType ,entityType) {
    //entityId é question id ou answer id
    //entityType     0->question  1->answer  2-> comment question
    let prefix = '';

    if(entityType === 0){
        prefix = '#question';
    }else if(entityType === 1){
        prefix = '#answer';
    }else if(entityType === 2){
        prefix = '#comment_question';
    }

    const upvoteButton = document.querySelector(prefix + entityId + ' .upvote-button');
    const downvoteButton = document.querySelector(prefix + entityId + ' .downvote-button');


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

function removeVoteQuestion(questionId) {
    const url = `/questions/${questionId}/vote/remove`;
    sendAjaxRequest('post', url, { question_id: questionId });
    document.querySelector(`#question${questionId} .upvote-button`).classList.remove('active-vote');
    document.querySelector(`#question${questionId} .downvote-button`).classList.remove('active-vote');
}
