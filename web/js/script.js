function updateComment(token, text) {

}

function enterListener(e){
    if(e.key === 'Enter'){
        let input = e.target,
            comment = input.closest('.comment'),
            token = comment.dataset.token,
            text = input.innerText; //@todo refactor innerText

        input.contentEditable = "false";
        updateComment(token, text);
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

    if (editBtn) {
        let editField = comment.querySelector('.comment-text');
        editBtn.addEventListener("click", () => editText(editField));
    }
})
