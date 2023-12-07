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

  
  
console.log('ojhnkj.');
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

let deleteCommentButtons = document.querySelectorAll('#deleteCommentBtn');
console.log('Delete Comment Buttons:', deleteCommentButtons);

deleteCommentButtons.forEach(function(button) {
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
