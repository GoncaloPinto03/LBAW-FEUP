/*function addEventListeners() {
    let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
    [].forEach.call(itemCheckers, function(checker) {
      checker.addEventListener('change', sendItemUpdateRequest);
    });
  
    let itemCreators = document.querySelectorAll('article.card form.new_item');
    [].forEach.call(itemCreators, function(creator) {
      creator.addEventListener('submit', sendCreateItemRequest);
    });
  
    let itemDeleters = document.querySelectorAll('article.card li a.delete');
    [].forEach.call(itemDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteItemRequest);
    });
  
    let cardDeleters = document.querySelectorAll('article.card header a.delete');
    [].forEach.call(cardDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteCardRequest);
    });
  
    let cardCreator = document.querySelector('article.card form.new_card');
    if (cardCreator != null)
      cardCreator.addEventListener('submit', sendCreateCardRequest);
  }*/
  
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}
  
function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}
  


  
function articleDeletedHandler() {
    //if (this.status != 200) window.location = '/';
    //let item = JSON.parse(this.responseText);
    //let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    //element.remove();
}

  
  
let deleteArticleButtons = document.querySelectorAll('#deleteArticleBtn');
console.log('Delete Buttons:', deleteArticleButtons);

deleteArticleButtons.forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        let articleId = e.target.closest('form').querySelector('input[name="article_id"]').value;
        console.log('Button clicked! Article ID:', articleId);
        sendAjaxRequest('delete', '/article/delete/', { article_id: articleId }, function() {
          console.log('Sent request');
          document.querySelector('#article'+articleId).remove();
          console.log('Article Removed');
        });
    });
});

let deleteCommentButtonsMyArticle = document.querySelectorAll('#deleteCommentBtn');
console.log('Delete Comment Buttons:', deleteCommentButtonsMyArticle);

deleteCommentButtonsMyArticle.forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        let commentId = e.target.closest('form').querySelector('input[name="comment_id"]').value;
        console.log('Delete Comment Button clicked! Comment ID:', commentId);
        sendAjaxRequest('delete', '/comment/delete/', { comment_id: commentId }, function() {
          console.log('Sent request');
          document.querySelector('#comment'+commentId).remove();
          console.log('Comment Removed');
        });
    });
});

let deleteCommentButtonsOtherArticle = document.querySelectorAll('#deleteCommentBtn2');
console.log('Delete Comment Buttons:', deleteCommentButtonsOtherArticle);

deleteCommentButtonsOtherArticle.forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        let commentId = e.target.closest('form').querySelector('input[name="comment_id2"]').value;
        console.log('Delete Comment Button clicked! Comment ID:', commentId);
        sendAjaxRequest('delete', '/comment/delete/', { comment_id: commentId }, function() {
          console.log('Sent request');
          document.querySelector('#comment'+commentId+'_2').remove();
          console.log('Comment Removed');
        });
    });
});
/*
let acceptTopicButtons = document.querySelectorAll('#acceptTopicProposalBtn');

acceptTopicButtons.forEach(function (button) {
  button.addEventListener('click', function (e) {
      e.preventDefault();
      let topicProposalId = e.target.closest('form').querySelector('input[name="topicproposal_id"]').value;
      sendAjaxRequest('delete', `/admin/topicproposals/${topicProposalId}/accept`, {topicproposal_id: topicProposalId}, function () {
        console.log('Sent request');
        document.querySelector('#topicproposal'+topicProposalId).remove();
        console.log('Topic Proposal Removed');
      });
  });
});

let denyTopicButtons = document.querySelectorAll('#denyTopicProposalBtn');
denyTopicButtons.forEach(function (button) {
  button.addEventListener('click', function (e) {
      e.preventDefault();
      let topicProposalId = e.target.closest('form').querySelector('input[name="topicproposal_id"]').value;
      sendTopicProposalRequest(`/admin/topicproposals/${topicProposalId}/deny`, {}, function (response) {
          console.log(response);
          // Handle success, e.g., update UI or show a notification
      });
  });
});
*/