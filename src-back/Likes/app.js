document.addEventListener('click', function(event) {

    var el = event.target;
    var actionClassName = 'action-like-post';

    if(el.parentNode.classList.contains(actionClassName)){
        el = el.parentNode;
    }

    // console.log(event.target.classList);
    // console.log(event.target.parentNode.classList);
    if ( ! el.classList.contains(actionClassName) ) { 
        return;
    }

    var postId = el.getAttribute("data-postid");

    var url = wpApiSettings.root + 'likes/' + postId;
    console.log(url);
    alert(postId);

});