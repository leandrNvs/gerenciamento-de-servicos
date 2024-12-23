const boxActionsContainer = document.querySelector('div.boxActions');
const deleteAction = boxActionsContainer.querySelector('a:nth-child(1)');
const updateAction = boxActionsContainer.querySelector('a:nth-child(2)');
const completeAction = boxActionsContainer.querySelector('a:nth-child(3)');

const sectionDeleteform = document.querySelector('section.section-delete');
const deleteForm = document.querySelector('form.delete-form');
const clientName = deleteForm.querySelector('b');

let activeLine = null;

window.addEventListener('click', function(e) {
    if(!e.target.classList.contains('boxActions') && activeLine) {
        activeLine.classList.remove('marked');
        boxActionsContainer.classList.remove('active');
    }

    if(!e.target.classList.contains('search_form')) {
      searchResults.classList.remove('active');
    }
});

function boxActions(ev, el) {
    ev.preventDefault();

    updateAction.href = el.dataset.update;    
    completeAction.href = el.dataset.complete;

    if(activeLine) activeLine.classList.remove('marked');

    el.classList.add('marked');

    deleteForm.action = el.dataset.delete;
    deleteForm.id.value = el.dataset.id;
    clientName.textContent = el.children[1].textContent;

    activeBoxActions(ev);

    activeLine = el;
}

deleteAction.addEventListener('click', function() {
    sectionDeleteform.classList.add('active');
});

function activeBoxActions(e)
{
    const scrollY = window.scrollY;
    const x = e.pageX;
    const y = e.pageY;

    boxActionsContainer.classList.add('active');

    boxActionsContainer.style.top = `${y - scrollY}px`;
    boxActionsContainer.style.left = `${x}px`;
}

const searchResults = document.querySelector('div.search-results');

async function filter(ev, el)
{
    if(el.value.length === 0) searchResults.classList.remove('active');

    const form = new FormData();
    form.append('search', el.parentElement.search.value);

    const res = await fetch(el.parentElement.action, {
      method: 'POST',
      body: form
    }); 

    const result = JSON.parse(await res.text());

    if(result) {
      searchResults.innerHTML = result;
      searchResults.classList.add('active');
    }
}
