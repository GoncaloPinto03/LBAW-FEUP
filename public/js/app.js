
  
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
  /*
let likeButton = document.querySelector('#like-button');
let unlikeButton = document.querySelector('#unlike-button');
let dislikeButton = document.querySelector('#dislike-button');
let undislikeButton = document.querySelector('#undislike-button');
console.log('Like Button:', likeButton);
console.log('Unlike Button:', unlikeButton);


likeButton.addEventListener('click', function(e) {
  e.preventDefault();
  let form = e.target.closest('form');
  let articleId = form.querySelector('input[name="article_id"]').value;
  console.log('Like Button clicked!');
  console.log(articleId);

  sendAjaxRequest('POST', '/articles/' + articleId + '/like', null, function(response) {
        let responseData = JSON.parse(this.response);
        console.log(responseData);

        let likeCountElement = document.querySelector('#like-count');
        let reputationElement = document.querySelector('#reputation');
        let isLikeElement = document.querySelector('#like-button');

        console.log(likeCountElement);
        console.log(reputationElement);
        console.log(isLikeElement);

        if (likeCountElement) {
            likeCountElement.innerText = responseData.likeCount;
        }
        if (reputationElement) {
          reputationElement.innerHTML = '<strong>Author Reputation:</strong>' + responseData.userRep;
        }
        if (isLikeElement && responseData.isLike)
        {
          form.action = '/articles/' + articleId + '/unlike';
        }
  });
});*/

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
/*
let acceptTopicButtons = document.querySelectorAll('#acceptTopicProposalBtn');*/

let acceptTopicButtons = document.querySelectorAll('#acceptTopicProposalBtn');

acceptTopicButtons.forEach(function (button) {
  button.addEventListener('click', function (e) {
      e.preventDefault();
      let topicProposalId = e.target.closest('form').querySelector('input[name="topicproposal_id"]').value;
      console.log(topicProposalId);
      sendAjaxRequest('delete', `/admin/topicproposals/${topicProposalId}/accept`, {topicproposal_id: topicProposalId}, function () {
        console.log('Sent request');
        document.querySelector('#topicproposal'+topicProposalId).remove();
        console.log('Topic Proposal Removed');
      });
  });
});

let denyTopicButtons = document.querySelectorAll('#denyTopicProposalBtn');
console.log("denyButtons: ", denyTopicButtons);
denyTopicButtons.forEach(function (button) {
  button.addEventListener('click', function (e) {
      e.preventDefault();
      let topicProposalId = e.target.closest('form').querySelector('input[name="topicproposal_id"]').value;
      console.log(topicProposalId);
      sendAjaxRequest('delete', `/admin/topicproposals/${topicProposalId}/deny`, {}, function (response) {
        console.log('Sent request');
        document.querySelector('#topicproposal'+topicProposalId).remove();
        console.log('Topic Proposal Removed');
      });
  });
});


let favouriteButton = document.querySelector('#favouriteButton');
let iconSpan = document.getElementById('iconSpan');
let initialFavouriteState = iconSpan.getAttribute('data-is-favourite') === 'true';

console.log('Favourite Button:', favouriteButton);


favouriteButton.addEventListener('click', function(e) {
  e.preventDefault();
  console.log(initialFavouriteState);

    console.log('Favourite button clicked!');
    let form = e.target.closest('form');
    let articleId = form.querySelector('input[name="article_id"]').value;
    console.log('ArticleID:', articleId);

    sendAjaxRequest('POST', '/articles/' + articleId + '/mark-favourite', null, function() {
      console.log('Sent request');      

      initialFavouriteState = !initialFavouriteState;

      if (iconSpan && !initialFavouriteState) {
        iconSpan.innerHTML = '<i class="bi bi-star"></i>';
        console.log('Favourite removed');
      } 
      else {
        iconSpan.innerHTML = '<i class="bi bi-star-fill"></i>';
        console.log('Favourite added');
      }

    });

});








