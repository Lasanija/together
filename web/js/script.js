 async function updateComment(token, text) {
     const url = '/ajax_comment_handler.php';
     const data = {token:token,text:text};
     try {
         const response = await fetch(url, {
             method: 'POST',
             body: JSON.stringify(data),
             headers: {
                 'Content-Type': 'application/json'
             }
         });
         const json = await response.json();
         console.log(JSON.stringify(json));
     } catch (error) {
         console.error(error);
     }
 }

 async function deleteComment(comment){
     comment.style.display = 'none';
     const url = '/ajax_comment_delete.php';
     let token  = comment.dataset.token;

     try {
         const response = await fetch(url, {
             method: 'POST',
             body: JSON.stringify(token),
             headers: {
                 'Content-Type': 'application/json'
             }
         });
         const json = await response.json();
         console.log(json);
     } catch (error) {
         console.error(error);
    comment.style.display = 'block';
     }
 }

function enterListener(e){
    if(e.key === 'Enter'){
        let input = e.target,
            comment = input.closest('.comment'),
            token = comment.dataset.token,
            text = input.innerText; //@todo refactor innerText

        input.contentEditable = "false";
       updateComment(token, text).then(r => {});
        e.target.removeEventListener('keypress', enterListener,false)
    }
}

function editText(editField) {
    editField.contentEditable = "true";
    editField.focus();
    editField.addEventListener('keypress', enterListener,false)
}

document.querySelectorAll('.comment').forEach(comment => {
    let editBtn = comment.querySelector('.edit');
    let deleteBtn = comment.querySelector('.delete')

    if (editBtn) {
        let editField = comment.querySelector('.comment-text');
        editBtn.addEventListener("click", () => editText(editField));
    }

    if (deleteBtn){
        let comment =  deleteBtn.closest('.comment');
        deleteBtn.addEventListener("click", ()=> deleteComment(comment))
    }
})
