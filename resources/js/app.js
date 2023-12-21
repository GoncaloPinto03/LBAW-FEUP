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
    //console.log(item);
    //et element = document.querySelector('li.item[data-id="' + item.id + '"]');
    //element.remove();
}

  
  
console.log('ojhnkj.');
let deleteButtons = document.querySelectorAll('#deleteArticleBtn');
console.log('Delete Buttons:', deleteButtons);

deleteButtons.forEach(function(button) {
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
  /*
let likeButton = document.querySelector('#like-button');
let unlikeButton = document.querySelector('#unlike-button');
let dislikeButton = document.querySelector('#dislike-button');
let undislikeButton = document.querySelector('#undislike-button');
console.log('Like Button:', likeButton);
console.log('Unlike Button:', unlikeButton);


likeButton.addEventListener('click', function(e) {
  e.preventDefault();
  let articleId = e.target.closest('form').querySelector('input[name="article_id"]').value;
  console.log('Like Button clicked!');
  console.log(articleId);

  sendAjaxRequest('POST', '/articles/' + articleId + '/like', null, function() {
    try {
        let responseData = JSON.parse(this.responseText);
        console.log(responseData);

        let likeCountElement = document.querySelector('#like-count');
        if (likeCountElement) {
            likeCountElement.innerText = responseData.likeCount;
        }

    } catch (error) {
        console.error('Error parsing server response:', error);
    }
  });
});*/