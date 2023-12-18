function vote(answerId, voteType) {
    //console.log("answerId:", answerId, "voteValue:", voteType);
    sendAjaxRequest('post', '/answer/vote', { answer_id: answerId, vote: voteType });
    //sendAjaxRequest('post', '/answer/vote', { answer_id: 1, vote: 1 });
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